	<title>Peixão</title>
	<link rel="icon" type="image/png" href="Isset/images/07.ico" />
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1">

        <script src="Isset/js/jquery/jquery.js"></script>
	<script src="Isset/js/bootstrap.js"></script>
	<script src="Isset/js/angular/angular.js"></script>

	<?php
		#captura o host via php para trabalhar nos arquivo js;
		@$url = $_SERVER['HTTP_HOST'];
		echo '<script>var ip = "'. $url .'";</script>';
	?>

	<script type="text/javascript" src="Isset/js/script.js"></script>
	<script type="text/javascript" src="Isset/js/Funcoes.js"></script>
        <script type="text/javascript" src="Isset/js/interface.js"></script>
	<!-- manipular grafico -->
	<script type="text/javascript" src="Isset/js/graph/highcharts.js"></script>
	<script type="text/javascript" src="Isset/js/graph/highchartTable.js"></script>
	<script type="text/javascript" src="Isset/js/graph/exporting.js"></script>
	<!-- filtro Pesquisas -->
	<script type="text/javascript" src="Isset/js/jFilterXCel2003.js"></script>
	<!-- manipular tabela -->
	<script type="text/javascript" src="Isset/js/tableExport/tableExport.js"></script>
	<script type="text/javascript" src="Isset/js/tableExport/jquery.base64.js"></script>
	<!-- formatos para impressao -->
	<script type="text/javascript" src="Isset/js/tableExport/jspdf/libs/sprintf.js"></script>
	<script type="text/javascript" src="Isset/js/tableExport/jspdf/jspdf.js"></script>
	<script type="text/javascript" src="Isset/js/tableExport/jspdf/libs/base64.js"></script>
	<script type="text/javascript" src="Isset/js/tableExport/html2canvas.js"></script>
