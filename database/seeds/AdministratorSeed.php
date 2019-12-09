<?php

use Illuminate\Database\Seeder;

class AdministratorSeed extends Seeder
{
     /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('administrators')->insert([
                'name'     => 'Administrador',
                'email'    => 'admin@admin.com',
                'password' => bcrypt('admin123456')
        ]);
    }
}
