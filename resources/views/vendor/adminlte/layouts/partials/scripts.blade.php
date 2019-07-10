<!-- REQUIRED JS SCRIPTS -->

<!-- JQuery and bootstrap are required by Laravel 5.3 in resources/assets/js/bootstrap.js-->
<!-- Laravel App -->
<script src="{{ url (mix('/js/app.js')) }}" type="text/javascript"></script>
<script src ="{{ asset('/js/scripts_gerais/relatorio.js') }}" type = "text/javascript" ></script>
@include('material.modals.relatorio_material')
@include('setor.modals.relatorio_setor')
@include('user.modals.relatorio_escala')
@include('user.modals.relatorio_horas')


<!-- Optionally, you can add Slimscroll and FastClick plugins.
      Both of these plugins are recommended to enhance the
      user experience. Slimscroll is required when using the
      fixed layout. -->
