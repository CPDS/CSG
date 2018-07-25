<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use Validator;
use Response;
use DataTables;
use DB;
use Auth;
use App\Material;

class MaterialController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('material.index');    
    } 

    public function list()
    {
        $material = Material::orderBy('created_at', 'desc')->get();
        return DataTables::of($material)
            ->editColumn('acao', function ($material){
                return $this->setBtns($material);
            })->escapeColumns([0])
            ->make(true);
    }

    private function setBtns(Material $materials){
        $dados = "data-id='$materials->id' data-nome='$materials->nome' data-colaborador='$materials->colaborador' data-n_licitacao='$materials->n_licitacao' data-modalidade='$materials->modalidade' ";

        $btnVer = "<a class='btn btn-info btn-sm btnVer'  data-toggle='tooltip' title='Ver material' $dados> <i class='fa fa-eye'></i></a> ";

        $btnEditar = "<a class='btn btn-primary btn-sm btnEditar' data-toggle='tooltip' title='Editar material' $dados> <i class='fa fa-edit'></i></a> ";

        $btnDeletar = "<a class='btn btn-danger btn-sm btnDeletar' data-toggle='tooltip' title='Deletar material' data-id='$materials->id'><i class='fa fa-trash'></i></a>";


        return $btnVer.$btnEditar.$btnDeletar;


    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
            $material = new Material();
            $material->nome = $request->nome;
            $material->colaborador = $request->colaborador;
            $material->n_licitacao = $request->n_licitacao;
            $material->modalidade = $request->modalidade;
            $material->save();
            $material->setAttribute('buttons', $this->setDataButtons($material)); 
            return response()->json($material);
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
