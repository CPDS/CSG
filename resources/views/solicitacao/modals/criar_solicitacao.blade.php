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
                        <div class="col-sm-8">
                            <strong>Título:</strong>
                            <div class="input-group">
                                <span data-toggle="tooltip" title="Local do serviço" class="input-group-addon"><i class="fa fa-bookmark-o"></i></span>
                                <input type="text" maxlength="254" class="form-control" name="titulo"  id="titulo">
                            </div>       
                        </div>
                    

                        <div class="col-sm-4">
                            <strong>Data solicitação:</strong>
                            <div class="input-group">
                                <span data-toggle="tooltip" title="Data solicitação" class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                <input type="date" maxlength="254" class="form-control" name="data_solicitacao"  id="data_solicitacao">
                            </div>       
                        </div>
                    </div>     


                    <div class="form-group">
                        <div class="col-sm-12">
                            <strong>Usuários</strong>
                            <div class="input-group">
                                <span data-toggle="tooltip" title="Usuários" class="input-group-addon"><i class="fa fa-user"></i></span>
                                <select class="form-control" name="fk_user" id="fk_user">
                                    @foreach($users as $user)
                                    <option value="{{$user->id}},{{$user->fk_escala}}">{{$user->name}}</option>
                                    @endforeach
                                </select>
                            </div>       
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-12">
                            <strong>Serviço</strong>
                            <div class="input-group">
                                <span data-toggle="tooltip" title="Setor" class="input-group-addon"><i class="fa fa-wrench"></i></span>
                                <select class="form-control" name="fk_servico" id="fk_servico">
                                    @foreach($servicos as $servico)
                                    <option value="{{$servico->id}}">{{$servico->nome}}</option>
                                    @endforeach
                                </select>
                            </div>       
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-12">
                            <strong>Tipo de Solicitação</strong>
                            <div class="input-group">
                                <span data-toggle="tooltip" title="Setor" class="input-group-addon"><i class="fa fa-pencil-square-o"></i></span>
                                <select class="form-control" name="fk_solicitacao_tipo" id="fk_solicitacao_tipo">
                                    @foreach($solicitacao_tipos as $solicitacao_tipo)
                                    <option value="{{$solicitacao_tipo->id}}">{{$solicitacao_tipo->nome}}</option>
                                    @endforeach
                                </select>
                            </div>       
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-12">
                            <strong>Observação do Solicitante:</strong>
                            <div class="input-group">
                                <span data-toggle="tooltip" title="Local do serviço" class="input-group-addon"><i class="fa fa-commenting"></i></span>
                                <input type="text" maxlength="254" class="form-control" name="observacao_solicitante"  id="observacao_solicitante">
                            </div>       
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-12">
                            <strong>Observação do Solicitado:</strong>
                            <div class="input-group">
                                <span data-toggle="tooltip" title="Local do serviço" class="input-group-addon"><i class="fa fa-commenting"></i></span>
                                <input type="text" maxlength="254" class="form-control" name="observacao_solicitado"  id="observacao_solicitado">
                            </div>       
                        </div>
                    </div>

<!-- local_servico, titulo, descricao, data_solicitacao, observacao_solicitado, observacao_solicitante -->
                    
                    <div class="form-group">
                        <div class="col-sm-12">
                            <strong>Local do serviço:</strong>
                            <div class="input-group">
                                <span data-toggle="tooltip" title="Local do serviço" class="input-group-addon"><i class="fa fa-university"></i></span>
                                <input type="text" maxlength="254" class="form-control" name="local_servico"  id="local_servico">
                            </div>       
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <div class="col-sm-12">
                            <strong>Descrição:</strong>
                            <div class="input-group">
                                <span data-toggle="tooltip" title="Descrição" class="input-group-addon"><i class="fa fa-pencil"></i></span>
                                <input type="text" maxlength="254" class="form-control" name="descricao"  id="descricao">
                            </div>       
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-8">
                            <strong>Material</strong>
                            <div class="input-group">
                                <span data-toggle="tooltip" title="Material" class="input-group-addon"><i class="fa fa-cube"></i></span>
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
                                <span data-toggle="tooltip" title="Horário pausa" class="input-group-addon"><i class="fa fa-bars"></i></span>
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