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
        <title>Escalas de horários</title>
    </head>
<body>
    <div>

    <div style="text-align: center; margin-top: 50px">
      	<h3>RELATÓRIO DE SAIDA DE ITENS</h3>
      </div>
		<table class="tg">
			<tr>
				<th class="tg-q19q">Dia</th>
				<th class="tg-q19q">Horário início</th>	
				<th class="tg-q19q">Horário fim</th>

			</tr>

		@foreach($escalas as $escala)
			<tr>	
				<td class="tg-q19q">{{$escala->dia_semana}}</td>
				<td class="tg-q19q">{{$escala->horario_inicio}}</td>
				<td class="tg-q19q">{{$escala->horario_termino}}</td>
			</tr>			
		@endforeach
		</table>
</div>
</body>
</html>