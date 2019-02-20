<?php

use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //SETOR
        DB::table('permissions')->insert([
            'name' => 'criar-setor',
            'guard_name' => 'CSG',
        ]);

        DB::table('permissions')->insert([
            'name' => 'editar-setor',
            'guard_name' => 'CSG',
        ]);

        DB::table('permissions')->insert([
            'name' => 'ver-setor',
            'guard_name' => 'CSG',
        ]);

        DB::table('permissions')->insert([
            'name' => 'excluir-setor',
            'guard_name' => 'CSG',
        ]);

        DB::table('permissions')->insert([
            'name' => 'ver-relatorio-setor',
            'guard_name' => 'CSG',
        ]);

        //USUARIO
        DB::table('permissions')->insert([
            'name' => 'criar-usuario',
            'guard_name' => 'CSG',
        ]);

        DB::table('permissions')->insert([
            'name' => 'editar-usuario',
            'guard_name' => 'CSG',
        ]);

        DB::table('permissions')->insert([
            'name' => 'ver-usuario',
            'guard_name' => 'CSG',
        ]);

        DB::table('permissions')->insert([
            'name' => 'excluir-usuario',
            'guard_name' => 'CSG',
        ]);

        DB::table('permissions')->insert([
            'name' => 'ver-relatorio-usuario',
            'guard_name' => 'CSG',
        ]);

        //PERMISSION
        DB::table('permissions')->insert([
            'name' => 'criar-permission',
            'guard_name' => 'CSG',
        ]);

        DB::table('permissions')->insert([
            'name' => 'editar-permission',
            'guard_name' => 'CSG',
        ]);

        DB::table('permissions')->insert([
            'name' => 'ver-permission',
            'guard_name' => 'CSG',
        ]);

        DB::table('permissions')->insert([
            'name' => 'excluir-permission',
            'guard_name' => 'CSG',
        ]);

        //ESCALA

         DB::table('permissions')->insert([
            'name' => 'criar-escala',
            'guard_name' => 'CSG',
        ]);

        DB::table('permissions')->insert([
            'name' => 'editar-escala',
            'guard_name' => 'CSG',
        ]);

        DB::table('permissions')->insert([
            'name' => 'ver-escala',
            'guard_name' => 'CSG',
        ]);

        DB::table('permissions')->insert([
            'name' => 'excluir-escala',
            'guard_name' => 'CSG',
        ]);

        DB::table('permissions')->insert([
            'name' => 'ver-relatorio-escala',
            'guard_name' => 'CSG',
        ]);

        //HORAS EXTRAS
        DB::table('permissions')->insert([
            'name' => 'criar-horas-extras',
            'guard_name' => 'CSG',
        ]);

        DB::table('permissions')->insert([
            'name' => 'editar-horas-extras',
            'guard_name' => 'CSG',
        ]);

        DB::table('permissions')->insert([
            'name' => 'ver-horas-extras',
            'guard_name' => 'CSG',
        ]);

        DB::table('permissions')->insert([
            'name' => 'excluir-horas-extras',
            'guard_name' => 'CSG',
        ]);

        DB::table('permissions')->insert([
            'name' => 'ver-relatorio-hora',
            'guard_name' => 'CSG',
        ]);

         //EMPENHO
        DB::table('permissions')->insert([
            'name' => 'criar-empenho',
            'guard_name' => 'CSG',
        ]);

        DB::table('permissions')->insert([
            'name' => 'editar-empenho',
            'guard_name' => 'CSG',
        ]);

        DB::table('permissions')->insert([
            'name' => 'ver-empenho',
            'guard_name' => 'CSG',
        ]);

        DB::table('permissions')->insert([
            'name' => 'excluir-empenho',
            'guard_name' => 'CSG',
        ]);

        DB::table('permissions')->insert([
            'name' => 'ver-relatorio-empenho',
            'guard_name' => 'CSG',
        ]);

        //MATERIAIS

         DB::table('permissions')->insert([
            'name' => 'criar-materiais',
            'guard_name' => 'CSG',
        ]);

        DB::table('permissions')->insert([
            'name' => 'editar-materiais',
            'guard_name' => 'CSG',
        ]);

        DB::table('permissions')->insert([
            'name' => 'ver-materiais',
            'guard_name' => 'CSG',
        ]);

        DB::table('permissions')->insert([
            'name' => 'excluir-materiais',
            'guard_name' => 'CSG',
        ]);

        DB::table('permissions')->insert([
            'name' => 'ver-relatorio-material',
            'guard_name' => 'CSG',
        ]);

        //ESTQQUE

         DB::table('permissions')->insert([
            'name' => 'criar-estoque',
            'guard_name' => 'CSG',
        ]);

        DB::table('permissions')->insert([
            'name' => 'editar-estoque',
            'guard_name' => 'CSG',
        ]);

        DB::table('permissions')->insert([
            'name' => 'ver-estoque',
            'guard_name' => 'CSG',
        ]);

        DB::table('permissions')->insert([
            'name' => 'excluir-estoque',
            'guard_name' => 'CSG',
        ]);

        DB::table('permissions')->insert([
            'name' => 'ver-relatorio-estoque',
            'guard_name' => 'CSG',
        ]);

        //CONTRATOS

         DB::table('permissions')->insert([
            'name' => 'criar-contrato',
            'guard_name' => 'CSG',
        ]);

        DB::table('permissions')->insert([
            'name' => 'editar-contrato',
            'guard_name' => 'CSG',
        ]);

        DB::table('permissions')->insert([
            'name' => 'ver-contrato',
            'guard_name' => 'CSG',
        ]);

        DB::table('permissions')->insert([
            'name' => 'excluir-contrato',
            'guard_name' => 'CSG',
        ]);

        DB::table('permissions')->insert([
            'name' => 'ver-relatorio-contrato',
            'guard_name' => 'CSG',
        ]);

        //ITENS DO CONTRATO

         DB::table('permissions')->insert([
            'name' => 'criar-item-contrato',
            'guard_name' => 'CSG',
        ]);

        DB::table('permissions')->insert([
            'name' => 'editar-item-contrato',
            'guard_name' => 'CSG',
        ]);

        DB::table('permissions')->insert([
            'name' => 'ver-item-contrato',
            'guard_name' => 'CSG',
        ]);

        DB::table('permissions')->insert([
            'name' => 'excluir-item-contrato',
            'guard_name' => 'CSG',
        ]);

        DB::table('permissions')->insert([
            'name' => 'ver-relatorio-item-contrato',
            'guard_name' => 'CSG',
        ]);

        //SOLICITAÇÃO

        DB::table('permissions')->insert([
            'name' => 'criar-solicitacao',
            'guard_name' => 'CSG',
        ]);

        DB::table('permissions')->insert([
            'name' => 'editar-solicitacao',
            'guard_name' => 'CSG',
        ]);

        DB::table('permissions')->insert([
            'name' => 'ver-solicitacao',
            'guard_name' => 'CSG',
        ]);

        DB::table('permissions')->insert([
            'name' => 'excluir-solicitacao',
            'guard_name' => 'CSG',
        ]);

        DB::table('permissions')->insert([
            'name' => 'ver-relatorio-solicitacao',
            'guard_name' => 'CSG',
        ]);

        //SERVICO SOLICITÇÃO

         DB::table('permissions')->insert([
            'name' => 'criar-servico-solicitacao',
            'guard_name' => 'CSG',
        ]);

        DB::table('permissions')->insert([
            'name' => 'editar-servico-solicitacao',
            'guard_name' => 'CSG',
        ]);

        DB::table('permissions')->insert([
            'name' => 'ver-servico-solicitacao',
            'guard_name' => 'CSG',
        ]);

        DB::table('permissions')->insert([
            'name' => 'excluir-servico-solicitacao',
            'guard_name' => 'CSG',
        ]);

        DB::table('permissions')->insert([
            'name' => 'ver-relatorio-solicitacao',
            'guard_name' => 'CSG',
        ]);

        //BAIXA MATERIAL

         DB::table('permissions')->insert([
            'name' => 'criar-baixa-material',
            'guard_name' => 'CSG',
        ]);

        DB::table('permissions')->insert([
            'name' => 'editar-baixa-material',
            'guard_name' => 'CSG',
        ]);

        DB::table('permissions')->insert([
            'name' => 'ver-baixa-material',
            'guard_name' => 'CSG',
        ]);

        DB::table('permissions')->insert([
            'name' => 'excluir-baixa-material',
            'guard_name' => 'CSG',
        ]);

        DB::table('permissions')->insert([
            'name' => 'ver-relatorio-baixa-material',
            'guard_name' => 'CSG',
        ]);


    }
}
