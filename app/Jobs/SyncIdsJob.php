<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Services\AuthService;
use App\Services\DevcoService;
use App\Models\AuthTracker;
use App\Models\SystemSetting;
use DB;
use DateTime;
use Illuminate\Support\Facades\Hash;


use App\Models\Address; //
use App\Models\ProjectActivity; //
use App\Models\ProjectContactRole; //
use App\Models\Organization; //
use App\Models\Project; //
use App\Models\Program; // only funding_id - which we don't sync
use App\Models\Unit; //
use App\Models\HouseholdEvent;
use App\Models\OwnerCertificationYear;
use App\Models\Household;
use App\Models\EventType;
use App\Models\RentalAssistanceSource;
use App\Models\RentalAssistanceType;
use App\Models\UtilityAllowance;
use App\Models\Monitoring;
use App\Models\ProjectAmenity;
use App\Models\ProjectFinancial;
use App\Models\ProjectProgram;
use App\Models\UtilityAllowanceType;
use App\Models\SpecialNeed;
use App\Models\MonitoringMonitor;
use App\Models\Building;
use App\Models\PhoneNumber;
use App\Models\User;
use App\Models\ComplianceContact;
use App\Models\PhoneNumberType;
use App\Models\EmailAddressType;
use App\Models\EmailAddress;
use App\Models\BuildingAmenity;
use App\Models\UnitAmenitie;
use App\Models\HouseHoldSize;
use App\Models\ProjectDate;
use App\Models\UnitIdentity;

