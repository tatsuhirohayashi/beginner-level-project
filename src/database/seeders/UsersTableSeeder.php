<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $param = [
            'name' => 'test1',
            'email' => 'test@example1.com',
            'password' => 'testtesttest',
        ];
        DB::table('users')->insert($param);
        $param = [
            'name' => 'test2',
            'email' => 'test@example2.com',
            'password' => 'testtesttest',
        ];
        DB::table('users')->insert($param);
        $param = [
            'name' => 'test3',
            'email' => 'test@example3.com',
            'password' => 'testtesttest',
        ];
        DB::table('users')->insert($param);
        $param = [
            'name' => 'test4',
            'email' => 'test@example4.com',
            'password' => 'testtesttest',
        ];
        DB::table('users')->insert($param);
        $param = [
            'name' => 'test5',
            'email' => 'test@example5.com',
            'password' => 'testtesttest',
        ];
        DB::table('users')->insert($param);
    }
}
