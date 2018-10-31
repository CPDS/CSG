<?php

use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
            'name' => 'Administrador',
            'guard_name' => 'Administrador',
        ]);

        DB::table('roles')->insert([
            'name' => 'Servidor',
            'guard_name' => 'CSG',
        ]);

        DB::table('roles')->insert([
            'name' => 'Ag-limpeza',
            'guard_name' => 'CSG',
        ]);

        DB::table('roles')->insert([
            'name' => 'Empresa',
            'guard_name' => 'CSG',
        ]);

    }
}