class SyncIdsJob implements ShouldQueue
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
    /**
     * Execute the job.
     *
     * @return void
     */
    public function associate($model,$lookUpModel,$associations){
        foreach($associations as $associate){
            $updates = $model::select($associate['look_up_reference'])
                        ->whereNull($associate['null_field'])
                        ->where($associate['look_up_reference'],$associate['condition_operator'],$associate['condition'])
                        ->groupBy($associate['look_up_reference'])
                        //->toSQL();
                        ->get()->all();
            //dd($updates);
            foreach ($updates as $update) {
                //lookup model
                //dd($update,$update->{$associate['look_up_reference']});
                $key = $lookUpModel::select($associate['look_up_foreign_key'])
                ->where($associate['lookup_field'],$update->{$associate['look_up_reference']})
                ->first();
                if(!is_null($key)){
                    $model::whereNull($associate['null_field'])
                        ->where(
                                $associate['look_up_reference'],
                                $update->{$associate['look_up_reference']}
                                )
                        ->update([
                                  $associate['null_field'] => $key->{$associate['look_up_foreign_key']}
                                                                    ]);
                } else {
                    //Log::info(date('m/d/Y H:i:s ::',time()).'Failed associating keys for '.$model.'\'s column '.$associate['null_field'].' with foreign key of '.$update->$$associate['look_up_reference'].' and when looking for a matching value for it on column '.$associate['look_up_foreign_key'].' on the '.$associate['look_up_model'].' model.');
                    echo date('m/d/Y H:i:s ::',time()).'Failed associating keys for '.$model.'\'s column '.$associate['null_field'].' with foreign key of '.$update->{$associate['look_up_reference']}.' and when looking for a matching value for it on column '.$associate['look_up_foreign_key'].' on the model.<hr />';

                }

            }
        }
    }

    public function handle()
    {
        //////////////////////////////////////////////////
        /////// Household Events ID updates
        /////

        // Do clean ups:
        // ProjectContactRole::where('state','o')->update(['state'=>'OH']);
        
        $model = new HouseholdEvent;
        $lookUpModel = new \App\Models\Unit;
        $associate = array();
        $associate[] = [
            'null_field' => 'unit_id',
            'look_up_reference' => 'unit_key',
            'lookup_field' => 'unit_key',
            'look_up_foreign_key' => 'id',
            'condition_operator' => '!=',
            'condition' => ' '
        ];
        try{
            $this->associate($model,$lookUpModel,$associate);
        } catch(Exception $e){
            //Log::info(date('m/d/Y H:i:s ::',time()).'Failed associating keys for '.$model);
            echo '<strong>'.date('m/d/Y H:i:s ::',time()).'Failed associating keys for '.$model.'</strong><hr>';
        }

        $lookUpModel = new \App\Models\OwnerCertificationYear;
        $associate = array();
        $associate[] = [
            'null_field' => 'owner_certification_year_id',
            'look_up_reference' => 'owner_certification_year_key',
            'lookup_field' => 'owner_certification_year_key',
            'look_up_foreign_key' => 'id',
            'condition_operator' => '!=',
            'condition' => ' '
        ];
        try{
            $this->associate($model,$lookUpModel,$associate);
        } catch(Exception $e){
            //Log::info(date('m/d/Y H:i:s ::',time()).'Failed associating keys for '.$model);
            echo '<strong>'.date('m/d/Y H:i:s ::',time()).'Failed associating keys for '.$model.'</strong><hr>';
        }

        $lookUpModel = new \App\Models\Project;
        $associate = array();
        $associate[] = [
            'null_field' => 'project_id',
            'look_up_reference' => 'project_key',
            'lookup_field' => 'project_key',
            'look_up_foreign_key' => 'id',
            'condition_operator' => '!=',
            'condition' => ' '
        ];
        try{
            $this->associate($model,$lookUpModel,$associate);
        } catch(Exception $e){
            //Log::info(date('m/d/Y H:i:s ::',time()).'Failed associating keys for '.$model);
            echo '<strong>'.date('m/d/Y H:i:s ::',time()).'Failed associating keys for '.$model.'</strong><hr>';
        }

        $lookUpModel = new \App\Models\Household;
        $associate = array();
        $associate[] = [
            'null_field' => 'house_hold_id',
            'look_up_reference' => 'house_hold_key',
            'lookup_field' => 'household_key',
            'look_up_foreign_key' => 'id',
            'condition_operator' => '!=',
            'condition' => ' '
        ];
        try{
            $this->associate($model,$lookUpModel,$associate);
        } catch(Exception $e){
            //Log::info(date('m/d/Y H:i:s ::',time()).'Failed associating keys for '.$model);
            echo '<strong>'.date('m/d/Y H:i:s ::',time()).'Failed associating keys for '.$model.'</strong><hr>';
        }


        $lookUpModel = new \App\Models\EventType;
        $associate = array();
        $associate[] = [
            'null_field' => 'event_type_id',
            'look_up_reference' => 'event_type_key',
            'lookup_field' => 'event_type_key',
            'look_up_foreign_key' => 'id',
            'condition_operator' => '!=',
            'condition' => ' '
        ];
        try{
            $this->associate($model,$lookUpModel,$associate);
        } catch(Exception $e){
            //Log::info(date('m/d/Y H:i:s ::',time()).'Failed associating keys for '.$model);
            echo '<strong>'.date('m/d/Y H:i:s ::',time()).'Failed associating keys for '.$model.'</strong><hr>';
        }


        $lookUpModel = new \App\Models\UnitStatus;
        $associate = array();
        $associate[] = [
            'null_field' => 'unit_status_id',
            'look_up_reference' => 'unit_status_key',
            'lookup_field' => 'unit_status_key',
            'look_up_foreign_key' => 'id',
            'condition_operator' => '!=',
            'condition' => ' '
        ];
        try{
            $this->associate($model,$lookUpModel,$associate);
        } catch(Exception $e){
            //Log::info(date('m/d/Y H:i:s ::',time()).'Failed associating keys for '.$model);
            echo '<strong>'.date('m/d/Y H:i:s ::',time()).'Failed associating keys for '.$model.'</strong><hr>';
        }

        $lookUpModel = new \App\Models\UtilityAllowance;
        $associate = array();
        $associate[] = [
            'null_field' => 'utility_allowance_id',
            'look_up_reference' => 'utility_allowance_key',
            'lookup_field' => 'utility_allowance_key',
            'look_up_foreign_key' => 'id',
            'condition_operator' => '!=',
            'condition' => ' '
        ];
        try{
            $this->associate($model,$lookUpModel,$associate);
        } catch(Exception $e){
            //Log::info(date('m/d/Y H:i:s ::',time()).'Failed associating keys for '.$model);
            echo '<strong>'.date('m/d/Y H:i:s ::',time()).'Failed associating keys for '.$model.'</strong><hr>';
        }

        $lookUpModel = new \App\Models\RentalAssistanceType;
        $associate = array();
        $associate[] = [
            'null_field' => 'rental_assistance_type_id',
            'look_up_reference' => 'rental_assistance_type_key',
            'lookup_field' => 'rental_assistance_type_key',
            'look_up_foreign_key' => 'id',
            'condition_operator' => '!=',
            'condition' => ' '
        ];
        try{
            $this->associate($model,$lookUpModel,$associate);
        } catch(Exception $e){
            //Log::info(date('m/d/Y H:i:s ::',time()).'Failed associating keys for '.$model);
            echo '<strong>'.date('m/d/Y H:i:s ::',time()).'Failed associating keys for '.$model.'</strong><hr>';
        }

        $lookUpModel = new \App\Models\RentalAssistanceSource;
        $associate = array();
        $associate[] = [
            'null_field' => 'rental_assistance_source_id',
            'look_up_reference' => 'rental_assistance_source_key',
            'lookup_field' => 'rental_assistance_source_key',
            'look_up_foreign_key' => 'id',
            'condition_operator' => '!=',
            'condition' => ' '
        ];
        try{
            $this->associate($model,$lookUpModel,$associate);
        } catch(Exception $e){
            //Log::info(date('m/d/Y H:i:s ::',time()).'Failed associating keys for '.$model);
            echo '<strong>'.date('m/d/Y H:i:s ::',time()).'Failed associating keys for '.$model.'</strong><hr>';
        }

        $lookUpModel = new \App\Models\UnitIdenty;
        $associate = array();
        $associate[] = [
            'null_field' => 'unit_identity_id',
            'look_up_reference' => 'unit_identity_key',
            'lookup_field' => 'unit_identity_key',
            'look_up_foreign_key' => 'id',
            'condition_operator' => '!=',
            'condition' => ' '
        ];
        try{
            $this->associate($model,$lookUpModel,$associate);
        } catch(Exception $e){
            //Log::info(date('m/d/Y H:i:s ::',time()).'Failed associating keys for '.$model);
            echo '<strong>'.date('m/d/Y H:i:s ::',time()).'Failed associating keys for '.$model.'</strong><hr>';
        }


        //////////////////////////////////////////////////
        /////// Unit ID updates
        /////

        // Do clean ups:
        // ProjectContactRole::where('state','o')->update(['state'=>'OH']);
        
        $model = new Unit;
        $lookUpModel = new \App\Models\Building;
        $associate = array();
        $associate[] = [
            'null_field' => 'building_id',
            'look_up_reference' => 'building_key',
            'lookup_field' => 'building_key',
            'look_up_foreign_key' => 'id',
            'condition_operator' => '!=',
            'condition' => ' '
        ];
        try{
            $this->associate($model,$lookUpModel,$associate);
        } catch(Exception $e){
            //Log::info(date('m/d/Y H:i:s ::',time()).'Failed associating keys for '.$model);
            echo '<strong>'.date('m/d/Y H:i:s ::',time()).'Failed associating keys for '.$model.'</strong><hr>';
        }

        $lookUpModel = new \App\Models\UnitBedroom;
        $associate = array();
        $associate[] = [
            'null_field' => 'unit_bedroom_id',
            'look_up_reference' => 'unit_bedroom_key',
            'lookup_field' => 'unit_bedroom_key',
            'look_up_foreign_key' => 'id',
            'condition_operator' => '!=',
            'condition' => ' '
        ];
        try{
            $this->associate($model,$lookUpModel,$associate);
        } catch(Exception $e){
            //Log::info(date('m/d/Y H:i:s ::',time()).'Failed associating keys for '.$model);
            echo '<strong>'.date('m/d/Y H:i:s ::',time()).'Failed associating keys for '.$model.'</strong><hr>';
        }

        $lookUpModel = new \App\Models\UnitStatus;
        $associate = array();
        $associate[] = [
            'null_field' => 'unit_status_id',
            'look_up_reference' => 'unit_status_key',
            'lookup_field' => 'unit_status_key',
            'look_up_foreign_key' => 'id',
            'condition_operator' => '!=',
            'condition' => ' '
        ];
        try{
            $this->associate($model,$lookUpModel,$associate);
        } catch(Exception $e){
            //Log::info(date('m/d/Y H:i:s ::',time()).'Failed associating keys for '.$model);
            echo '<strong>'.date('m/d/Y H:i:s ::',time()).'Failed associating keys for '.$model.'</strong><hr>';
        }

        $lookUpModel = new \App\Models\Percentage;
        $associate = array();
        $associate[] = [
            'null_field' => 'ami_percentage_id',
            'look_up_reference' => 'ami_percentage_key',
            'lookup_field' => 'percentage_key',
            'look_up_foreign_key' => 'id',
            'condition_operator' => '!=',
            'condition' => ' '
        ];
        try{
            $this->associate($model,$lookUpModel,$associate);
        } catch(Exception $e){
            //Log::info(date('m/d/Y H:i:s ::',time()).'Failed associating keys for '.$model);
            echo '<strong>'.date('m/d/Y H:i:s ::',time()).'Failed associating keys for '.$model.'</strong><hr>';
        }

        $lookUpModel = new \App\Models\UnitIdentity;
        $associate = array();
        $associate[] = [
            'null_field' => 'unit_identity_id',
            'look_up_reference' => 'unit_identity_key',
            'lookup_field' => 'unit_identity_key',
            'look_up_foreign_key' => 'id',
            'condition_operator' => '!=',
            'condition' => ' '
        ];
        try{
            $this->associate($model,$lookUpModel,$associate);
        } catch(Exception $e){
            //Log::info(date('m/d/Y H:i:s ::',time()).'Failed associating keys for '.$model);
            echo '<strong>'.date('m/d/Y H:i:s ::',time()).'Failed associating keys for '.$model.'</strong><hr>';
        }

        //////////////////////////////////////////////////
        /////// Project ID updates
        /////

        // Do clean ups:
        // ProjectContactRole::where('state','o')->update(['state'=>'OH']);
        
        $model = new Project;
        $lookUpModel = new \App\Models\Address;
        $associate = array();
        $associate[] = [
            'null_field' => 'physical_address_id',
            'look_up_reference' => 'physical_address_key',
            'lookup_field' => 'address_key',
            'look_up_foreign_key' => 'id',
            'condition_operator' => '!=',
            'condition' => ' '
        ];
        try{
            $this->associate($model,$lookUpModel,$associate);
        } catch(Exception $e){
            //Log::info(date('m/d/Y H:i:s ::',time()).'Failed associating keys for '.$model);
            echo '<strong>'.date('m/d/Y H:i:s ::',time()).'Failed associating keys for '.$model.'</strong><hr>';
        }

        $lookUpModel = new \App\Models\PhoneNumber;
        $associate = array();
        $associate[] = [
            'null_field' => 'default_phone_number_id',
            'look_up_reference' => 'default_phone_number_key',
            'lookup_field' => 'phone_number_key',
            'look_up_foreign_key' => 'id',
            'condition_operator' => '!=',
            'condition' => ' '
        ];
        try{
            $this->associate($model,$lookUpModel,$associate);
        } catch(Exception $e){
            //Log::info(date('m/d/Y H:i:s ::',time()).'Failed associating keys for '.$model);
            echo '<strong>'.date('m/d/Y H:i:s ::',time()).'Failed associating keys for '.$model.'</strong><hr>';
        }

        $lookUpModel = new \App\Models\PhoneNumber;
        $associate = array();
        $associate[] = [
            'null_field' => 'default_fax_number_id',
            'look_up_reference' => 'default_fax_number_key',
            'lookup_field' => 'phone_number_key',
            'look_up_foreign_key' => 'id',
            'condition_operator' => '!=',
            'condition' => ' '
        ];
        try{
            $this->associate($model,$lookUpModel,$associate);
        } catch(Exception $e){
            //Log::info(date('m/d/Y H:i:s ::',time()).'Failed associating keys for '.$model);
            echo '<strong>'.date('m/d/Y H:i:s ::',time()).'Failed associating keys for '.$model.'</strong><hr>';
        }


        //////////////////////////////////////////////////
        /////// Organization ID updates
        /////

        // Do clean ups:
        // ProjectContactRole::where('state','o')->update(['state'=>'OH']);
        
        $model = new Organization;
        $lookUpModel = new \App\Models\Address;
        $associate = array();
        $associate[] = [
            'null_field' => 'default_address_id',
            'look_up_reference' => 'default_address_key',
            'lookup_field' => 'address_key',
            'look_up_foreign_key' => 'id',
            'condition_operator' => '!=',
            'condition' => ' '
        ];
        try{
            $this->associate($model,$lookUpModel,$associate);
        } catch(Exception $e){
            //Log::info(date('m/d/Y H:i:s ::',time()).'Failed associating keys for '.$model);
            echo '<strong>'.date('m/d/Y H:i:s ::',time()).'Failed associating keys for '.$model.'</strong><hr>';
        }

        $lookUpModel = new \App\Models\PhoneNumber;
        $associate = array();
        $associate[] = [
            'null_field' => 'default_phone_number_id',
            'look_up_reference' => 'default_phone_number_key',
            'lookup_field' => 'phone_number_key',
            'look_up_foreign_key' => 'id',
            'condition_operator' => '!=',
            'condition' => ' '
        ];
        try{
            $this->associate($model,$lookUpModel,$associate);
        } catch(Exception $e){
            //Log::info(date('m/d/Y H:i:s ::',time()).'Failed associating keys for '.$model);
            echo '<strong>'.date('m/d/Y H:i:s ::',time()).'Failed associating keys for '.$model.'</strong><hr>';
        }

        $lookUpModel = new \App\Models\PhoneNumber;
        $associate = array();
        $associate[] = [
            'null_field' => 'default_fax_number_id',
            'look_up_reference' => 'default_fax_number_key',
            'lookup_field' => 'phone_number_key',
            'look_up_foreign_key' => 'id',
            'condition_operator' => '!=',
            'condition' => ' '
        ];
        try{
            $this->associate($model,$lookUpModel,$associate);
        } catch(Exception $e){
            //Log::info(date('m/d/Y H:i:s ::',time()).'Failed associating keys for '.$model);
            echo '<strong>'.date('m/d/Y H:i:s ::',time()).'Failed associating keys for '.$model.'</strong><hr>';
        }

        $lookUpModel = new \App\Models\People;
        $associate = array();
        $associate[] = [
            'null_field' => 'default_contact_person_id',
            'look_up_reference' => 'default_contact_person_key',
            'lookup_field' => 'person_key',
            'look_up_foreign_key' => 'id',
            'condition_operator' => '!=',
            'condition' => ' '
        ];
        try{
            $this->associate($model,$lookUpModel,$associate);
        } catch(Exception $e){
            //Log::info(date('m/d/Y H:i:s ::',time()).'Failed associating keys for '.$model);
            echo '<strong>'.date('m/d/Y H:i:s ::',time()).'Failed associating keys for '.$model.'</strong><hr>';
        }

        $lookUpModel = new \App\Models\Organization;
        $associate = array();
        $associate[] = [
            'null_field' => 'parent_organization_id',
            'look_up_reference' => 'parent_organization_key',
            'lookup_field' => 'organization_key',
            'look_up_foreign_key' => 'id',
            'condition_operator' => '!=',
            'condition' => ' '
        ];
        try{
            $this->associate($model,$lookUpModel,$associate);
        } catch(Exception $e){
            //Log::info(date('m/d/Y H:i:s ::',time()).'Failed associating keys for '.$model);
            echo '<strong>'.date('m/d/Y H:i:s ::',time()).'Failed associating keys for '.$model.'</strong><hr>';
        }




        //////////////////////////////////////////////////
        /////// Project Contact Roles ID updates
        /////

        // Do clean ups:
        // ProjectContactRole::where('state','o')->update(['state'=>'OH']);
        
        $model = new ProjectContactRole;
        $lookUpModel = new \App\Models\Organization;
        $associate = array();
        $associate[] = [
            'null_field' => 'organization_id',
            'look_up_reference' => 'organization_key',
            'lookup_field' => 'organization_key',
            'look_up_foreign_key' => 'id',
            'condition_operator' => '!=',
            'condition' => ' '
        ];
        try{
            $this->associate($model,$lookUpModel,$associate);
        } catch(Exception $e){
            //Log::info(date('m/d/Y H:i:s ::',time()).'Failed associating keys for '.$model);
            echo '<strong>'.date('m/d/Y H:i:s ::',time()).'Failed associating keys for '.$model.'</strong><hr>';
        }

        $lookUpModel = new \App\Models\ProjectProgram;
        $associate = array();
        $associate[] = [
            //columns in this table
            'null_field' => 'project_program_id',
            'look_up_reference' => 'project_program_key',
            //columns in the foreign table
            'lookup_field' => 'project_program_key',
            'look_up_foreign_key' => 'id',
            //condition against the lookup field - if one is needed.
            'condition_operator' => '!=',
            'condition' => ' '
        ];
        try{
            $this->associate($model,$lookUpModel,$associate);
        } catch(Exception $e){
            //Log::info(date('m/d/Y H:i:s ::',time()).'Failed associating keys for '.$model);
            echo '<strong>'.date('m/d/Y H:i:s ::',time()).'Failed associating keys for '.$model.'</strong><hr>';
        }

        $lookUpModel = new \App\Models\Project;
        $associate = array();
        $associate[] = [
            //columns in this table
            'null_field' => 'project_id',
            'look_up_reference' => 'project_key',
            //columns in the foreign table
            'lookup_field' => 'project_key',
            'look_up_foreign_key' => 'id',
            //condition against the lookup field - if one is needed.
            'condition_operator' => '!=',
            'condition' => ' '
        ];
        try{
            $this->associate($model,$lookUpModel,$associate);
        } catch(Exception $e){
            //Log::info(date('m/d/Y H:i:s ::',time()).'Failed associating keys for '.$model);
            echo '<strong>'.date('m/d/Y H:i:s ::',time()).'Failed associating keys for '.$model.'</strong><hr>';
        }

        $lookUpModel = new \App\Models\People;
        $associate = array();
        $associate[] = [
            //columns in this table
            'null_field' => 'person_id',
            'look_up_reference' => 'person_key',
            //columns in the foreign table
            'lookup_field' => 'person_key',
            'look_up_foreign_key' => 'id',
            //condition against the lookup field - if one is needed.
            'condition_operator' => '!=',
            'condition' => ' '
        ];
        try{
            $this->associate($model,$lookUpModel,$associate);
        } catch(Exception $e){
            //Log::info(date('m/d/Y H:i:s ::',time()).'Failed associating keys for '.$model);
            echo '<strong>'.date('m/d/Y H:i:s ::',time()).'Failed associating keys for '.$model.'</strong><hr>';
        }

        $lookUpModel = new \App\Models\ProjectRole;
        $associate = array();
        $associate[] = [
            //columns in this table
            'null_field' => 'project_role_id',
            'look_up_reference' => 'project_role_key',
            //columns in the foreign table
            'lookup_field' => 'project_role_key',
            'look_up_foreign_key' => 'id',
            //condition against the lookup field - if one is needed.
            'condition_operator' => '!=',
            'condition' => ' '
        ];
        try{
            $this->associate($model,$lookUpModel,$associate);
        } catch(Exception $e){
            //Log::info(date('m/d/Y H:i:s ::',time()).'Failed associating keys for '.$model);
            echo '<strong>'.date('m/d/Y H:i:s ::',time()).'Failed associating keys for '.$model.'</strong><hr>';
        }

        


        //////////////////////////////////////////////////
        /////// Project Activities ID updates
        /////

        // Do clean ups:
        // ProjectActivity::where('state','o')->update(['state'=>'OH']);
        
        $model = new ProjectActivity;
        $lookUpModel = new \App\Models\Project;
        $associate = array();
        $associate[] = [
            'null_field' => 'project_id',
            'look_up_reference' => 'project_key',
            'lookup_field' => 'project_key',
            'look_up_foreign_key' => 'id',
            'condition_operator' => '!=',
            'condition' => ' '
        ];
        try{
            $this->associate($model,$lookUpModel,$associate);
        } catch(Exception $e){
            //Log::info(date('m/d/Y H:i:s ::',time()).'Failed associating keys for '.$model);
            echo '<strong>'.date('m/d/Y H:i:s ::',time()).'Failed associating keys for '.$model.'</strong><hr>';
        }

        $lookUpModel = new \App\Models\ProjectProgram;
        $associate = array();
        $associate[] = [
            //columns in this table
            'null_field' => 'project_program_id',
            'look_up_reference' => 'project_program_key',
            //columns in the foreign table
            'lookup_field' => 'project_program_key',
            'look_up_foreign_key' => 'id',
            //condition against the lookup field - if one is needed.
            'condition_operator' => '!=',
            'condition' => ' '
        ];
        try{
            $this->associate($model,$lookUpModel,$associate);
        } catch(Exception $e){
            //Log::info(date('m/d/Y H:i:s ::',time()).'Failed associating keys for '.$model);
            echo '<strong>'.date('m/d/Y H:i:s ::',time()).'Failed associating keys for '.$model.'</strong><hr>';
        }

        $lookUpModel = new \App\Models\ProjectActivityType;
        $associate = array();
        $associate[] = [
            'null_field' => 'project_activity_type_id',
            'look_up_reference' => 'project_activity_type_key',
            'lookup_field' => 'project_activity_type_key',
            'look_up_foreign_key' => 'id',
            'condition_operator' => '!=',
            'condition' => ' '
        ];
        try{
            $this->associate($model,$lookUpModel,$associate);
        } catch(Exception $e){
            //Log::info(date('m/d/Y H:i:s ::',time()).'Failed associating keys for '.$model);
            echo '<strong>'.date('m/d/Y H:i:s ::',time()).'Failed associating keys for '.$model.'</strong><hr>';
        }

        //////////////////////////////////////////////////
        /////// Address ID update
        /////

        // do clean ups:
        Address::where('state','o')->update(['state'=>'OH']);
        Address::where('state',' O')->update(['state'=>'OH']);
        Address::where('city','Cincinnati')->where('state','')->update(['state'=>'OH']);
        Address::where('city','Youngstown')->where('state','')->update(['state'=>'OH']);
        Address::where('city','Cleveland')->where('state','')->update(['state'=>'OH']);
        Address::where('city','Columbus')->where('state','')->update(['state'=>'OH']);
        Address::where('city','Elyria')->where('state','')->update(['state'=>'OH']);
        Address::where('city','Akron')->where('state','')->update(['state'=>'OH']);
        Address::where('city','Philadelphia')->where('state','')->update(['state'=>'PA']);
        $model = new Address;
        $lookUpModel = new \App\Models\State;
        $associate = array();
        $associate[] = [
            'null_field' => 'state_id',
            'look_up_reference' => 'state',
            'lookup_field' => 'state_acronym',
            'look_up_foreign_key' => 'id',
            'condition_operator' => '!=',
            'condition' => ' '
        ];
        try{
            $this->associate($model,$lookUpModel,$associate);
        } catch(Exception $e){
            //Log::info(date('m/d/Y H:i:s ::',time()).'Failed associating keys for '.$model);
            echo '<strong>'.date('m/d/Y H:i:s ::',time()).'Failed associating keys for '.$model.'</strong><hr>';
        }

        

        
    }
}
