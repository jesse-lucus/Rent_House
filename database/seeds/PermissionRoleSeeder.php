<?php

use Illuminate\Database\Seeder;

class PermissionRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissionsData = array(

            array(
                'permission_name'=>'view_users',
                'permission_label'=>'View Users',
                'for'=>'both',
                'active'=>1
            ),
            array(
                'permission_name'=>'add_users',
                'permission_label'=>'Add Users',
                'for'=>'both',
                'active'=>1
            ),
            array(
                'permission_name'=>'edit_users',
                'permission_label'=>'Edit Users',
                'for'=>'both',
                'active'=>1
            ),
            array(
                'permission_name'=>'view_accounting',
                'permission_label'=>'View Accounting',
                'for'=>'both',
                'active'=>1
            ),
            array(
                'permission_name'=>'Edit Accounts',
                'permission_label'=>'Edit Accounts',
                'for'=>'both',
                'active'=>1
            ),
            array(
                'permission_name'=>'view_stats',
                'permission_label'=>'View Stats',
                'for'=>'both',
                'active'=>1
            ),
            array(
                'permission_name'=>'view_invoices',
                'permission_label'=>'View Invoices',
                'for'=>'both',
                'active'=>1
            ),
            array(
                'permission_name'=>'edit_invoices',
                'permission_label'=>'Edit Invoices',
                'for'=>'both',
                'active'=>1
            ),
            array(
                'permission_name'=>'add_invoices',
                'permission_label'=>'Add Invoices',
                'for'=>'both',
                'active'=>1
            ),
            array(
                'permission_name'=>'cancel_invoice',
                'permission_label'=>'Cancel Invoice',
                'for'=>'both',
                'active'=>1
            ),
            array(
                'permission_name'=>'view_requests',
                'permission_label'=>'View Requests',
                'for'=>'both',
                'active'=>1
            ),
            array(
                'permission_name'=>'edit_requests',
                'permission_label'=>'Edit Requests',
                'for'=>'both',
                'active'=>1
            ),
            array(
                'permission_name'=>'add_requests',
                'permission_label'=>'Add Requests',
                'for'=>'both',
                'active'=>1
            ),
            array(
                'permission_name'=>'cancel_request',
                'permission_label'=>'Cancel Request ',
                'for'=>'both',
                'active'=>1
            ),
            array(
                'permission_name'=>'view_pos',
                'permission_label'=>'View Purchase Orders',
                'for'=>'both',
                'active'=>1
            ),
            array(
                'permission_name'=>'edit_pos',
                'permission_label'=>'Edit Purchase Orders',
                'for'=>'hfa',
                'active'=>1
            ),
            array(
                'permission_name'=>'cancel_pos',
                'permission_label'=>'Cancel Purchase Orders',
                'for'=>'hfa',
                'active'=>1
            ),
            array(
                'permission_name'=>'view_parcels',
                'permission_label'=>'View Parcels',
                'for'=>'both',
                'active'=>1
            ),
            array(
                'permission_name'=>'edit_parcels',
                'permission_label'=>'Edit Parcels',
                'for'=>'both',
                'active'=>1
            ),
            array(
                'permission_name'=>'add_parcels',
                'permission_label'=>'Add Parcels',
                'for'=>'both',
                'active'=>1
            ),
            array(
                'permission_name'=>'delete_parcel',
                'permission_label'=>'Delete Parcel',
                'for'=>'both',
                'active'=>1
            ),
            array(
                'permission_name'=>'view_roles',
                'permission_label'=>'View Roles',
                'for'=>'both',
                'active'=>1
            ),
            array(
                'permission_name'=>'edit_roles',
                'permission_label'=>'Edit Roles',
                'for'=>'both',
                'active'=>1
            ),
            array(
                'permission_name'=>'add_roles',
                'permission_label'=>'Add Roles',
                'for'=>'both',
                'active'=>1
            ),
            array(
                'permission_name'=>'delete_roles',
                'permission_label'=>'Delete Roles',
                'for'=>'both',
                'active'=>1
            ),
            array(
                'permission_name'=>'view_loc',
                'permission_label'=>'View Line of Credit',
                'for'=>'both',
                'active'=>1
            ),
            array(
                'permission_name'=>'edit_loc',
                'permission_label'=>'Edit Line of Credit',
                'for'=>'hfa',
                'active'=>1
            ),
            array(
                'permission_name'=>'add_loc',
                'permission_label'=>'Add Line of Credit',
                'for'=>'both',
                'active'=>1
            ),
            array(
                'permission_name'=>'request_loc_advance',
                'permission_label'=>'Request Line of Credit Advance',
                'for'=>'lb',
                'active'=>1
            ),
            array(
                'permission_name'=>'approve_loc_advance',
                'permission_label'=>'Approve Line of Credit Advances',
                'for'=>'hfa',
                'active'=>1
            ),
            array(
                'permission_name'=>'create_payment_batch',
                'permission_label'=>'Log Payment Batches',
                'for'=>'hfa',
                'active'=>1
            ),
            array(
                'permission_name'=>'manage_processes',
                'permission_label'=>'Manage Processes',
                'for'=>'both',
                'active'=>1
            ),
            array(
                'permission_name'=>'cancel_loc',
                'permission_label'=>'Cancel Line of Credit',
                'for'=>'both',
                'active'=>1
            ),
            array(
                'permission_name'=>'view_all_history',
                'permission_label'=>'View all user history.',
                'for'=>'both',
                'active'=>1
            ),
            array(
                'permission_name'=>'signator',
                'permission_label'=>'Is a Signator',
                'for'=>'both',
                'active'=>1
            ),
            array(
                'permission_name'=>'view_admin_tools',
                'permission_label'=>'View Admin Tools',
                'for'=>'both',
                'active'=>1
            ),
            array(
                'permission_name'=>'global',
                'permission_label'=>'Permissions to All Entities <br /><small>Unchecking this option will limit the user\'s access to items associated with their entity only.</small>',
                'for'=>'hfa',
                'active'=>1
            ),
            array(
                'permission_name'=>'create-disposition',
                'permission_label'=>'Create disposition',
                'for'=>'lb',
                'active'=>1
            ),
            array(
                'permission_name'=>'authorize-disposition-request',
                'permission_label'=>'Authorize disposition Request',
                'for'=>'lb',
                'active'=>1
            ),
            array(
                'permission_name'=>'submit-disposition',
                'permission_label'=>'Submit disposition to HFA',
                'for'=>'lb',
                'active'=>1
            ),
            array(
                'permission_name'=>'hfa-review-disposition',
                'permission_label'=>'Review disposition',
                'for'=>'hfa',
                'active'=>1
            ),
            array(
                'permission_name'=>'hfa-sign-disposition',
                'permission_label'=>'Sign disposition',
                'for'=>'hfa',
                'active'=>1
            ),
            array(
                'permission_name'=>'hfa-release-disposition',
                'permission_label'=>'Release disposition',
                'for'=>'hfa',
                'active'=>1
            )
        );
        DB::table('permissions')->insert($permissionsData);


        $permissionRoleData = array(

            array(
                'role_id'=>2,
                'permission_id'=>1
            ),
            array(
                'role_id'=>2,
                'permission_id'=>2
            ),
            array(
                'role_id'=>2,
                'permission_id'=>3
            ),
            array(
                'role_id'=>2,
                'permission_id'=>4
            ),
            array(
                'role_id'=>2,
                'permission_id'=>5
            ),
            array(
                'role_id'=>2,
                'permission_id'=>6
            ),
            array(
                'role_id'=>2,
                'permission_id'=>7
            ),
            array(
                'role_id'=>2,
                'permission_id'=>8
            ),
            array(
                'role_id'=>2,
                'permission_id'=>9
            ),
            array(
                'role_id'=>2,
                'permission_id'=>10
            ),
            array(
                'role_id'=>2,
                'permission_id'=>11
            ),
            array(
                'role_id'=>2,
                'permission_id'=>12
            ),
            array(
                'role_id'=>2,
                'permission_id'=>13
            ),
            array(
                'role_id'=>2,
                'permission_id'=>14
            ),
            array(
                'role_id'=>2,
                'permission_id'=>15
            ),
            array(
                'role_id'=>2,
                'permission_id'=>16
            ),
            array(
                'role_id'=>2,
                'permission_id'=>17
            ),
            array(
                'role_id'=>2,
                'permission_id'=>18
            ),
            array(
                'role_id'=>2,
                'permission_id'=>19
            ),
            array(
                'role_id'=>2,
                'permission_id'=>20
            ),
            array(
                'role_id'=>2,
                'permission_id'=>21
            ),
            array(
                'role_id'=>2,
                'permission_id'=>22
            ),
            array(
                'role_id'=>2,
                'permission_id'=>23
            ),
            array(
                'role_id'=>2,
                'permission_id'=>24
            ),
            array(
                'role_id'=>2,
                'permission_id'=>25
            ),
            array(
                'role_id'=>2,
                'permission_id'=>26
            ),
            array(
                'role_id'=>2,
                'permission_id'=>27
            ),
            array(
                'role_id'=>2,
                'permission_id'=>28
            ),
            array(
                'role_id'=>2,
                'permission_id'=>30
            ),
            array(
                'role_id'=>2,
                'permission_id'=>31
            ),
            array(
                'role_id'=>2,
                'permission_id'=>32
            ),
            array(
                'role_id'=>2,
                'permission_id'=>33
            ),
            array(
                'role_id'=>2,
                'permission_id'=>34
            ),


            array(
                'role_id'=>4,
                'permission_id'=>1
            ),
            array(
                'role_id'=>4,
                'permission_id'=>2
            ),
            array(
                'role_id'=>4,
                'permission_id'=>3
            ),
            array(
                'role_id'=>4,
                'permission_id'=>4
            ),
            array(
                'role_id'=>4,
                'permission_id'=>5
            ),
            array(
                'role_id'=>4,
                'permission_id'=>6
            ),
            array(
                'role_id'=>4,
                'permission_id'=>7
            ),
            array(
                'role_id'=>4,
                'permission_id'=>8
            ),
            array(
                'role_id'=>4,
                'permission_id'=>9
            ),
            array(
                'role_id'=>4,
                'permission_id'=>10
            ),
            array(
                'role_id'=>4,
                'permission_id'=>11
            ),
            array(
                'role_id'=>4,
                'permission_id'=>12
            ),
            array(
                'role_id'=>4,
                'permission_id'=>13
            ),
            array(
                'role_id'=>4,
                'permission_id'=>14
            ),
            array(
                'role_id'=>4,
                'permission_id'=>15
            ),
            array(
                'role_id'=>4,
                'permission_id'=>18
            ),
            array(
                'role_id'=>4,
                'permission_id'=>19
            ),
            array(
                'role_id'=>4,
                'permission_id'=>20
            ),
            array(
                'role_id'=>4,
                'permission_id'=>21
            ),
            array(
                'role_id'=>4,
                'permission_id'=>22
            ),
            array(
                'role_id'=>4,
                'permission_id'=>23
            ),
            array(
                'role_id'=>4,
                'permission_id'=>24
            ),
            array(
                'role_id'=>4,
                'permission_id'=>25
            ),
            array(
                'role_id'=>4,
                'permission_id'=>26
            ),
            array(
                'role_id'=>4,
                'permission_id'=>28
            ),
            array(
                'role_id'=>4,
                'permission_id'=>29
            ),
            array(
                'role_id'=>4,
                'permission_id'=>32
            ),
            array(
                'role_id'=>4,
                'permission_id'=>33
            ),
            array(
                'role_id'=>4,
                'permission_id'=>34
            ),////////////////
            array(
                'role_id'=>7,
                'permission_id'=>41
            ),
            array(
                'role_id'=>7,
                'permission_id'=>42
            ),
            array(
                'role_id'=>8,
                'permission_id'=>41
            ),
            array(
                'role_id'=>8,
                'permission_id'=>42
            ),
            array(
                'role_id'=>8,
                'permission_id'=>43
            ),
            array(
                'role_id'=>9,
                'permission_id'=>41
            ),
            array(
                'role_id'=>10,
                'permission_id'=>38
            ),
            array(
                'role_id'=>11,
                'permission_id'=>38
            ),
            array(
                'role_id'=>11,
                'permission_id'=>39
            ),
            array(
                'role_id'=>12,
                'permission_id'=>38
            ),
            array(
                'role_id'=>12,
                'permission_id'=>39
            ),
            array(
                'role_id'=>12,
                'permission_id'=>40
            )
        );
        DB::table('roles_and_permissions')->insert($permissionRoleData);

        $permissionRoleData = [
            [
                'role_id'       => 2,
                'permission_id' => 44
            ],
            [
                'role_id'       => 3,
                'permission_id' => 44
            ],
            [
                'role_id'       => 7,
                'permission_id' => 44
            ],
            [
                'role_id'       => 9,
                'permission_id' => 44
            ],
            [
                'role_id'       => 10,
                'permission_id' => 44
            ],
            [
                'role_id'       => 11,
                'permission_id' => 44
            ],
            [
                'role_id'       => 12,
                'permission_id' => 44
            ],
            [
                'role_id'       => 16,
                'permission_id' => 44
            ],
            [
                'role_id'       => 17,
                'permission_id' => 44
            ],
            [
                'role_id'       => 18,
                'permission_id' => 44
            ],
            [
                'role_id'       => 19,
                'permission_id' => 44
            ],
            [
                'role_id'       => 20,
                'permission_id' => 44
            ],
            [
                'role_id'       => 21,
                'permission_id' => 44
            ],
            [
                'role_id'       => 22,
                'permission_id' => 44
            ],
            [
                'role_id'       => 23,
                'permission_id' => 44
            ],
            [
                'role_id'       => 26,
                'permission_id' => 44
            ],
            [
                'role_id'       => 27,
                'permission_id' => 44
            ]
        ];

        \Illuminate\Support\Facades\DB::table('roles_and_permissions')->insert($permissionRoleData);
    }
}
