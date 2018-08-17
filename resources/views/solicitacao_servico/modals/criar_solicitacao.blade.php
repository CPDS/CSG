<div id="criar_editar-modal" class="modal fade bs-example" role="dialog" data-backdrop="static">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"></h4>
      </div> <!-- Fim de ModaL Header-->

      <div class="modal-body">

        <div class="erros callout callout-danger hidden">
                <p></p>
        </div>

       <form class="form-horizontal" role="form" id="form" >
                     <div class="form-group">
                        <div class="col-sm-12">
                            <strong>Servidor</strong>
                            <div class="input-group">
                                <span data-toggle="tooltip" title="Servidor" class="input-group-addon"><i class="fa fa-pencil"></i></span>
                                <select class="form-control" name="fk_servidor" id="fk_servidor">
                                    @foreach($servidores as $servidor)
                                    <option value="{{$servidor->id}}">{{$servidor->nome}}</option>
                                    @endforeach
                                </select>
                            </div>       
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-12">
                            <strong>Setor</strong>
                            <div class="input-group">
                                <span data-toggle="tooltip" title="Setor" class="input-group-addon"><i class="fa fa-pencil"></i></span>
                                <select class="form-control" name="fk_setor" id="fk_setor">
                                    @foreach($setores as $setor)
                                    <option value="{{$setor->id}}">{{$setor->nome}}</option>
                                    @endforeach
                                </select>
                            </div>       
                        </div>
                    </div>


                     <div class="form-group">
                        <div class="col-sm-12">
                            <strong>Data solicitação:</strong>
                            <div class="input-group">
                                <span data-toggle="tooltip" title="Data solicitação" class="input-group-addon"><i class="fa fa-pencil"></i></span>
                                <input type="text" maxlength="254" class="form-control" name="data_solicitacao"  id="data_solicitacao">
                            </div>       
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-12">
                            <strong>Data Realização:</strong>
                            <div class="input-group">
                                <span data-toggle="tooltip" title="Data solicitação" class="input-group-addon"><i class="fa fa-pencil"></i></span>
                                <input type="text" maxlength="254" class="form-control" name="data_realizacao"  id="data_realizacao">
                            </div>       
                        </div>
                    </div>

                                        <!--'data_solicitacao','data_realizacao', 
//'nome_setor','nome_servidor','codigo_material','descricao_material','quantidade' -->
                    <div class="form-group">
                        <div class="col-sm-12">
                            <strong>Dia:</strong>
                            <div class="input-group">
                                <span data-toggle="tooltip" title="Horário pausa" class="input-group-addon"><i class="fa fa-pencil"></i></span>
                                <input type="text" maxlength="254" class="form-control" name="dia"  id="dia">
                            </div>       
                        </div>
                    </div>    



                    <div class="form-group">
                        <div class="col-sm-8">
                            <strong>Material</strong>
                            <div class="input-group">
                                <span data-toggle="tooltip" title="Material" class="input-group-addon"><i class="fa fa-pencil"></i></span>
                                <select class="form-control" name="fk_material" id="fk_material">
                                    @foreach($materiais as $material)
                                    <option value="{{$material->id}}">{{$material->descricao}}</option>
                                    @endforeach
                                </select>
                            </div>       
                        </div>
                    
                        <div class="col-sm-3">
                            <strong>Quantidade</strong>
                            <div class="input-group">
                                <span data-toggle="tooltip" title="Horário pausa" class="input-group-addon"><i class="fa fa-pencil"></i></span>
                                <input type="text" maxlength="254" class="form-control" name="quantidade" id="quantidade">
                            </div>       
                        </div>

                        <div class="col-sm-1">
                            
                                <a class="btnAdcMaterial btn btn-sm btn-primary" style="margin-top: 22px; padding: 11px"><i class="glyphicon glyphicon-plus"></i></a>
                        </div>
                                 
                    
                    </div>

                            <div class="col-md-12">
                            <br>
                                <table class="table table-bordered table-responsive" id="materiais">
                                    <tr>
                                        <th>Material</th>
                                        <th>Quantidade</th>
                                        <th>Ações</th>
                                    </tr>
                                    <tbody id="material_id">
                                    </tbody>
                                </table>
                            </div>


                            <input type="hidden" id="id" name="id">
                </form>

      </div> <!-- Fim de ModaL Body-->

      <div class="modal-footer">
        <button type="button" class="btn btn-action btn-success add" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> &nbsp Aguarde...">
          <i class="fa fa-floppy-o"> </i>
        </button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">
          <i class='fa fa-times'></i>
        </button>
      </div> <!-- Fim de ModaL Footer-->

    </div> <!-- Fim de ModaL Content-->

  </div> <!-- Fim de ModaL Dialog-->

</div> <!-- Fim de ModaL Usuario-->