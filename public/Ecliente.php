<!DOCTYPE html>
<html>
	<?php 
		include("seguranca.php"); 
		// protegePagina(); 
	?>
	<head id="top">
		<?php  
			include("head.php");
		?>
		<script>
	        $(document).ready(function() {
				$('#top-link').topLink({
					min: 400,
					fadeSpeed: 500
				});
				$('#top-link').click(function(e) {
					e.preventDefault();
					window.scrollTo(0,0);
				});

				Box_Cliente();

				$('table.highchart').highchartTable();
	        });
	    </script>
	</head>
    <body>
    	<header>
	    	<nav class="navbar navbar-default navbar-fixed-top">
			  <div class="container-fluid">
			    <div class="navbar-header">
			      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
			        <span class="icon-bar"></span>
			        <span class="icon-bar"></span>
			        <span class="icon-bar"></span>                        
			      </button>
			      <a class="navbar-brand" href="Home.php"><div class="ws">Peixão</div></a>
			    </div>
			    <div class="collapse navbar-collapse" id="myNavbar">
			      <ul class="nav navbar-nav">
			        <li><a href="Home.php"><div class="ws"><i class="fa fa-home"></i>Inicio</div></a></li>
			        <li><a href="Clientes.php"><div class="ws"><i class="fa fa-users"></i>Clientes</div></a></li>
			        <li><a href="Produtos.php"><div class="ws"><i class="fa fa-archive"></i>Produtos</div></a></li>
			        <li><a href="Lancamento.php"><div class="ws"><i class="fa fa-calculator"></i>Lançamento</div></a></li>
					<li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown"><div class="ws"><i class="fa fa-bar-chart"></i>Conferencia<span class="caret"></div></span></a>
			        	<ul class="dropdown-menu">
					        <li><a href="Conferencia.php"><div class="wsSubi"><i class="fa fa-user"></i>Cliente individual</div></a></li>
				            <li><a href="ConferenciaGeral.php"><div class="wsSubi"><i class="fa fa-users"></i>Todos os clientes</div></a></li>
				        </ul>
			        </li>
					<li class="active dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-balance-scale"></i>Estoque<span class="caret"></span></a>
			        	<ul class="dropdown-menu">
				          <li><a href="EstoqueCientes.php"><div class="wsSubi"><i class="fa fa-balance-scale"></i>Estoque Clientes</div></a></li>
				          <li><a href="TotalEstoque.php"><div class="wsSubi"><i class="fa fa-balance-scale"></i>Total Estoque</div></a></li>
				        </ul>
			        </li>
			        <?php 
			        	if($_SESSION['usuarioNivel'] != 3 ){
			        ?>
					<li><a href="Usuarios.php"><div class="ws"><i class="fa fa-user-secret"></i>Usuarios</div></a></li>
					<?php 
						}
			        ?>
			      </ul>
			      <ul class="nav navbar-nav navbar-right">
			        <li><a href="exit.php"><div class="ws"><i class="fa fa-sign-out"></i>Logout</div></a></li>
			      </ul>
			    </div>
			  </div>
			</nav>
		</header>
		<br><br><br>
	<section>

		<div class="container-wrapper">

			<div class="table-responsive form-table">
				<table class="table table-striped" data-graph-container-before="1"  data-graph-datalabels-enabled="1" data-graph-datalabels-align="center" data-graph-type="column" id="tabela">
					<thead>
						<tr>
							<form class="form-control" action="Ecliente.php" method="POST" id="CarregaCliente">
								<div class="form-inline">
									<div class="form-group">
										<select class="form-control" name="Cliente" required id="BoxCliente">
										</select>
									</div>
									<div class="form-group">
										<input type="submit" class="btn btn-block btn-success" value="Consultar" id="Consulta">
									</div>
								</div>
							</form>
						</tr>
						<tr>
							<th>Produtos</th>
							<th>Peso</th>
							<th>Volume</th>
						</tr>
						<tr>
							<th><input type="text" class="form-control" autofocus id="txtColuna1" placeholder="Busca..."/></th>
						</tr>
					</thead>
					<tbody>
						<?php 
							$conn = mysqli_connect($_SG['servidor'], $_SG['usuario'], $_SG['senha'], $_SG['banco']) or die ($msg[0]);
							if ($_SERVER['REQUEST_METHOD'] == 'POST') { 
								@$cliente = $_POST["Cliente"];

								@$_var["cliente"] = @$cliente;

								@$sqlClienteAtual = "SELECT Nome FROM cliente where ID = $cliente";
								@$ClienteAtual = mysqli_query($conn, $sqlClienteAtual);

								while($Rclinete = mysqli_fetch_assoc($ClienteAtual)){
									@$_var["RegistraClinete"] = $Rclinete["Nome"];
									echo "Cliente: ".$_var["RegistraClinete"];
								}

								@$sqlProduto = "SELECT ID from produto";
								@$qryProduto = mysqli_query($conn, $sqlProduto);
								
								@$_var["SomaPeso"] = 0;
								@$_var["SomaVolume"] = 0;
								@$_var["flag"] = 0;

								while(@$produto = mysqli_fetch_assoc($qryProduto)){

									@$IDProduto = $produto["ID"];

									@$sql = "SELECT `p`.`Nome`,`e`.`ProdutoID`, sum(`e`.`Volume`) AS `Volume`,sum(`e`.`Peso`) AS `Peso` 
										FROM (`estoque` `e` JOIN `produto` `p`)
										where `e`.`ClienteID` = $cliente
										AND `p`.`ID` = `e`.`ProdutoID`
										AND `e`.`ProdutoID` = $IDProduto";

									@$qry = mysqli_query($conn, $sql);

									while($resultado = mysqli_fetch_assoc($qry)){
										@$_var["SomaPeso"] = $_var["SomaPeso"] + @$resultado["Peso"];
										@$_var["SomaVolume"] = $_var["SomaVolume"] + @$resultado["Volume"];

										if(@$resultado["Peso"] < 0 || @$resultado["Volume"] < 0 ){
											@$_var["flag"] = 1;
											// echo "flag ativo";
										}

										if(@$resultado["Peso"] != NULL && @$resultado["Peso"] != 0 || @$resultado["Volume"] != NULL && @$resultado["Volume"] != 0 ){
										?>
							<tr>
								<td><?php echo @$resultado["Nome"] ?></td>
								<td><?php echo number_format(@$resultado["Peso"],2,",",".")." Kg";if($resultado["Peso"] < 0 ){ echo "<span class='text-danger'> - Erro! </span>";} ?></td>
								<td><?php echo number_format(@$resultado["Volume"],0,",",".")." un."; if($resultado["Volume"] < 0 ){ echo "<span class='text-danger'> - Erro! </span>";}?></td>
							</tr>
						<?php
										}// fim do if
									}//fim do while 01
								}//fim do while 02
						?>
						<?php 
							if(@$_var["flag"] == 1){
								echo "<tr class='text-danger'>";
						?>
						<?php
							}else{
								echo"<tr class='text-success'>";
							}
						?>
						<!-- botao impressao -->
						<div class="btn-group">
						  	<a class="btn btn-sm btn-primary dropdown-toggle" data-toggle="dropdown" href="#"><i class="fa fa-bars"></i> Download</a>
						  	<!-- <a class="btn btn-primary dropdown-toggle" data-toggle="dropdown" href="#">
							    <span class="fa fa-caret-down" title="Toggle dropdown menu"></span>
						  	</a> -->
						  	<ul class="dropdown-menu">
							    <li><a href="#" target="_blank" onclick="$('#tabela').tableExport({type:'pdf',pdfFontSize:'7',escape:'false'});"><i class="fa fa-file-pdf-o fa-fw"></i> PDF</a></li>
							    <li><a href="#" target="_blank" onclick="$('#tabela').tableExport({type:'png',escape:'false'});"><i class="fa fa-file-image-o fa-fw"></i> PNG</a></li>
					  		</ul>
						</div>
								<td>Total</td>
								<td><?php echo number_format(@$_var["SomaPeso"],2,",",".")." Kg"; ?></td>
								<td><?php echo number_format(@$_var["SomaVolume"],0,",",".")." un."; ?></td>
							</tr>
						<?php
							}
							if(@$_var["flag"] == 1){
								echo '<tfoot>
										<td class="text-danger">Erro: Ha valores (-) Negativos,</td>
										<td class="text-danger">interferindo no calculo do Total,</td>
										<td class="text-danger">Por favor corrija !</td>
									</tfoot>';
							}
						?>
					</tbody>
				</table>
			</div><br>
			<!-- Tabela nao formatada + grafico -->
			<div class="table-responsive ">
				<table class="table table-striped highchart" data-graph-container-before="1"  data-graph-datalabels-enabled="1" data-graph-datalabels-align="center" data-graph-type="column" id="tabela" style="display:none;">
					<caption><?php echo "Cliente: ".$_var["RegistraClinete"];?></caption>
					<thead>
						<tr>
							<th>Produtos</th>
							<th>Peso</th>
							<th>Volume</th>
						</tr>
					</thead>
					<tbody>
						<?php 
							$conn = mysqli_connect($_SG['servidor'], $_SG['usuario'], $_SG['senha'], $_SG['banco']) or die ($msg[0]);
							if ($_SERVER['REQUEST_METHOD'] == 'POST') { 
								@$cliente = $_POST["Cliente"];

								@$_var["cliente"] = @$cliente;

								@$sqlClienteAtual = "SELECT Nome FROM cliente where ID = $cliente";
								@$ClienteAtual = mysqli_query($conn, $sqlClienteAtual);

								while($Rclinete = mysqli_fetch_assoc($ClienteAtual)){
									@$_var["RegistraClinete"] = $Rclinete["Nome"];
									// echo "Cliente: ".$_var["RegistraClinete"];
								}

								@$sqlProduto = "SELECT ID from produto";
								@$qryProduto = mysqli_query($conn, $sqlProduto);
								
								@$_var["SomaPeso"] = 0;
								@$_var["SomaVolume"] = 0;
								@$_var["flag"] = 0;

								while(@$produto = mysqli_fetch_assoc($qryProduto)){

									@$IDProduto = $produto["ID"];

									@$sql = "SELECT `p`.`Nome`,`e`.`ProdutoID`, sum(`e`.`Volume`) AS `Volume`,sum(`e`.`Peso`) AS `Peso` 
										FROM (`estoque` `e` JOIN `produto` `p`)
										where `e`.`ClienteID` = $cliente
										AND `p`.`ID` = `e`.`ProdutoID`
										AND `e`.`ProdutoID` = $IDProduto";

									@$qry = mysqli_query($conn, $sql);

									while($resultado = mysqli_fetch_assoc($qry)){
										@$_var["SomaPeso"] = $_var["SomaPeso"] + @$resultado["Peso"];
										@$_var["SomaVolume"] = $_var["SomaVolume"] + @$resultado["Volume"];

										if(@$resultado["Peso"] < 0 || @$resultado["Volume"] < 0 ){
											@$_var["flag"] = 1;
											// echo "flag ativo";
										}

										if(@$resultado["Peso"] != NULL && @$resultado["Peso"] != 0 || @$resultado["Volume"] != NULL && @$resultado["Volume"] != 0 ){
										?>
							<tr>
								<td><?php echo @$resultado["Nome"] ?></td>
								<td><?php echo number_format(@$resultado["Peso"],0,""," ")." Kg";if($resultado["Peso"] < 0 ){ echo "<span class='text-danger'> - Erro! </span>";} ?></td>
								<td><?php echo number_format(@$resultado["Volume"],0,""," ")." un."; if($resultado["Volume"] < 0 ){ echo "<span class='text-danger'> - Erro! </span>";}?></td>
							</tr>
						<?php
										}// fim do if
									}//fim do while 01
								}//fim do while 02
							}
						?>
					</tbody>
				</table>
			</div>

		</div>
		<div class="table-responsive form-table">
			<?php 
			if ($_SERVER['REQUEST_METHOD'] == 'POST') { 
			//variaveis de uso geral
				@$_var["data"] = date("d-m-Y"); //data impressa 
				@$DataConsulta = date("Y-m-d",strtotime(@$_var["data"])); //data p/ realizar o calculo
				@$DataAnterior = time() - (1 * 24 * 60 * 60) ; 
				@$_var["OlderData"] = date('d-m-Y', $DataAnterior);
				@$_var["RegistraClinete"];
				@$cliente = @$_var["cliente"];
// ----------------------------------------------------------
				// varriaveis para armazenamento Temporario
				@$_var["EmbalagemPeso"] = 0;
				@$_var["EmbalagemVolume"] = 0;
				@$_var["ExpedicaoPeso"] = 0;
				@$_var["ExpedicaoVolume"] = 0;
				@$_var["AcertoPeso"] = 0;
				@$_var["AcertoVolume"] = 0;
				@$_var["OlderPeso"] = 0;
				@$_var["OlderVolume"] = 0;
// ----------------------------------------------------------				

				$conn = mysqli_connect($_SG['servidor'], $_SG['usuario'], $_SG['senha'], $_SG['banco']) or die ($msg[0]);

				@$ConsultaSituaçoes = "SELECT ID FROM situacao";
				@$qrySituacao = mysqli_query(@$conn, @$ConsultaSituaçoes);

				while(@$TempSituacao = mysqli_fetch_assoc(@$qrySituacao)){
					@$Tsituacao = @$TempSituacao["ID"];

					@$consultaEstoqueS1 = "SELECT `c`.`Nome` AS `Cliente`, `e`.`situacao` ,sum(`e`.`Volume`) AS `Total_Volume`, sum(`e`.`Peso`) AS `Total_Peso` 
						FROM (`estoque` `e` JOIN `produto` `p` JOIN `cliente` `c`)
						where`e`.`Data_Estoque` = '$DataConsulta'
						AND `e`.`ClienteID` = `c`.`ID`
						AND `e`.`ProdutoID` = `p`.`ID`
						AND `e`.`situacao` = $Tsituacao
						AND `e`.`ClienteID` = $cliente";

					@$qry = mysqli_query($conn, @$consultaEstoqueS1);

					while(@$TempResultado = mysqli_fetch_assoc(@$qry)){
						// echo $TempResultado["Cliente"]."<br>"; echo $TempResultado["Total_Volume"]."<br>"; echo $TempResultado["Total_Peso"]."<br>";
						if(@$TempResultado["situacao"] == 1){
							@$_var["AcertoPeso"] = @$TempResultado["Total_Peso"];
							@$_var["AcertoVolume"] = @$TempResultado["Total_Volume"];
						}//fim do if
						if(@$TempResultado["situacao"] == 2){
							@$_var["EmbalagemPeso"] = @$TempResultado["Total_Peso"];
							@$_var["EmbalagemVolume"] = @$TempResultado["Total_Volume"];
						}//fim do if
						if(@$TempResultado["situacao"] == 3){
							@$_var["ExpedicaoPeso"] = @$TempResultado["Total_Peso"];
							@$_var["ExpedicaoVolume"] = @$TempResultado["Total_Volume"];
						}
					}
				}

				@$consultaEstoqueS2 = "SELECT `c`.`Nome` AS `Cliente`, `e`.`situacao` , sum(`e`.`Volume`) AS `Total_Volume`, sum(`e`.`Peso`) AS `Total_Peso` 
							FROM (`estoque` `e` JOIN `produto` `p` JOIN `cliente` `c`)
							where`e`.`Data_Estoque` != '$DataConsulta'
							AND `e`.`ClienteID` = `c`.`ID`
							AND `e`.`ProdutoID` = `p`.`ID`
							AND `e`.`ClienteID` = $cliente";

				@$qryOlderEstoque = mysqli_query(@$conn, @$consultaEstoqueS2);

				while(@$OlderEstoque = mysqli_fetch_assoc(@$qryOlderEstoque)){
					@$_var["OlderPeso"] = @$OlderEstoque["Total_Peso"];
					@$_var["OlderVolume"] = @$OlderEstoque["Total_Volume"];
				}
			}
			?>
			<!-- botao impressao -->
			<div class="btn-group">
			  	<a class="btn btn-sm btn-primary dropdown-toggle" data-toggle="dropdown" href="#"><i class="fa fa-bars"></i> Download</a>
			  	<ul class="dropdown-menu">
				    <li><a href="#" target="_blank" onclick="$('#conferenciaTabela').tableExport({type:'pdf',pdfFontSize:'12',escape:'false'});"><i class="fa fa-file-pdf-o fa-fw"></i> PDF</a></li>
				    <li><a href="#" target="_blank" onclick="$('#conferenciaTabela').tableExport({type:'png',escape:'false'});"><i class="fa fa-file-image-o fa-fw"></i> PNG</a></li>
		  		</ul>
			</div>
			<table class="table" id="conferenciaTabela">
				<thead>
					<tr>
						<th><?php echo @$_var["RegistraClinete"]; ?></th>
					</tr>
					<tr>
						<th>Movimentação de Estoque:</th>
						<th>Peso</th>
						<th>Volume</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>Saldo Até: <?php echo "<span class='text-info'>".@$_var["OlderData"]."</span>"; ?></td>
						<td><?php echo number_format(@$_var["OlderPeso"],2,",",".")." Kg"; ?></td>
						<td><?php echo number_format(@$_var["OlderVolume"],0,",",".")." un."; ?></td>
					</tr>
					<tr class="success">
						<td>Acerto</td>
						<td><?php echo number_format(@$_var["AcertoPeso"],2,",",".")." Kg"; ?></td>
						<td><?php echo number_format(@$_var["AcertoVolume"],2,",",".")." un."; ?></td>
					</tr>
					<tr class="info">
						<td>Embalado</td>
						<td><?php echo number_format(@$_var["EmbalagemPeso"],2,",",".")." Kg"; ?></td>
						<td><?php echo number_format(@$_var["EmbalagemVolume"],2,",",".")." un."; ?></td>
					</tr>
					<tr class="danger">
						<td>Expedido</td>
						<td><?php echo number_format(@$_var["ExpedicaoPeso"],2,",",".")." Kg"; ?></td>
						<td><?php echo number_format(@$_var["ExpedicaoVolume"],2,",",".")." un."; ?></td>
					</tr>
					<tr>
						<td>Saldo Atual: <?php echo "<span class='text-info'>".@$_var["data"]."</span>"; ?></td>
						<!-- valores retornados do calculo anterior -->
						<td><?php echo number_format(@$_var["SomaPeso"],2,",",".")." Kg"; ?></td>
						<td><?php echo number_format(@$_var["SomaVolume"],0,",","")." un."; ?></td>
					</tr>
					<tr>
						<td>*</td>
						<td>Data Estoque:</td>
						<td><?php echo " ".@$_var["OlderData"]; ?></td>
					</tr>
					<tr>
						<td>*</td>
						<td>Data Digitação:</td>
						<td><?php echo " ".@$_var["data"]; ?></td>
					</tr>
				</tbody>
			</table>
		</div>
	</section>
<?php include_once "footer.php";?>
<a href="#top" id="top-link">Ir para o Topo</a>
    </body>
	<link rel="stylesheet" href="public/css/bootstrap.css">
	<link rel="stylesheet" href="public/css/styles.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<style type="text/css">
		.form-table-x{
		    background-color: #d8d8d8;
		    border-radius: 9px;
		    margin: 0 auto;
		    max-width: 800px;
		    padding: 15px;
		}
	</style>
	<!-- remover class form-table em telas menores que 640 -->
</html>