<!-- Visualizar Modal -->
<div id="visualizar_modal" class="modal fade"  role="dialog">

  <div class="modal-dialog" role="document">

  <div class="modal-content">

    <div class="modal-header">

      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
      <span aria-hidden="true">&times;</span>
      </button>

      <h4>
        <strong><span >Escalas</span></strong>
      </h4>

    </div>

    <div class="modal-body">

      <div class="row">

        <div class="col-xs-12 col-sm-12 col-md-12">


          <div class="form-group">
              <strong>Nome do funcionário:</strong>
              <span id="nome_servidor"></span>
          </div>

        </div> <!--fim da div visualisar -->

        <div class="col-md-12">
          <br>
              <table class="table table-bordered table-responsive" id="itens">
                  <tr>
                      <th>Setor</th>
                      <th>Horário início</th>
                      <th>Horário fim</th>
                      <th>Ações</th>
                  </tr>
                  <tbody id="item_id">
                  </tbody>
              </table>
        </div>

      </div>

    </div>

    <div class="modal-footer">
      <button type="button" class="btn btn-primary" data-dismiss="modal" id="tabela_diarios">Fechar</button>
    </div>

  </div> <!-- Fim de ModaL Content -->

  </div> <!-- Fim de ModaL Dialog -->

</div> <!-- Fim de ModaL Visualizar Usuario-->