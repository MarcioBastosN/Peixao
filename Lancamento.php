<!DOCTYPE html>
<html ng-app>
    <?php include_once './seguranca.php';
    protegePagina();
    date_default_timezone_set('America/Belem');
    @$mesAnterior = time() - (30 * 24 * 60 * 60);
    @$OlderData = date('Y-m-d', $mesAnterior);
    @$proximomes = time() + (30 * 24 * 60 * 60);
    @$atual = date('Y-m-d');
    @$novadata = date('Y-m-d', $proximomes);
    ?>
    <head>
        <link rel="stylesheet" href="Isset/css/bootstrap.css">
        <link rel="stylesheet" href="Isset/css/styles.css">
        <link rel="stylesheet" type="text/css" href="Isset/FontAwesome/css/font-awesome.min.css">
<?php include_once './head.php'; ?>
        <script type="text/javascript" src="Isset/js/notification.js"></script>
        <script type="text/javascript" src="Isset/js/jquery.maskMoney.js"></script>
        <script type="text/javascript">
            $(document).ready(function () {
                $('#top-link').topLink({
                    min: 400,
                    fadeSpeed: 500
                });
                $('#top-link').click(function (e) {
                    e.preventDefault();
                    window.scrollTo(0, 0);
                });
                $(".valor").maskMoney({allowNegative: true, thousands: '.', decimal: ',', affixesStay: false, precision: 3});
                Box_Cliente_Ativo();
                Box_Produto();
                Box_Produto_Edicao();
                Box_Situacao();
                SelctBox_Produto_Edicao();
                SelectBox_Produto();
            <?php if ($_SESSION['usuarioNivel'] == 1) {echo "CarregaLancamentoAdmin();";} else {echo "CarregalancamentoUser();";} ?>
                CarregaModalLancamento();
                $("#ImprimeTab").on("click", function (event) {
                    event.preventDefault();
                    window.print();
                });
                setTimeout(function () {
                    carregarFiltros("tabela");
                }, 800);
                $('[data-toggle="popover"]').popover();
            });
        </script>
        <style type="text/css">
            input:invalid{background-color: rgba(230,230,0,0.4);color:black;}
        </style>
    </head>
    <body>
        <header>
<?php include_once './header.php'; ?>
        </header>
        <section style="padding-top:50px">
            <div class="container-fluid" id="nImprime">
                <div id="temptest">
                    <strong><h4>Edição de Lançamento</h4></strong>
                    <form class="form-inline" role="form" id="Atualiza_Produto_Lancamento" method="POST">
                        <div class="form-group">
                            <select class="form-control" name="cod">
                                <option id="cod_A">Cod</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <select class="form-control" id="BoxClienteAtivoTemp" name="Cliente_A" required>
                            </select>
                        </div>
                        <div class="form-group">
                            <input type="date" class="form-control" id="date_A" name="Data_A" value="" required>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" id="NR_A" name="NR_A" placeholder="NR" required>
                        </div>
                        <div class="form-group">
                             <input class="form-control" id="listProduto_A" list="BoxProduto_E" name="Peixe_A" placeholder="Produto" required>
                            <datalist id="BoxProduto_E">
                            </datalist>
                            <!--<select class="form-control" id="SelectBoxProduto_E" name="Peixe" required></select>-->
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control valor" id="PesoProduto_A" name="Peso_A"  title="Apenas Numeros" placeholder="Peso" required>
                        </div>
                        <div class="form-group">
                            <input type="number" class="form-control" id="VolumeProduto_A" name="Volume_A" pattern="\d" placeholder="Volume" required>
                        </div>
                        <div class="form-group">
                            <select class="form-control" id="BoxsituacaoTemp" name="Situacao_A" required>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="comment">Observacao:</label>
                            <input type="text" class="form-control" id="ObsProduto_A" name="Observacao_A" maxlength="100">
                        </div>
                        <div class="form-group" >
                            <input type="submit" onclick="" value="Confirmar Alteração" class="btn btn-success btn-block">
                        </div>
                        <div class="form-group" >
                            <input type="reset" onclick="CancelarEdicaoLancamento()" value="Cancelar" class="btn btn-danger btn-block">
                        </div>
                    </form>
                </div>

                <form class="form-inline" role="form" id="Editar_Oculta">
                    <?php if ($_SESSION['usuarioNivel'] == 3) { ?>
                        <button class="btn btn-primary form-control disabled">
                            Cadastrar Lan&ccedil;amento
                        </button>
                    <?php } else { ?>
                        <button ng-click="cadastrar = !cadastrar" class="btn btn-primary form-control">
                            <div ng-show="cadastrar">Cadastrar Lan&ccedil;amento</div>
                            <div ng-hide="cadastrar">Ocultar</div>
                        </button>
                    <?php } ?>
                    <span>
                        <a href="#" data-toggle="popover" data-trigger="focus" title="Info" data-content="Na Tabela abaixo são carregados os resultados para os últimos 30 dias, contando o dia atual !">Info</a>
                    </span>
                </form>
                    <?php if ($_SESSION['usuarioNivel'] != 3) { ?>
                    <div ng-hide="cadastrar" id="nImprime">
                    <?php if ($_SESSION['usuarioNivel'] == 1) {?>
                            <form class="form-inline" id="CadastraLancamento_Admin" role="form" method="POST" >
                    <?php } else { ?>
                                <form class="form-inline" id="CadastraLancamento_USER" role="form" method="POST" >
                    <?php } ?>
                                <div class="form-group">
                                    <select class="form-control" id="BoxClienteAtivo" name="Cliente" required>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <input type="date" class="form-control" name="Data" value="<?php echo "$atual" ?>" required>
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control" id="NR" name="NR" placeholder="NR" required>
                                </div>
                                <div class="form-group">
                                    <input class="form-control" id="listProduto" list="BoxProduto" name="Peixe" placeholder="Produto" required>
                                    <datalist id="BoxProduto"></datalist> 
                                    <!--<select class="form-control" id="SelectBoxProduto" name="Peixe" required></select>-->
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control valor" id="PesoProduto" name="Peso"  title="Apenas Numeros" placeholder="Peso" required>
                                </div>
                                <div class="form-group">
                                    <input type="number" class="form-control" id="VolumeProduto" name="Volume" pattern="\d" placeholder="Volume" required>
                                </div>
                                <div class="form-group">
                                    <select class="form-control" id="Boxsituacao" name="Situacao"  required>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="comment">Observacao:</label>
                                    <input type="text" class="form-control" id="ObsProduto" name="Observacao" maxlength="100">
                                </div>
                                <div class="form-group" >
                                    <input type="submit" onclick="" value="Inserir" class="btn btn-success btn-block">
                                </div>
                            </form>
                    </div>
                <?php } ?>
                <div ng-hide="cadastrar2">
                    <div class="row">
                        <div class="col-md-6">
                            <strong id="nImprime">Per&iacute;odo</strong>
                            <div class="form-inline">
                                <div class="form-group">
                                    <label for="De">De:</label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                        <input id="De" type="date" name="DataDe" class="form-control"  value="<?php echo "$OlderData" ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="Ate">At&eacute;:</label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                        <input id="Ate" type="date" name="DataAte" class="form-control"  value="<?php echo "$atual" ?>">
                                    </div>
                                </div>
                                <button onclick="TempData(<?php echo $_SESSION['usuarioNivel']; ?>);" class="btn btn-md btn-info">Buscar</button>
                            </div>
                        </div>
                        <div class="col-md-6" id="nImprime">
                            <div class="form-inline">
                                <strong>Total por Nota</strong>
                                <form id="Total_por_Nota" method="POST">
                                    <div class="btn-group">
                                        <input type="text" name="ConsultaNota" placeholder="Entre com a Nota" class="form-control" required>
                                    </div>
                                    <div class="btn-group">
                                        <input type="submit" value="Consultar" class="btn btn-block btn-info">
                                    </div>
                                </form>
                                <div id="Resultado_Total_Nota"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="DataConsulta">
