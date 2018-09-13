<div id="criar_editar-modal" class="modal fade bs-example" role="dialog" data-backdrop="static">
  <div class="modal-dialog">
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
                            <strong>Nome:</strong>
                            <div class="input-group">
                                <span data-toggle="tooltip" title="Nome" class="input-group-addon"><i class="fa fa-pencil"></i></span>
                                <input type="text" maxlength="254" class="form-control" name="nome"  id="nome">
                            </div>       
                        </div>
                    </div>
                     <div class="form-group">
                        <div class="col-sm-5">
                            <strong>Sigla:</strong>
                            <div class="input-group">
                                <span data-toggle="tooltip" title="Sigla" class="input-group-addon"><i class="fa fa-bookmark-o"></i></span>
                                <input type="text" maxlength="254" class="form-control" name="sigla"  id="sigla">
                            </div>       
                        </div>
                    
                        <div class="col-sm-7">
                            <strong>Telefone:</strong>
                            <div class="input-group">
                                <span data-toggle="tooltip" title="E-mail" class="input-group-addon"><i class="fa fa-phone"></i></span>
                                <input type="text" maxlength="254" class="form-control" name="telefone"  id="telefone">
                            </div>       
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-12">
                            <strong>E-mail:</strong>
                            <div class="input-group">
                                <span data-toggle="tooltip" title="E-mail" class="input-group-addon"><i class="fa fa-envelope-o"></i></span>
                                <input type="text" maxlength="254" class="form-control" name="email"  id="email">
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