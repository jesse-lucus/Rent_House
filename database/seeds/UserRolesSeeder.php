<?php

use Illuminate\Database\Seeder;

class UserRolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $userRolesData = array(

            array(
                'role_id'=>2,
                'user_id'=>1
            ),
            array(
                'role_id'=>2,
                'user_id'=>2
            ),
            array(
                'role_id'=>4,
                'user_id'=>3
            ),
            array(
                'role_id'=>4,
                'user_id'=>4
            ),
            array(
                'role_id'=>4,
                'user_id'=>5
            ),
            array(
                'role_id'=>4,
                'user_id'=>6
            ),
            array(
                'role_id'=>4,
                'user_id'=>7
            ),
            array(
                'role_id'=>4,
                'user_id'=>8
            ),
            array(
                'role_id'=>4,
                'user_id'=>9
            ),
            array(
                'role_id'=>4,
                'user_id'=>10
            ),
            array(
                'role_id'=>4,
                'user_id'=>11
            ),
            array(
                'role_id'=>4,
                'user_id'=>12
            ),
            array(
                'role_id'=>4,
                'user_id'=>13
            ),
            array(
                'role_id'=>4,
                'user_id'=>14
            ),
            array(
                'role_id'=>4,
                'user_id'=>15
            ),
            array(
                'role_id'=>4,
                'user_id'=>16
            ),
            array(
                'role_id'=>4,
                'user_id'=>17
            ),
            array(
                'role_id'=>4,
                'user_id'=>18
            ),
            array(
                'role_id'=>4,
                'user_id'=>19
            ),
            array(
                'role_id'=>4,
                'user_id'=>20
            ),
            array(
                'role_id'=>4,
                'user_id'=>21
            ),
            array(
                'role_id'=>4,
                'user_id'=>22
            ),
            array(
                'role_id'=>4,
                'user_id'=>23
            ),
            array(
                'role_id'=>2,
                'user_id'=>24
            ),
            array(
                'role_id'=>2,
                'user_id'=>25
            ),
            array(
                'role_id'=>2,
                'user_id'=>26
            ),
            array(
                'role_id'=>2,
                'user_id'=>27
            ),
            array(
                'role_id'=>2,
                'user_id'=>28
            ),
            array(
                'role_id'=>2,
                'user_id'=>29
            ),
            array(
                'role_id'=>5,
                'user_id'=>2
            ),
            array(
                'role_id'=>5,
                'user_id'=>1
            )
        );
        DB::table('users_roles')->insert($userRolesData);

        $userRolesData = array(

            array(
                'role_id'=>7,
                'user_id'=>2
            ),
            array(
                'role_id'=>8,
                'user_id'=>2
            ),
            array(
                'role_id'=>9,
                'user_id'=>2
            ),
            array(
                'role_id'=>10,
                'user_id'=>6
            ),
            array(
                'role_id'=>11,
                'user_id'=>6
            ),
            array(
                'role_id'=>12,
                'user_id'=>6
            ),
            array(
                'role_id'=>7,
                'user_id'=>1
            ),
            array(
                'role_id'=>8,
                'user_id'=>1
            ),
            array(
                'role_id'=>9,
                'user_id'=>1
            ),
            array(
                'role_id'=>10,
                'user_id'=>1
            ),
            array(
                'role_id'=>11,
                'user_id'=>9
            ),
            array(
                'role_id'=>12,
                'user_id'=>9
            ),
            array(
                'role_id'=>71,
                'user_id'=>2
            ),
            array(
                'role_id'=>72,
                'user_id'=>2
            ),
            array(
                'role_id'=>73,
                'user_id'=>2
            ),
            array(
                'role_id'=>71,
                'user_id'=>28
            ),
            array(
                'role_id'=>72,
                'user_id'=>28
            ),
            array(
                'role_id'=>73,
                'user_id'=>28
            ),
            array(
                'role_id'=>74,
                'user_id'=>65
            ),
            array(
                'role_id'=>75,
                'user_id'=>65
            ),
        );

        \Illuminate\Support\Facades\DB::table('users_roles')->insert($userRolesData);
    }
}
