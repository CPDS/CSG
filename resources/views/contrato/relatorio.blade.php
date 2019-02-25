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
        <title>Saída de itens</title>
    </head>
<body>
<div style="text-align: center; font-family: arial">  
   <p >
        <img style="float:left" width=115px height=131px src="{{ public_path('img/uesb.png') }}" v:shapes="Imagem_x0020_1">
        <img style="float:right" width=115px height=131px src="{{ public_path('img/logo.png') }}" v:shapes="Imagem_x0020_1">
        <h2>Universidade Estadual do Sudoeste da Bahia</h2>
        <p>Credenciada Pelo Decreto Estadual nº 7.344 de 27.05.1998<br>
        Coordenação de Laboratório - CLAB<br>
        Campus de Jequié</p>
     </p>
     <hr>
     <br>
</div>   
    <div>

    <div style="text-align: center; margin-top: 50px">
      	<h3>RELATÓRIO DE SAIDA DE ITENS</h3>
      </div>
		<table class="tg">
			<tr>
				<th class="tg-ox40">Contrato</th>
				<th class="tg-ox40">Data início</th>	
        <th class="tg-ox40">Data fim</th>
        <th class="tg-ox40">Item</th>
        <th class="tg-ox40">Valor</th>
        <th class="tg-ox40">Quantidade</th>

			</tr>

		@foreach($contratos as $contrato)
			<tr>	
				<td class="tg-q19q">{{$contrato->numero}}</td>
				<td class="tg-q19q">{{$contrato->data_inicio}}</td>
        <td class="tg-q19q">{{$contrato->data_fim}}</td>
        <td class="tg-q19q">{{$contrato->item}}</td>
        <td class="tg-q19q">{{$contrato->valor}}</td>
        <td class="tg-q19q">{{$contrato->quantidade}}</td>
			</tr>			
		@endforeach
		</table>
</div>
</body>
<footer>
<br><br>
<p style ="text-align: center">Avenida José Moreira Sobrinho S/N - Jequiezinho <br>
    Fone:(73) 3528-9723-clabjq@uesb.edu.br</p>
</footer>
</html>
