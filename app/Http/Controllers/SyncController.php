<?php

namespace App\Http\Controllers;

use DB;
use DateTime;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Services\AuthService;
use App\Services\DevcoService;
use App\Models\AuthTracker;
use App\Models\SystemSetting;
//use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Console\Scheduling\Schedule;
use Log;
use Event;
use Auth;
use App\Models\Audit;
use App\Jobs\CreateTestAuditJob;

class SyncController extends Controller
{
    //
    public function associate($model, $lookUpModel, $associations)
    {
        foreach ($associations as $associate) {
            $updates = $model::select($associate['look_up_reference'])
                        ->whereNull($associate['null_field'])
                        ->where($associate['look_up_reference'], $associate['condition_operator'], $associate['condition'])
                        ->groupBy($associate['look_up_reference'])
                        //->toSQL();
                        ->get()->all();
            //dd($updates);
            foreach ($updates as $update) {
                //lookup model
                //dd($update,$update->{$associate['look_up_reference']});
                $key = $lookUpModel::select($associate['look_up_foreign_key'])
                ->where($associate['lookup_field'], $update->{$associate['look_up_reference']})
                ->first();
                if (!is_null($key)) {
                    $model::whereNull($associate['null_field'])
                        ->where(
                            $associate['look_up_reference'],
                            $update->{$associate['look_up_reference']}
                        )
                        ->update([
                                  $associate['null_field'] => $key->{$associate['look_up_foreign_key']}
                                                                    ]);
                } else {
                    //Log::info(date('m/d/Y H:i:s ::',time()).'Failed associating keys for '.$model.'\'s column '.$associate['null_field'].' with foreign key of '.$update->{$associate['look_up_reference']}.' and when looking for a matching value for it on column '.$associate['look_up_foreign_key'].' on the model.');
                    echo date('m/d/Y H:i:s ::', time()).'Failed associating keys for '.$model.'\'s column '.$associate['null_field'].' with foreign key of '.$update->{$associate['look_up_reference']}.' and when looking for a matching value for it on column '.$associate['look_up_foreign_key'].' on the model.<hr />';
                }
            }
        }
    }

    public function sync(Request $request)
    {


        //Audit::where('audit_id',$request->get('development_key'))->update(['audit_status_id'=>4]);
        //TEST EVENT
        $testaudit = Audit::where('development_key', '=', $request->get('development_key'))->where('monitoring_status_type_key', '=', 4)->orderBy('start_date', 'desc')->first();
        CreateTestAuditJob::dispatch($testaudit)->onQueue('cache');
    }

