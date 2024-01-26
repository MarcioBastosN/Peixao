<!DOCTYPE html>
<html ng-app>
    <?php
    require_once './seguranca.php';
    protegePagina();
    include_once './conn/conexao.php';
    include_once './dao/daoEstoque.php';
    ?>
    <head id="top">
<?php require_once './head.php'; ?>
        <script>
            $(document).ready(function () {
                $('#top-link').topLink({
                    min: 400,
                    fadeSpeed: 500
                });
                $('#top-link').click(function (e) {
                    e.preventDefault();
                    window.scrollTo(0, 0);
                });
                TotalEstoque();
            });
        </script>
    </head>
    <body>
    <header>
        <?php require_once './header.php'; ?>
    </header>
    <section style="padding-top:50px">
        <div class="form-table">
            <div style="text-align:center">
                <strong>Frigor&iacute;fico "O PEIX&Atilde;O"</strong><br>
                <strong>Relat&oacute;rio de Peixe na Camara de Estocagem</strong><br>
                <strong>
                <?php
                    date_default_timezone_set('America/Belem');
                    setlocale(LC_ALL, NULL);
                    setlocale(LC_ALL, 'pt_BR');
                    echo "Santar&eacute;m" . ", " . date('d') . " de " . date('M') . " de " . date('Y');
                ?>
                </strong><br>
            </div>
            <div class="table-responsive form-table">
                <div class="btn-group" id="btn-imprime2" >
                    <?php require_once './Op_Download.php'; ?>
                </div>
                <table class="table table-striped" data-graph-container-before="1" data-graph-type="column" id="tabela">
                    <thead>
                        <tr>
                            <th>
                                <?php
                                date_default_timezone_set('America/Belem');
                                @$Data = date("d-m-Y");
                                @$Hora = date("H:i:s");
                                echo "<span><h4>Total Estocado at&eacute;: " . $Data . " as " . $Hora . "</h4></span>";
                                ?>
                            </th>
                        </tr>
                        <tr>
                            <th>Cliente(s)</th>
                            <th>Volume</th>
                            <th>Peso</th>
                        </tr>
                    </thead>
                    <tbody id="totalestoque">
                    </tbody>
                    <tfoot id="TotalSoma">
                    </tfoot>
                </table>
                <div id="ErroEstoque"></div>
            </div>
            <div class="table-responsive form-table nImprime" id="tab2" >
                <table class="table table-striped highchart" data-graph-container-before="1"  data-graph-datalabels-enabled="1" data-graph-datalabels-align="center" data-graph-type="column" id="" style="display:none">
                    <caption>Estoque</caption>
                    <thead>
                        <tr>
                            <th>Cliente(s)</th>
                            <th>Volume</th>
                            <th>Peso</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $listaEstoque = new daoEstoque();
                            foreach ($listaEstoque->DadosEstoque() as $pos => $dados){
                                echo '<tr class="text-success"><td>' . $dados["Cliente"] . '</td><td>' . $dados["Total_Volume"] . '</td><td>' . $dados["Total_Peso"] . '</td></tr>';
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
    <?php require_once './footer.php'; ?>
        <a href="#top" id="top-link">Ir para o Topo</a>
    </body>
    <script type="text/javascript">
        $(document).ready(function () {
            // instancia o grafico
            setTimeout(function () {
                $('table.highchart').highchartTable();
            }, 1000);
        });
    </script>
    <link rel="stylesheet" href="Isset/css/bootstrap.css">
    <link rel="stylesheet" href="Isset/css/styles.css">
    <link rel="stylesheet" type="text/css" href="Isset/FontAwesome/css/font-awesome.min.css">
    <style type="text/css">
        .oculta{display: none;}
    </style>
    <link rel="stylesheet" type="text/css" media="print" href="Isset/css/print.css" />
</html>