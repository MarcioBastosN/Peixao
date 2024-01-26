<!DOCTYPE html>
<html ng-app>
	<?php 
		include("seguranca.php");
		include("conn.php");
		protegePagina();
		date_default_timezone_set('America/Belem');
		$proximomes = time() - (30 * 24 * 60 * 60) ; 
	    @$atual = date('Y-m-d');
	    @$novadata = date('Y-m-d', $proximomes); 
	?>
	<head>
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
	        });
	    </script>
	</head>
    <body>
	<div class="container-fluid">
		<header>
			<?php include_once("header.php"); ?>
		</header>
		<section style="padding-top:50px">
			<div ng-hide="cadastrar" class="nImprime">
				<form class="form-inline text-center" action="ConferenciaGeral.php" role="form" method="post">
	 			    <div class="form-group">
	 			    	<label>Data</label>
	 			    	<div class="input-group">
							<span class="input-group-addon"><i class="fa fa-calendar"></i></span> 
				        	<input type="date" class="form-control" name="Inicio" value="<?php echo "$novadata"; ?>"  required>
				        </div>
				    </div>
		 		    <div class="form-group">
		 		    	<label>Hoje</label>
		 		    	<div class="input-group">
							<span class="input-group-addon"><i class="fa fa-calendar"></i></span> 
				        	<input type="date" class="form-control" name="Fim" value="<?php echo "$atual"; ?>" required>
				        </div>
				    </div>
		 		    <div class="form-group">
				           <select class="form-control" name="Situacao" ng-required="true">
				        	<option value="">Situa&ccedil;&atilde;o</option>
				        	<?php
				        		@$conn = mysqli_connect($_SG['servidor'], $_SG['usuario'], $_SG['senha'], $_SG['banco']) or die ($msg[0]);

							    @$consulta = "SELECT * FROM `situacao` ORDER BY ID ;";
							    $sql = mysqli_query($conn, $consulta);
							    while($resultado = mysqli_fetch_assoc($sql)){
							?>
							<option value=<?php echo  @$resultado['ID'];?> ><?php echo @$resultado['Tipo']; ?></option>
							<?php
								}
							?>
				        </select>
				    </div>			    
				    <div class="form-group">
				        <input type="submit" value="Buscar" class="btn btn-success form-control">
				    </div>
				    <div class="form-group">
						<span>
				    		<a href="#" data-toggle="popover" data-trigger="focus" title="Info" data-content="A pesquisa por Datas retorna inicialmente o lançamento para os últimos 30 dias">Info</a>
						</span>
				    </div>
				</form>
			</div>
			<div id="datas">
				<?php 
				if ($_SERVER['REQUEST_METHOD'] == 'POST') { 
					@$Data_Inicio = $_POST["Inicio"];
					@$Data_Final = $_POST["Fim"];
					@$Situacao = $_POST["Situacao"];

					@$Temp_resultado = @$Situacao;
					@$sqlSituacao = "SELECT `Tipo` FROM `situacao` WHERE `ID` = $Temp_resultado ;";
					@$querySituacao = mysqli_query(@$conn, @$sqlSituacao);
					while(@$Ret_situacao = mysqli_fetch_assoc(@$querySituacao)){
						@$R_situacao = @$Ret_situacao["Tipo"];
					}
					echo "Periodo De:".date("d/m/Y" ,strtotime(@$Data_Inicio))." At&eacute;: ".date("d/m/Y" ,strtotime(@$Data_Final))." Situa&ccedil;&atilde;o: ".@$R_situacao;
				?>
					<a href="#" onclick="window.print();">Imprimir</a>
				<?php 
					}
				?>
			</div>
			<div class="row" style="padding-top:5px">
				<?php
					@$Data_Inicio = $_POST["Inicio"];
					@$Data_Final = $_POST["Fim"];
					@$condicao = $_POST["Situacao"];

					@$R_situacao;

					$conn = mysqli_connect($_SG['servidor'], $_SG['usuario'], $_SG['senha'], $_SG['banco']) or die ($msg[0]);

					$Ret_Cliente = "SELECT ID, Nome FROM cliente ORDER BY Nome ;";
					$sqlCliente = mysqli_query($conn, $Ret_Cliente);

					while($resultadoCliente = mysqli_fetch_assoc($sqlCliente)){

						$TempCliente = $resultadoCliente["ID"];
							$consulta = "SELECT 
								clienteID, `c`.`Nome` as cliente, 
								sum(`e`.`Volume`) as `Volume`, 
								sum(`e`.`Peso`) as `Peso`, 
								situacao, 
								Data_Estoque
						    FROM 
						    	(`estoque` `e` join `cliente` `c`)
						    WHERE
						    	(`e`.`Data_Estoque` between ('$Data_Inicio') AND ('$Data_Final')
						    	and (`c`.`ID` = '$TempCliente')
						    	and (`e`.`ClienteID` = `c`.`ID`)
						    	and (`e`.`situacao` = '$condicao'));";
						$sql = mysqli_query($conn, $consulta);
						while($resultado = mysqli_fetch_assoc($sql)){
					?>
				<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4" style="background-color:rgba(100,100,100,0.6);color:White;border-radius:7px">
					<p style="background-color:blue;border-radius:15px" class="text-center lead">
						<?php echo $resultadoCliente['Nome']; ?>
					</p>
					<?php 
						if($resultado['Volume'] != null || $resultado['Volume'] != 0 || $resultado['Peso'] != null || $resultado['Peso'] != 0){
							echo "<p style='color:green'>";
						}else{
							echo "<p style='color:white'>";		
						}
					?>
					<?php 
						@$Temp_resultado = $resultado['situacao'];
						@$sqlSituacao = "SELECT `Tipo` FROM `situacao` WHERE `ID` = $Temp_resultado ;";
						@$querySituacao = mysqli_query(@$conn, @$sqlSituacao);
						while(@$Ret_situacao = mysqli_fetch_assoc(@$querySituacao)){
							@$R_situacao = @$Ret_situacao["Tipo"];
						}
					?>
					<td><?php echo "Volume: ".number_format($resultado['Volume'],0,",","."); ?></td><br>
		    		<td><?php echo "Peso: ".number_format($resultado['Peso'],0,",",".")." Kg"; ?></td><br>
		    		<td><?php echo "Situa&ccedil;&atilde;o: ".@$R_situacao; ?>
		    		</td><br>
		    		<?php
						echo "</p>";
					?>
		    	</div>
				<?php
						}
					}
				?>
		    </div>
	    </section>
	</div>
<?php include_once "footer.php";?>
<a href="#top" id="top-link">Ir para o Topo</a>
<script type="text/javascript">
	$(document).ready(function(){
	    $('[data-toggle="popover"]').popover();   
	});
</script>
    </body>
	<link rel="stylesheet" href="Isset/css/bootstrap.css">
        <link rel="stylesheet" href="Isset/css/styles.css">
        <link rel="stylesheet" type="text/css" href="Isset/FontAwesome/css/font-awesome.min.css">
        <link rel="stylesheet" type="text/css" media="print" href="Isset/css/print.css" />
</html>