    public function getApiRoute($model,$crud,$user='system',$userEmail='admin@allita.org',$userName='AllitaPC',$deviceId=1,$deviceName='AllitaPCServer',$metadata=array()) {
        $NOTAVARIABLE = 'REPLACE THIS VARIABLE IN THE CODE WITH REAL STUFF';
        /// create the connection 
        $apiConnect = new DevcoService();
        if (!is_null($apiConnect)) {
            switch ($crud) {
                case 'create':
                    switch ($model) {
                        case 'Amenity':
                            $apiMethod = 'addAmenity';
                            $syncData = $apiConnect->$apiMethod($metadata,$user,$userEmail,$userName,$deviceId,$deviceName);
                            $syncData = json_decode($syncData, true);
                            dd($syncData);
                            return $syncData['meta']['...Key'];
                            break;

                        case 'AuditAuditors':
                            $apiMethod = 'addMonitoringMonitor';
                            $syncData = $apiConnect->$apiMethod($NOTAVARIABLE);
                            $syncData = json_decode($syncData, true);
                            return $syncData['meta']['...Key'];
                            break;

                        case 'ProjectAmenity':
                            $apiMethod = 'addProjectAmenity';
                            $syncData = $apiConnect->$apiMethod($NOTAVARIABLE);
                            $syncData = json_decode($syncData, true);
                            return $syncData['meta']['...Key'];
                            break;

                        case 'UnitAmenity':
                            $apiMethod = 'addUnitAmenity';
                            $syncData = $apiConnect->$apiMethod($NOTAVARIABLE);
                            $syncData = json_decode($syncData, true);
                            return $syncData['meta']['...Key'];
                            break;

                        case 'BuildingAmenity':
                            $apiMethod = 'addBuildingAmenity';
                            $syncData = $apiConnect->$apiMethod($NOTAVARIABLE);
                            $syncData = json_decode($syncData, true);
                            return $syncData['meta']['...Key'];
                            break;

                        default:
                            # code...
                            break;
                    }
                    break;

                case 'update':
                    switch ($model){
                        case 'Address':
                            $apiMethod = 'updateAddress';
                            $syncData = $apiConnect->$apiMethod($NOTAVARIABLE);
                            $syncData = json_decode($syncData, true);
                            if($syncData['meta']['...value..']){
                                return true;
                            } else {
                                return false;
                            }
                            break;

                        case 'Amenity':
                            dd($model,$user,$userEmail,$userName,$deviceId,$deviceName,$metadata);
                            $apiMethod = 'updateAmenity';
                            $syncData = $apiConnect->$apiMethod($NOTAVARIABLE);
                            $syncData = json_decode($syncData, true);
                            if($syncData['meta']['...value..']){
                                return true;
                            } else {
                                return false;
                            }
                            break;

                        case 'Building':
                            $apiMethod = 'updateBuilding';
                            $syncData = $apiConnect->$apiMethod($NOTAVARIABLE);
                            $syncData = json_decode($syncData, true);
                            if($syncData['meta']['...value..']){
                                return true;
                            } else {
                                return false;
                            }
                            break;

                        case 'BuildingStatus':
                            $apiMethod = 'updateBuildingStatus';
                            $syncData = $apiConnect->$apiMethod($NOTAVARIABLE);
                            $syncData = json_decode($syncData, true);
                            if($syncData['meta']['...value..']){
                                return true;
                            } else {
                                return false;
                            }
                            break;

                        case 'ComplianceContact':
                            $apiMethod = 'updateComplianceContact';
                            $syncData = $apiConnect->$apiMethod($NOTAVARIABLE);
                            $syncData = json_decode($syncData, true);
                            if($syncData['meta']['...value..']){
                                return true;
                            } else {
                                return false;
                            }
                            break;

                        case 'Project':
                            $apiMethod = 'updateDevelopment';
                            $syncData = $apiConnect->$apiMethod($NOTAVARIABLE);
                            $syncData = json_decode($syncData, true);
                            if($syncData['meta']['...value..']){
                                return true;
                            } else {
                                return false;
                            }
                            break;

                        case 'ProjectAmenity':
                            $apiMethod = 'updateDevelopmentAmenity';
                            $syncData = $apiConnect->$apiMethod($NOTAVARIABLE);
                            $syncData = json_decode($syncData, true);
                            if($syncData['meta']['...value..']){
                                return true;
                            } else {
                                return false;
                            }
                            break;

                        case 'ProjectDate':
                            $apiMethod = 'updateDevelopmentDate';
                            $syncData = $apiConnect->$apiMethod($NOTAVARIABLE);
                            $syncData = json_decode($syncData, true);
                            if($syncData['meta']['...value..']){
                                return true;
                            } else {
                                return false;
                            }
                            break;

                        case 'ProjectProgram':
                            $apiMethod = 'updateDevelopmentProgram';
                            $syncData = $apiConnect->$apiMethod($NOTAVARIABLE);
                            $syncData = json_decode($syncData, true);
                            if($syncData['meta']['...value..']){
                                return true;
                            } else {
                                return false;
                            }
                            break;

                        case 'Audit':
                            $apiMethod = 'updateAudit';
                            $syncData = $apiConnect->$apiMethod($NOTAVARIABLE);
                            $syncData = json_decode($syncData, true);
                            if($syncData['meta']['...value..']){
                                return true;
                            } else {
                                return false;
                            }
                            break;

                        case 'Organization':
                            $apiMethod = 'updateOrganization';
                            $syncData = $apiConnect->$apiMethod($NOTAVARIABLE);
                            $syncData = json_decode($syncData, true);
                            if($syncData['meta']['...value..']){
                                return true;
                            } else {
                                return false;
                            }
                            break;

                        case 'People':
                            $apiMethod = 'updatePerson';
                            $syncData = $apiConnect->$apiMethod($NOTAVARIABLE);
                            $syncData = json_decode($syncData, true);
                            if($syncData['meta']['...value..']){
                                return true;
                            } else {
                                return false;
                            }
                            break;

                        case 'Unit':
                            $apiMethod = 'updateUnit';
                            $syncData = $apiConnect->$apiMethod($NOTAVARIABLE);
                            $syncData = json_decode($syncData, true);
                            if($syncData['meta']['...value..']){
                                return true;
                            } else {
                                return false;
                            }
                            break;

                        case 'UnitStatus':
                            $apiMethod = 'updateUnitStatus';
                            $syncData = $apiConnect->$apiMethod($NOTAVARIABLE);
                            $syncData = json_decode($syncData, true);
                            if($syncData['meta']['...value..']){
                                return true;
                            } else {
                                return false;
                            }
                            break;

                        case 'UnitAmenity':
                            $apiMethod = 'updateUnitAmenity';
                            $syncData = $apiConnect->$apiMethod($NOTAVARIABLE);
                            $syncData = json_decode($syncData, true);
                            if($syncData['meta']['...value..']){
                                return true;
                            } else {
                                return false;
                            }
                            break;

                        case 'BuildingAmenity':
                            $apiMethod = 'updateBuildingAmenity';
                            $syncData = $apiConnect->$apiMethod($NOTAVARIABLE);
                            $syncData = json_decode($syncData, true);
                            if($syncData['meta']['...value..']){
                                return true;
                            } else {
                                return false;
                            }
                            break;
                    }

                case 'delete':
                    case 'Amenity':
                            $apiMethod = 'addAmenity';
                            $syncData = $apiConnect->$apiMethod($NOTAVARIABLE);
                            $syncData = json_decode($syncData, true);
                            if($syncData['meta']['...value..']){
                                return true;
                            } else {
                                return false;
                            }
                            break;

                        case 'AuditAuditors':
                            $apiMethod = 'addMonitoringMonitor';
                            $syncData = $apiConnect->$apiMethod($NOTAVARIABLE);
                            $syncData = json_decode($syncData, true);
                            if($syncData['meta']['...value..']){
                                return true;
                            } else {
                                return false;
                            }
                            break;

                        case 'ProjectAmenity':
                            $apiMethod = 'addProjectAmenity';
                            $syncData = $apiConnect->$apiMethod($NOTAVARIABLE);
                            $syncData = json_decode($syncData, true);
                            if($syncData['meta']['...value..']){
                                return true;
                            } else {
                                return false;
                            }
                            break;

                        case 'UnitAmenity':
                            $apiMethod = 'addUnitAmenity';
                            $syncData = $apiConnect->$apiMethod($NOTAVARIABLE);
                            $syncData = json_decode($syncData, true);
                            if($syncData['meta']['...value..']){
                                return true;
                            } else {
                                return false;
                            }
                            break;

                        case 'BuildingAmenity':
                            $apiMethod = 'addBuildingAmenity';
                            $syncData = $apiConnect->$apiMethod($NOTAVARIABLE);
                            $syncData = json_decode($syncData, true);
                            if($syncData['meta']['...value..']){
                                return true;
                            } else {
                                return false;
                            }
                            break;
                
                default:
                    # code...
                    break;


            }
        } else {
            return 'Unable to connect to devco service to perform update.';
        }
    }