<?php if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    @$Data_Inicio = $_GET["DataDe"];
    @$Data_Final = $_GET["DataAte"];
    ?>
                    <div class="form-group" id="nImprime">
                        <div class="btn-group" id="btn-imprime">
                            <a class="btn btn-primary form-control dropdown-toggle" data-toggle="dropdown" href="#"><i class="fa fa-bars"></i>Download Tabela</a>
                            <ul class="dropdown-menu">
                                <li><a href="#" target="_blank" onclick="$('#tabela').tableExport({type: 'excel', escape: 'false'});"><i class="fa fa-table"></i> Excel</a></li>
                                <li class="divider"></li>
                                <li><a href="#" target="_blank" id="ImprimeTab" ><i class="fa fa-print"></i> Imprimir</a></li>
                            </ul>
                        </div>
                    </div>
    <?php } ?>
            </div>
            <div class="table-responsive text-center">
                <table class="table" id="tabela">
                    <thead>
                        <?php
                        if ($_SESSION['usuarioNivel'] != 1) { echo '<tr>
                                    <th class="comFiltro">Cliente</th>
                                    <th class="comFiltro">Data</th>
                                    <th class="comFiltro" onchange="carrega();">NR</th>
                                    <th class="comFiltro">Peixe</th>
                                    <th>Peso</th>
                                    <th>Volume</th>
                                    <th class="comFiltro">Situa&ccedil;&atilde;o</th>
                                    <th class="nImprime">Observa&ccedil;&atilde;o</th>
                            </tr>';
                        } else { echo '<tr>
                                    <th class="comFiltro">Cliente</th>
                                    <th class="comFiltro">Data</th>
                                    <th class="comFiltro" onchange="carrega();">NR</th>
                                    <th class="comFiltro">Peixe</th>
                                    <th>Peso</th>
                                    <th>Volume</th>
                                    <th class="comFiltro">Situa&ccedil;&atilde;o</th>
                                    <th class="nImprime">Observa&ccedil;&atilde;o</th>
                                    <th class="nImprime">Excluir</th>
                                    <th class="nImprime">Editar</th>
                            </tr>';
                        }
                        ?>
                    </thead>
                    <tbody id="TabelaLancamento">
                    </tbody>
                </table>
            </div>
        </section>
        <br>
<?php include_once "footer.php"; ?>
        <a href="#top" id="top-link">Ir para o Topo</a>
        <div id="ModalObs">
        </div>
        <script>
            $(document).ready(function () {
                $('[data-toggle="popover"]').popover();
                $('[data-toggle="tooltip"]').tooltip();
            });
        </script>
    </body>
    <link rel="stylesheet" type="text/css" media="print" href="Isset/css/print.css" />
    <style type="text/css">
        .ObsDesativa{display: none;}
        @media print { *{border: 0pt;margin: 0pt;} #tabela tr td{font-size: 10pt;padding: 0pt;} #tabela tr th{padding: 5pt;} #tabela thead tr th{padding: 0pt;} tbody tr td{font-size: 10pt;padding: 0pt;}}
    </style>
    <script type="text/javascript">
        function TempData(valor) {
            var data1 = document.getElementById("De").value;
            var data2 = document.getElementById("Ate").value;
            var dados = "?DataAte=" + data2 + "&DataDe=" + data1;
            if (valor == 1) {
                DataLancamentoTemp_Admin(dados);
            } else {
                DataLancamentoTemp_User(dados);
            }
        }
        $("#temptest").hide();
    </script>
</html>