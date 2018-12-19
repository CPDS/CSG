<?php

use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $total = DB::table('permissions')->select('id')->get();
        foreach ($total as $value)
        {
            DB::table('model_has_permissions')->insert([
                'permission_id' => $value->id,
                'model_id' => 1,
                'model_type' => 'App\User',
            ]); 
        }
             
    }
}