    public function crudDevco($model, $referenceId, $crud='update'){
        //////////////////////////////////////////////////
        /////// Amenity CRUD back to devco
       
        if(!is_null($model) && strtoupper($model) !== 'NULL'){
            if(!is_null($referenceId) && strtoupper($referenceId) !== 'NULL'){
                $originalModel = $model;
                $model = 'App\\Models\\'.$model;
                $model = $model::find($referenceId);
                if(is_null($model)){
                    return "Sync Devco: Supplied reference ".$referenceId." does not exist in the model ".$originalModel;
                }
                //dd($model);  
            } else {
                return "Sync Devco: No reference id specified.";
            }
            
        } else {
            return "Sync Devco: No reference model specified.";
            
        }
        if(Auth::check()){
            $user = Auth::user()->devco_key;
            $userEmail = Auth::user()->email;
            $userName = Auth::user()->name;

            $deviceName = session('deviceName');
            if(is_null($deviceName)){
                $deviceName = '';
            }
            $deviceId = session('deviceId');
            if(is_null($deviceId)){
                $deviceId='';
            }
        } else {
            $user = NULL;
            $userEmail = NULL;
            $userName = NULL;
            $deviceName = NULL;
            $deviceId = NULL;
        }

        switch (strtolower($crud)) {
            case 'update':
                    // update devco using key
                    $metadata = $model->toArray();
                    $this->getApiRoute($originalModel,strtolower($crud),$user,$userEmail,$userName,$deviceId,$deviceName,$metadata);
                    // update the sync table key
                break;

            case 'create':
                    // add to devco
                    dd('create triggered');
                    // get key

                    // add to sync table
                break;
            
            case 'delete':
                    // delete from devco
                    dd('delete triggered');
                    // delete from sync table
                break;

            default:
                # code...
                dd('CRUD NOT AVAILABLE');
                break;
        }

    }

    public function brianTest(Request $request)
    {
        $test = \App\Models\Project::where('id', $request->get('project_id'))->first();
        ;

        dd('Project Model', 'projectProgramUnitCounts:<br />', $test, $test->projectProgramUnitCounts());
    }
}
