<style type="text/css">
      .tg  {border-collapse:collapse;border-spacing:0; width: 100%;}
          .tg td{font-family:Arial, sans-serif;font-size:14px;padding:10px 20px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;}
          .tg th{font-family:Arial, sans-serif;font-size:14px;font-weight:normal;padding:10px 20px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;}
          .tg .tg-q19q{font-size:16px;vertical-align:top}
          .tg .tg-ox40{font-weight:bold;font-size:14px;text-align:left;vertical-align:top;}
          .tc  {border-collapse:collapse;border-spacing:0; width: 70%;margin-left: 120px}
          .tc td{font-family:Arial, sans-serif;font-size:14px;padding:10px 20px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;}
          .tc th{font-family:Arial, sans-serif;font-size:14px;font-weight:normal;padding:10px 20px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;}
          .tc .tc-q19q{font-size:16px;vertical-align:top}
          .tc .tc-qt{font-size:16px;vertical-align:top;text-align: center;}
          .tc .tc-ox40{font-weight:bold;font-size:14px;text-align:left;vertical-align:top;}
</style>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>ESCALA DE HORARIOS</title>
    </head>
<body>
    <div>

    <div style="text-align: center; margin-top: 50px">
      	<h3>RELATÓRIO DE ESCALA DE HORARIOS</h3>
      </div>
		<table class="tg">
			<tr>
				<th class="tg-q19q">Funcionário</th>
				<th class="tg-q19q">Setor</th>	
        <th class="tg-q19q">Manhã</th>
        <th class="tg-q19q">Tarde</th>
				<th class="tg-q19q">Dia</th>
			</tr>

		@foreach($escala_horarios as $escala)
			<tr>	
        <td class="tg-q19q">{{$escala->nome_funcionario}}</td>
				<td class="tg-q19q">{{$escala->nome_setor}}</td>
				<td class="tg-q19q">{{$escala->horario_inicio}}-{{$escala->horario_termino}}</td>
        <td class="tg-q19q">{{$escala->horario_inicio_tarde}}-{{$escala->horario_termino_tarde}}</td>
				<td class="tg-q19q">{{$escala->dia_semana}}</td>
			</tr>			
		@endforeach
		</table>
</div>
</body>
</html>