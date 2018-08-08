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
                            <strong>Servidor</strong>
                            <div class="input-group">
                                <span data-toggle="tooltip" title="Servidor" class="input-group-addon"><i class="fa fa-pencil"></i></span>
                                <select class="form-control" name="id_servidor" id="id_servidor">
                                    @foreach($servidores as $servidor)
                                    <option value="{{$servidor->id}}">{{$servidor->nome}}</option>
                                    @endforeach
                                </select>
                            </div>       
                        </div>
                    </div>

                     <div class="form-group">
                        <div class="col-sm-12">
                            <strong>Horas excedidas:</strong>
                            <div class="input-group">
                                <span data-toggle="tooltip" title="Horas excedidas" class="input-group-addon"><i class="fa fa-pencil"></i></span>
                                <input type="text" maxlength="254" class="form-control" name="horas_excedidas"  id="horas_excedidas">
                            </div>       
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <div class="col-sm-12">
                            <strong>Dia:</strong>
                            <div class="input-group">
                                <span data-toggle="tooltip" title="Horário pausa" class="input-group-addon"><i class="fa fa-pencil"></i></span>
                                <input type="text" maxlength="254" class="form-control" name="dia"  id="dia">
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