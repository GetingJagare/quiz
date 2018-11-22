<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Admin',
            'email' => 'ruslan.mukhamedzhanov@bwe.partners',
            'password' => bcrypt('7CaVrmrB7J'),
            'is_admin' => 1
        ]);
    }
}
