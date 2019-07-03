<meta name="csrf-token" content="{{ csrf_token() }}">
<div id="relatorio_material-modal" class="modal fade bs-example" role="dialog" data-backdrop="static">
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

      <form action="{{route('gerenciar-materiais.relatorio') }}" target="_blank" method="post" class="form-horizontal" role="form" id="form" >
        {{ csrf_field() }}
         <div class="form-group">
            <div class="col-sm-12">
                <strong>materiais:</strong>
                <div class="input-group">
                    <span data-toggle="tooltip" title="Nome" class="input-group-addon"><i class="fa fa-pencil"></i></span>
                    <select name="materiais" id="materiais" class="form-control">
                      <option></option>
                    </select>
                </div>       
            </div>
        </div> 

         <div class="form-group">
            <div class="col-sm-12">
                <strong>Tipo de movimentação:</strong>
                <div class="input-group">
                    <span data-toggle="tooltip" title="Nome" class="input-group-addon"><i class="fa fa-pencil"></i></span>
                    <select name="materiais" id="materiais" class="form-control">
                      <option></option>
                      <option>Entrada</option>
                      <option>Saída</option>
                    </select>
                </div>       
            </div>
        </div>   

        <div class="form-group">
            <div class="col-sm-6">
                <strong>Data início:</strong>
                <div class="input-group">
                    <span data-toggle="tooltip" title="Data início
                    " class="input-group-addon"><i class="fa fa-calendar-minus-o"></i></span>
                    <input type="date" maxlength="254" class="form-control" name="data_inicio"  id="data_inicio">
                </div>       
            </div>
     
            <div class="col-sm-6">
                <strong>Data Fim:</strong>
                <div class="input-group">
                    <span data-toggle="tooltip" title="Data Fim
                    " class="input-group-addon"><i class="fa fa-calendar-plus-o"></i></span>
                    <input type="date" maxlength="254" class="form-control" name="data_fim"  id="data_fim">
                </div>       
            </div>
        </div>  
      
        <input type="hidden" id="id" name="id">
        <div class="modal-footer">
        <button type="submit" class="btn btn-action btn-success gerar_setor" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> &nbsp Aguarde...">
          <i class="fa fa-floppy-o"> </i>
        </button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">
          <i class='fa fa-times'></i>
        </button>
      </div> <!-- Fim de ModaL Footer-->

      </form>

      </div> <!-- Fim de ModaL Body-->

      
    </div> <!-- Fim de ModaL Content-->

  </div> <!-- Fim de ModaL Dialog-->

</div> <!-- Fim de ModaL Usuario-->