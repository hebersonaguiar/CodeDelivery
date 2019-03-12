<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use CodeDelivery\Models\Category;
use CodeDelivery\Models\User;

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

        $this->call(UserTableSeeder::class);
        $this->call(CategoryTableSeeder::class);        
        $this->call(OrderTableSeeder::class);

        Model::reguard();
    }
}
