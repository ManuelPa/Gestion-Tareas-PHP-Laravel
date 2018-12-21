<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        factory('App\User','true' 1)->create();
        factory('App\User','false',1)->create();        
        // $this->call('UserTableSeeder');
        Model::reguard();
    }
}
