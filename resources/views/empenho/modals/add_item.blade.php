<div id="item-modal" class="modal fade bs-example" role="dialog" data-backdrop="static">
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
      Valor do contrato R$: <span id="valor_contrato"></span><br>
      Valor total do empenho R$:  <span id="valor_empenho"></span><br>
      Subtotal do empenho R$: <span id="subtotal"></span>

       <div class="form-group col-sm-12">
        <div class="col-sm-5">
            <strong>Item</strong>
            <div class="input-group">
                <span data-toggle="tooltip" title="Item" class="input-group-addon"><i class="fa fa-cube"></i></span>
                <select class="form-control" name="fk_item" id="fk_item">
                    <option></option>
                   @foreach($itens as $item)
                    <option value="{{$item->id}}|{{$item->valor_unitario}}">{{$item->nome}}</option>
                   @endforeach
                </select>
            </div>  
          </div>

          <div class="col-sm-3">
              <strong>Quantidade</strong>
              <div class="input-group">
                  <span data-toggle="tooltip" title="Quantidade" class="input-group-addon"><i class="fa fa-bars"></i></span>
                  <input type="text" maxlength="254" class="form-control" name="quantidade" id="quantidade">
              </div>       
          </div>

          <div class="col-sm-3">
              <strong>Valor Unitário</strong>
              <div class="input-group">
                  <span data-toggle="tooltip" title="valor" class="input-group-addon"><i class="fa fa-bars"></i></span>
                  <input readonly="" type="text" maxlength="254" class="form-control" name="valor_unitario" id="valor_unitario">
              </div>       
          </div>

          <div class="col-sm-1">
                  <a class="btnAdcItem btn btn-sm btn-primary" style="margin-top: 22px; padding: 11px"><i class="glyphicon glyphicon-plus"></i></a>
          </div>
      </div>
       <div class="col-md-12">
          <br>
              <table class="table table-bordered table-responsive" id="itens">
                  <tr>
                      <th>Item</th>
                      <th>Quantidade</th>
                      <th>Valor unitário</th>
                      <th>Ações</th>
                  </tr>
                  <tbody id="item_id">
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