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
                            <strong>Nome:</strong>
                            <div class="input-group">
                                <span data-toggle="tooltip" title="Nome" class="input-group-addon"><i class="fa fa-pencil"></i></span>
                                <input type="text" maxlength="254" class="form-control" name="nome_user"  id="nome_user">
                            </div>       
                        </div>
                   
                    
                        <div class="col-sm-4">
                            <strong>RG:</strong>
                            <div class="input-group">
                                <span data-toggle="tooltip" title="RG" class="input-group-addon"><i class="fa fa-sort-numeric-asc"></i></span>
                                <input type="text" maxlength="254" class="form-control" name="rg"  id="rg">
                            </div>       
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-8">
                            <strong>Endereço:</strong>
                            <div class="input-group">
                                <span data-toggle="tooltip" title="Endereço" class="input-group-addon"><i class="fa fa-home"></i></span>
                                <input type="text" maxlength="254" class="form-control" name="endereco"  id="endereco">
                            </div>       
                        </div>
           
                        <div class="col-sm-4">
                            <strong>Telefone:</strong>
                            <div class="input-group">
                                <span data-toggle="tooltip" title="Telefone" class="input-group-addon"><i class="fa fa-phone"></i></span>
                                <input type="text" maxlength="254" class="form-control" name="telefone"  id="telefone">
                            </div>       
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-8">
                            <strong>E-mail:</strong>
                            <div class="input-group">
                                <span data-toggle="tooltip" title="E-mail" class="input-group-addon"><i class="fa fa-envelope-o"></i></span>
                                <input type="email" maxlength="254" class="form-control" name="email"  id="email">
                            </div>       
                        </div>
                   
                        <div class="col-sm-4">
                            <strong>Senha:</strong>
                            <div class="input-group">
                                <span data-toggle="tooltip" title="Password" class="input-group-addon"><i class="fa fa-key"></i></span>
                                <input type="password" maxlength="254" class="form-control" name="password"  id="password">
                            </div>       
                        </div>
                    </div>


                    <div class="form-group">
                        <div class="col-sm-12">
                            <strong>Setor:</strong>
                            <div class="input-group">
                                <span data-toggle="tooltip" title="Setor" class="input-group-addon"><i class="fa fa-university"></i></span>
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
                            <strong>Tipo de funcionário:</strong>
                            <div class="input-group">
                                <span data-toggle="tooltip" title="Setor" class="input-group-addon"><i class="fa fa-user"></i></span>
                                <select class="form-control" name="nome_role" id="nome_role">
                                    <option>Servidor</option>
                                    <option value="Ag-limpeza">Agente de limpeza</option>
                                </select>
                            </div>       
                        </div>
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