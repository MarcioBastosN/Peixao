<!DOCTYPE html>
<html ng-app>
	<?php
            include_once './seguranca.php';
            include_once './conn/conexao.php';
            $conexao = new conexao();
            $conn = $conexao->getConexao();
            include_once './CRUD/RETRIAVE/R_ConsultaSituacoes.php';
            protegePagina();
            date_default_timezone_set('America/Belem');
            $proximomes = time() - (30 * 24 * 60 * 60) ;
	    @$atual = date('Y-m-d');
	    @$novadata = date('Y-m-d', $proximomes);
	?>
    <head>
        <?php include_once './head.php'; ?>
        <script type="text/javascript">
            $(document).ready(function(){
                $('#top-link').topLink({
                        min: 400,
                        fadeSpeed: 500
                });
                $('#top-link').click(function(e) {
                        e.preventDefault();
                        window.scrollTo(0,0);
                });
                Box_Cliente(),
                carregarFiltros("tabela");
            });
            // retorna as variaveis para consulta e inicia as funçoes;
            function CalculaSomaProduto(){
                var valor = document.getElementById("tabela_col_2").value;
                var ClienteS = document.getElementById("ClienteSelected").value;
                var DataI = document.getElementById("DataInicio").value;
                var DataF = document.getElementById("DataFim").value;
                var dadosurl = "?produto="+valor+"&cliente="+ClienteS+"&DataInicio="+DataI+"&DataFim="+DataF;

                TotalSomaProdutoAcerto(dadosurl);
                TotalSomaProdutoEmbalagem(dadosurl);
                TotalSomaProdutoExpedicao(dadosurl);
                TotalSomaProduto(dadosurl);
                NumeroNotas(dadosurl);
            }
        </script>
    </head>
    <body>
    <header>
        <?php include_once './header.php'; ?>
    </header>
    <section style="padding-top:50px">
        <div ng-hide="cadastrar">
            <form class="form-inline text-center nImprime" action="Conferencia.php" role="form" method="post">
                    <div class="form-group">
                        <select class="form-control" id="BoxCliente" name="Cliente" ng-required="true">
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Data</label>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                            <input type="date" class="form-control" name="Inicio" value="<?php echo "$novadata" ?>" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Hoje</label>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                            <input type="date" class="form-control" name="Fim" value="<?php echo "$atual" ?>" required>
                        </div>
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
                        @$Data_Inicio = filter_input(INPUT_POST, "Inicio");
                        @$Data_Final = filter_input(INPUT_POST, "Fim");
                        @$Cliente = filter_input(INPUT_POST, "Cliente");

                        $sqlCliente = "SELECT `Nome` FROM `cliente` WHERE `ID` = $Cliente ";
                        $querycliente = mysqli_query($conn, $sqlCliente);
                        while($Ret_cliente = mysqli_fetch_assoc($querycliente)){
                            @$_cliente = @$Ret_cliente["Nome"];
                        }

                        echo "<div class='container form-inline NaoVisivel'>
                                <div class='form-group'>
                                    Cliente:
                                    <select id='ClienteSelected'>
                                        <option value='".$_cliente."'>".$_cliente."</option>
                                    </select>
                                </div>
                                <div class='form-group'>
                                    Periodo De:
                                    <input id='DataInicio' class='form-control' value='".date("d-m-Y" ,strtotime(@$Data_Inicio))."' disabled></input>
                                </div>
                                <div class='form-group'>
                                    At&eacute;:
                                    <input id='DataFim' class='form-control' value='".date("d-m-Y" ,strtotime(@$Data_Final))."' disabled></input>
                                </div>";
                    ?>
                    <?php include_once './Op_Download.php'; ?>
                    <?php echo "</div>"; } ?>
                </div>
                <div class="ApenasPapel">
                    <div style="text-align:center">
                        <strong>Frigor&iacute;fico "O PEIX&Atilde;O"</strong><br>
                        <strong>
                            <?php
                                date_default_timezone_set('America/Belem');
                                setlocale(LC_ALL, NULL);
                                setlocale(LC_ALL, 'pt_BR');
                                echo "Santar&eacute;m".", ".date('d')." de ".date('M')." de ".date('Y');
                            ?>
                        </strong><br>
                        <strong> Cliente: <?php echo $_cliente." Periodo Selecionado:".date("d-m-Y" ,strtotime(@$Data_Inicio))." ate ".date("d-m-Y" ,strtotime(@$Data_Final)); ?> </strong>
                        <br/>
                    </div>
                </div>
                <section class="NaoVisivel">
                <?php
                    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                        echo '<div class="container-fluid text-center conferencia">'.
                                '<div class="row">'.
                                    '<div class="col-sm-4 " id="section4"><h4>Acerto</h4>'.RetornaAcerto().'</div>'.
                                    '<div class="col-sm-4 " id="section1"><h4>Embalagem</h4>'.RetornaEmbalagem().'</div>'.
                                    '<div class="col-sm-4 " id="section7"><h4>Expedição</h4>'.RetornaExpedicao().'</div>'.
                                '</div>'.
                            '</div>';
                    }
                ?>
                </section>
                    <div class="table-responsive text-center">
                        <table class="table table-striped" id="tabela">
                            <thead>
                                <tr>
                                    <th class="comFiltro">Data</th>
                                    <th class="comFiltro">NR</th>
                                    <th class="comFiltro" onchange="CalculaSomaProduto()">Produto</th>
                                    <th>Peso</th>
                                    <th>Volume</th>
                                    <th class="comFiltro">Situa&ccedil;&atilde;o</th>
                                </tr>
                                <tr></tr>
                            </thead>
                                    <!-- substituir por uma função Js -->
                            <?php
                                @$Cliente = filter_input(INPUT_POST, "Cliente");
                                @$Data_Inicio = filter_input(INPUT_POST, "Inicio");
                                @$Data_Final = filter_input(INPUT_POST, "Fim");

                                $consulta = "SELECT
                                            `C`.`Nome` as Cliente, `P`.`Nome` as Produto, `E`. `NR` as NR, `E`.`Volume` as Volume,
                                            `E`.`Peso` as Peso, `E`.`situacao` as situacao, `S`.`Tipo` as S_Tipo, `E`.`Data_Estoque` as Data_Estoque,
                                            `E`.`Data_Digitacao` as Data_Digitacao, `E`.`observacao` as observacao
                                        FROM ((`estoque` `E` JOIN `produto` `P`) JOIN `cliente` `C` JOIN `situacao` `S`)
                                        WHERE ((`E`.`Data_Estoque` between ('$Data_Inicio') AND ('$Data_Final') ) AND `C`.`ID` = ('$Cliente')
                                        AND ( `C`.`ID` = `E`.`ClienteID`) AND (`E`.`ProdutoID` = `P`.`ID`) AND (`S`.`ID` = `E`.`situacao`)) ;";
                                $sql = mysqli_query($conn, $consulta);
                                while($resultado = mysqli_fetch_assoc($sql)){
                                ?>
                            <tbody>
                                <tr>
                                    <td><?php echo date("d-m-Y", strtotime($resultado["Data_Estoque"])); ?></td>
                                    <td><?php echo $resultado["NR"]; ?></td>
                                    <td><?php echo $resultado["Produto"]; ?></td>
                                    <td><?php echo number_format($resultado["Peso"],3,",",".")." Kg"; ?></td>
                                    <td><?php echo $resultado["Volume"]; ?></td>
                                    <td><?php echo $resultado["S_Tipo"]; ?></td>
                                </tr>
                            <?php
                                }
                            ?>
                            </tbody>
                    </table>
            </div><br>
            <!-- impressao somas papel-->
            <section class="ApenasPapel">
            <?php
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    echo '<div class="table-responsive" style="margin:auto;">'.
                            '<table>'.
                                '<thead><tr><th>Acerto</th><th>Embalagem</th><th>Expedição</th></tr></thead>'.
                                '<tbody><tr>'.
                                    '<td>'.RetornaAcerto().'</td>'.
                                    '<td>'.RetornaEmbalagem().'</td>'.
                                    '<td>'.RetornaExpedicao().'</td>'.
                                '</tr></tbody>'.
                            '</table>'.
                        '</div>';
                }
            ?>
            </section>
			<!-- fim somas papel -->
                <div class="container-fluid NaoVisivel">
                    <div class="row confereciaBackground">
                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6" style="background-color:#9494b8; padding:0px;">
                            <table id="SomaAcerto" class="table table-condensed">
                                    <!-- resultado soma dos produtos Acerto-->
                            </table>
                            <table id="SomaEmbalagem" class="table table-condensed">
                                    <!-- resultado soma dos produtos Embalagem-->
                            </table>
                            <table id="SomaExpedicao" class="table table-condensed">
                                    <!-- resultado soma dos produtos Expedição-->
                            </table>
                            <table id="RespostaSoma" class="table table-condensed">
                                    <!-- resultado soma dos produtos -->
                            </table>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6" style="background-color:#d1d1e0; padding:0px;">
                            <table class="table table-condensed">
                                <thead>
                                    <tr><th>Numero das Notas Encontradas</th></tr>
                                </thead>
                                <tbody id="NotasProdutos"></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </section>
<?php include_once './footer.php'; ?>
<a href="#top" id="top-link">Ir para o Topo</a>
	<script type="text/javascript">
            $(document).ready(function(){
                $('[data-toggle="popover"]').popover();
                    $("#btn-imprime li a").on("click", function(event){
                            event.preventDefault();
                    });
                    $("#Imprimir").on("click",function(){
                            window.print();
                    });
            });
	</script>
    </body>
	<link rel="stylesheet" href="Isset/css/bootstrap.css">
        <link rel="stylesheet" href="Isset/css/styles.css">
        <link rel="stylesheet" type="text/css" href="Isset/FontAwesome/css/font-awesome.min.css">
        <link rel="stylesheet" type="text/css" media="print" href="Isset/css/print.css" />
        <style type="text/css">
            .confereciaBackground .table{ margin-bottom: 0px; }
            .conferencia .col-sm-4{ display: inline-table; }
            .ApenasPapel{ display:none; }
            .NaoVisivel{ display: block; }
            @media print {
                .ApenasPapel{ display:block; }
                .NaoVisivel{ display:none; }
            }
        </style>
</html>