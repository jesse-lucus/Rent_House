<?php

namespace App\Jobs;

use DB;
use DateTime;
use App\Models\User;
use App\Models\SyncUser;
use Illuminate\Support\Str;
use Illuminate\Bus\Queueable;
use App\Services\DevcoService;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SyncUsersJob implements ShouldQueue
{
	use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

	/**
	 * Create a new job instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		//
	}

	public $tries = 5;

	public $timeout = 600;

	/**
	 * Execute the job.
	 *
	 * @return void
	 */
	public function handle()
	{
		//////////////////////////////////////////////////
		/////// User Sync
		/////

		/// get last modified date inside the database
		/// PHP 7.3 will fix issue with PDO not recognizing the milisecond precision
		/// PHP 7.2X and lower instead drops the milisecond off.
		/// Most php apps operate at the precision of whole seconds. However Devco operates at a TimeStamp(3) precision.
		/// To get the full time stamp out of the Allita DB, we trick the query into thinking it is a string.
		/// To do this we use the DB::raw() function and use CONCAT on the column.
		/// We also need to select the column so we can order by it to get the newest first. So we apply an alias to the concated field.

		$lastModifiedDate = SyncUser::select(DB::raw("CONCAT(last_edited) as 'last_edited_convert'"), 'last_edited', 'id')->orderBy('last_edited', 'desc')->first();
		// if the value is null set a default start date to start the sync.
		if (is_null($lastModifiedDate)) {
			$modified = '10/1/1900';
		} else {
			// format date stored to the format we are looking for...
			// we resync the last second of the data to be sure we get any records that happened to be recorded at the same second.
			$currentModifiedDateTimeStamp = strtotime($lastModifiedDate->last_edited_convert);
			settype($currentModifiedDateTimeStamp, 'float');
			$currentModifiedDateTimeStamp = $currentModifiedDateTimeStamp - .001;
			$modified = date('m/d/Y G:i:s.u', $currentModifiedDateTimeStamp);
			//dd($lastModifiedDate, $modified);
		}
		$apiConnect = new DevcoService();
		if (!is_null($apiConnect)) {
			$syncData = $apiConnect->listUsers(1, $modified, 1, 'admin@allita.org', 'System Sync Job', 1, 'Server');
			$syncData = json_decode($syncData, true);
			$syncPage = 1;
			//dd($syncData);
			//dd($lastModifiedDate->last_edited_convert,$currentModifiedDateTimeStamp,$modified,$syncData);
			if ($syncData['meta']['totalPageCount'] > 0) {
				do {
					$password = Str::random(15);
					$active = 0;
					if ($syncPage > 1) {
						//Get Next Page
						$syncData = $apiConnect->listUsers($syncPage, $modified, 1, 'admin@allita.org', 'System Sync Job', 1, 'Server');
						$syncData = json_decode($syncData, true);
						//dd('Page Count is Higher',$syncData,$syncData['meta']['totalPageCount'],$syncPage);
					}
					//dd('Page Count is Higher',$syncData,$modified,$syncData,$syncData['meta']['totalPageCount'],$syncPage);
					foreach ($syncData['data'] as $i => $v) {
						// check if record exists
						$updateRecord = SyncUser::select('id', 'allita_id', 'last_edited', 'updated_at')->where('devco_key', $v['attributes']['userKey'])->first();
						// convert booleans
						//settype($v['attributes']['ownerPaidUtilities'], 'boolean');
						// settype($v['attributes']['isUserHandicapAccessible'], 'boolean');
						if ($v['attributes']['userStatusKey'] > 0) {
							$active = 1;
						}
						// Set dates older than 1950 to be NULL:
						//  if($v['attributes']['acquisitionDate'] < 1951){
						//     $v['attributes']['acquisitionDate'] = NULL;
						// }
						// if($v['attributes']['buildingBuiltDate'] < 1951){
						//     $v['attributes']['buildingBuiltDate'] = NULL;
						// }
						// if($v['attributes']['confirmedDate'] < 1951){
						//     $v['attributes']['confirmedDate'] = NULL;
						// }
						// if($v['attributes']['onSiteMonitorEndDate'] < 1951){
						//     $v['attributes']['onSiteMonitorEndDate'] = NULL;
						// }
						//dd($updateRecord,$updateRecord->updated_at);
						if (isset($updateRecord->id)) {
							// record exists - get matching table record

							/// NEW CODE TO UPDATE ALLITA TABLE PART 1
							$allitaTableRecord = User::find($updateRecord->allita_id);
							/// END NEW CODE PART 1

							// convert dates to seconds and miliseconds to see if the current record is newer.
							$devcoDate = new DateTime($v['attributes']['lastEdited']);
							$allitaDate = new DateTime($updateRecord->last_edited);

							$allitaFloat = "." . $allitaDate->format('u');
							$devcoFloat = "." . $devcoDate->format('u');
							settype($allitaFloat, 'float');
							settype($devcoFloat, 'float');
							$devcoDateEval = strtotime($devcoDate->format('Y-m-d G:i:s')) + $devcoFloat;
							$allitaDateEval = strtotime($allitaDate->format('Y-m-d G:i:s')) + $allitaFloat;

							//dd($allitaTableRecord,$devcoDateEval,$allitaDateEval,$allitaTableRecord->last_edited, $updateRecord->updated_at);

							if ($devcoDateEval > $allitaDateEval) {
								if (!is_null($allitaTableRecord) && $allitaTableRecord->last_edited <= $updateRecord->updated_at) {
									// record is newer than the one currently on file in the allita db.
									// update the sync table first
									SyncUser::where('id', $updateRecord['id'])
										->update([

											'organization_key' => $v['attributes']['organizationKey'],
											'user_status_key' => $v['attributes']['userStatusKey'],
											'person_key' => $v['attributes']['personKey'],
											'organization_key' => $v['attributes']['organizationKey'],

											'organization' => $v['attributes']['organization'],

											'last_edited' => $v['attributes']['lastEdited'],
										]);
									$UpdateAllitaValues = SyncUser::find($updateRecord['id']);
									// update the allita db - we use the updated at of the sync table as the last edited value for the actual Allita Table.
									$allitaTableRecord->update([

										'organization_key' => $v['attributes']['organizationKey'],
										'organization_id' => null,
										'user_status_key' => $v['attributes']['userStatusKey'],
										'person_key' => $v['attributes']['personKey'],
										'person_id' => null,

										'organization' => $v['attributes']['organization'],
										'entity_type' => 'devco',

										'last_edited' => $UpdateAllitaValues->updated_at,
									]);
									//dd('inside.');
								} elseif (is_null($allitaTableRecord)) {
									// the allita table record doesn't exist
									// create the allita table record and then update the record
									// we create it first so we can ensure the correct updated at
									// date ends up in the allita table record
									// (if we create the sync record first the updated at date would become out of sync with the allita table.)

									$allitaTableRecord = User::create([

										'organization_key' => $v['attributes']['organizationKey'],
										'user_status_key' => $v['attributes']['userStatusKey'],
										'person_key' => $v['attributes']['personKey'],
										'organization_key' => $v['attributes']['organizationKey'],

										'organization' => $v['attributes']['organization'],
										'name' => $v['attributes']['login'],
										'email' => $v['attributes']['login'] . '@allita.org',
										'password' => bcrypt($password),
										'active' => $active,

										'entity_type' => 'devco',

										'devco_key' => $v['attributes']['userKey'],
									]);
									// Create the sync table entry with the allita id
									$syncTableRecord = SyncUser::create([

										'organization_key' => $v['attributes']['organizationKey'],
										'user_status_key' => $v['attributes']['userStatusKey'],
										'person_key' => $v['attributes']['personKey'],
										'organization_key' => $v['attributes']['organizationKey'],

										'organization' => $v['attributes']['organization'],

										'devco_key' => $v['attributes']['userKey'],
										'last_edited' => $v['attributes']['lastEdited'],
										'allita_id' => $allitaTableRecord->id,
									]);
									// Update the Allita Table Record with the Sync Table's updated at date
									$allitaTableRecord->update(['last_edited' => $syncTableRecord->updated_at]);
								}
							}
						} else {
							// Create the Allita Entry First
							// We do this so the updated_at value of the Sync Table does not become newer
							// when we add in the allita_id
							$allitaTableRecord = User::create([

								'devco_key' => $v['attributes']['userKey'],
								'organization_key' => $v['attributes']['organizationKey'],
								'user_status_key' => $v['attributes']['userStatusKey'],
								'person_key' => $v['attributes']['personKey'],
								'organization_key' => $v['attributes']['organizationKey'],

								'organization' => $v['attributes']['organization'],

								'name' => $v['attributes']['login'],
								'email' => $v['attributes']['login'] . '@allita.org',
								'password' => bcrypt($password),
								'active' => $active,

								'devco_key' => $v['attributes']['userKey'],
							]);
							// Create the sync table entry with the allita id
							$syncTableRecord = SyncUser::create([

								'organization_key' => $v['attributes']['organizationKey'],
								'user_status_key' => $v['attributes']['userStatusKey'],
								'person_key' => $v['attributes']['personKey'],
								'organization_key' => $v['attributes']['organizationKey'],

								'organization' => $v['attributes']['organization'],

								'devco_key' => $v['attributes']['userKey'],
								'last_edited' => $v['attributes']['lastEdited'],
								'allita_id' => $allitaTableRecord->id,
							]);
							// Update the Allita Table Record with the Sync Table's updated at date
							$allitaTableRecord->update(['last_edited' => $syncTableRecord->updated_at]);
						}
					}
					$syncPage++;
				} while ($syncPage <= $syncData['meta']['totalPageCount']);
			}
		}
	}
}
