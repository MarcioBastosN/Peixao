<!DOCTYPE html>
<?php 
	include("seguranca.php"); 
	protegePagina();
?>
<html ng-app>
<head>
	<?php  
		include("head.php");
	?>
	<script type="text/javascript">
		$(document).ready(function(){
			$('[data-toggle="popover"]').popover();   
		});
	</script>
	<?php
		@$mesanterior = time() - (30 * 24 * 60 * 60) ; 
		@$atual = date('Y-m-d');
		@$anterior = date('Y-m-d', $mesanterior); 
	?>
</head>	
<body>
	<header>
		<?php include_once("header.php"); ?>
	</header>
	<section style="padding-top:50px">
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
				<form method="post" action="PHP_CRUD/pdf/pdf_geral_situacoes.php" >
					<!-- pdf2_saida -->
					<div class="container-fluid">
						<h2 class="text-center">Consulta</h2><br>
						<div class="form-inline">
							<label for="data">Data</label>
							<div class="form-group">
								<label for="data_I">De:</label>
								<input type="date" name="data_I" id="data_I" class="form-control" value="<?php echo "$anterior" ?>" required>
							</div>
							<div class="form-group">
								<label for="data_F">Até:</label>
								<input type="date" name="data_F" id="data_F" class="form-control" value="<?php echo "$atual" ?>" required>
							</div>
							<span>
								<a href="#" data-toggle="popover" data-trigger="focus" title="Info" data-content="Por padrão a consulta retorna o resultado para os últimos 30 dias, podendo ser alterado esse intervalo">Info</a>
							</span>
						</div>
						<div class="form-group">
							<label for="cliente">Cliente</label>
							<select class="form-control" name="cliente" ng-required="true">
								<option value="">Cliente</option>
								<?php
									@$conn = mysqli_connect($_SG['servidor'], $_SG['usuario'], $_SG['senha'], $_SG['banco']) or die ($msg[0]);
									@$consulta = "SELECT * FROM `cliente` ORDER BY Nome ";
									@$sql = mysqli_query($conn, $consulta);
									while($resultado = mysqli_fetch_assoc($sql)){
								?>
								<option value=<?php echo  @$resultado['ID'];?> ><?php echo @$resultado['Nome'] ?></option>
								<?php
									}
								?>
							</select>
						</div>
						<div class="form-group">
							<label for="situacao">Situação</label>
							<select class="form-control" name="situacao" required>
								<option value="">Situação</option>
								<?php
									@$conn = mysqli_connect($_SG['servidor'], $_SG['usuario'], $_SG['senha'], $_SG['banco']) or die ($msg[0]);
									@$consulta = "SELECT * FROM `situacao` ORDER BY ID ";
									@$sql = mysqli_query($conn, $consulta);
									while($resultado = mysqli_fetch_assoc($sql)){
								?>
								<option value=<?php echo  @$resultado['ID'];?> ><?php echo @$resultado['Tipo'] ?></option>
								<?php
									}
								?>
								<option value="A">Todas as Situações</option>
							</select>
						</div>		
						<input type="submit" class="btn btn-block btn-success" value="Gerar Pdf">
					</div>
				</form>			
			</div>
			<!-- proxima tela -->
			<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
				<form>
					<h2 class="text-center">Consulta 2</h2><br>
				</form>
			</div>
		</div>
	</section>
</body>
	<link rel="stylesheet" href="public/css/bootstrap.css">
	<link rel="stylesheet" href="public/css/styles.css">
	<link rel="stylesheet" type="text/css" href="public/FontAwesome/css/font-awesome.min.css">
</html>