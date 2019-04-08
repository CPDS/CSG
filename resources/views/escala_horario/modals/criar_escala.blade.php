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
                            <strong>Funcionário</strong>
                            <div class="input-group">
                                <span data-toggle="tooltip" title="Funcionário" class="input-group-addon"><i class="fa fa-user"></i></span>
                                <select class="form-control" name="fk_user" id="fk_user">
                                    @foreach($users as $user)
                                    <option value="{{$user->id}}">{{$user->name}}</option>
                                    @endforeach
                                </select>
                            </div>       
                        </div>
                    </div>

                     <div class="form-group">
                        <div class="col-sm-6">
                            <strong>Horário início da manhã:</strong>
                            <div class="input-group">
                                <span data-toggle="tooltip" title="Horário início" class="input-group-addon"><i class="fa fa-clock-o"></i></span>
                                <input type="time" maxlength="254" class="form-control" name="horario_inicio"  id="horario_inicio">
                            </div>       
                        </div>
                   
                        <div class="col-sm-6">
                            <strong>Horário fim da manhã:</strong>
                            <div class="input-group">
                                <span data-toggle="tooltip" title="Horário fim" class="input-group-addon"><i class="fa fa-clock-o"></i></span>
                                <input type="time" maxlength="254" class="form-control" name="horario_termino"  id="horario_termino">
                            </div>       
                        </div>
                    </div>

                       <div class="form-group">
                        <div class="col-sm-6">
                            <strong>Horário início da tarde:</strong>
                            <div class="input-group">
                                <span data-toggle="tooltip" title="Horário início" class="input-group-addon"><i class="fa fa-clock-o"></i></span>
                                <input type="time" maxlength="254" class="form-control" name="horario_inicio_tarde"  id="horario_inicio">
                            </div>       
                        </div>
                   
                        <div class="col-sm-6">
                            <strong>Horário fim da tarde:</strong>
                            <div class="input-group">
                                <span data-toggle="tooltip" title="Horário fim" class="input-group-addon"><i class="fa fa-clock-o"></i></span>
                                <input type="time" maxlength="254" class="form-control" name="horario_termino_tarde"  id="horario_termino">
                            </div>       
                        </div>
                    </div>
                  
                    <div class="form-group">
                        <div class="col-sm-12">
                            <strong>Dia da semana:</strong>
                            <div class="input-group">
                                <span data-toggle="tooltip" title="Horário pausa" class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                <select class="form-control" name="dia_semana" id="dia_semana">
                                    <option>Segunda-Feira</option>
                                    <option>Terça-Feira</option>
                                    <option>Quarta-Feira</option>
                                    <option>Quinta-Feira</option>
                                    <option>Sexta-Feira</option>
                                    <option>Sábado</option>
                                </select>
                            </div>       
                        </div>
                    </div>

                     <div class="form-group">
                        <div class="col-sm-12">
                            <strong>Setor</strong>
                            <div class="input-group">
                                <span data-toggle="tooltip" title="Setor" class="input-group-addon"><i class="fa fa-university"></i></span>
                                <select class="form-control" name="fk_setor" id="fk_setor">
                                    @foreach($setors as $setor)
                                    <option value="{{$setor->id}}">{{$setor->nome}}</option>
                                    @endforeach
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