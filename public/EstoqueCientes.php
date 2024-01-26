<!DOCTYPE html>
<html>
    <?php
    include_once './seguranca.php';
    protegePagina();
    include_once './conn/conexao.php';
    include_once './dao/daoEstoque.php';
    $conexao = new conexao();
    $daoEstoque = new daoEstoque();
    date_default_timezone_set('America/Belem');
    $_var["data"] = date("d-m-Y"); //data impressa
    $DataConsulta = date("Y-m-d", strtotime($_var["data"])); //data p/ realizar o calculo
    $DataAnterior = time() - (1 * 24 * 60 * 60);
    $_var["OlderData"] = date('d-m-Y', $DataAnterior);
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
                Box_Cliente();
                $('table.highchart').highchartTable();
            });
        </script>
    </head>
    <body>
        <header>
            <?php require_once './header.php'; ?>
        </header>
        <section style="padding-top:50px">
            <div class="container-wrapper">
                <div class="form-table">
                    <div style="text-align:center" id="TextoLogo">
                        <strong>Frigorifico "O PEIX&Atilde;O"</strong><br>
                        <strong>Demonstrativo de Peixe Embalado e Estocado</strong><br>
                        <strong>
                            <?php
                            date_default_timezone_set('America/Belem');
                            echo date('d') . " de " . date('M') . " de " . date('Y');
                            ?>
                        </strong><br>
                    </div>
                </div>
                <div class="table-responsive form-table" >
                    <table class="table table-striped" data-graph-container-before="1"  data-graph-datalabels-enabled="1" data-graph-datalabels-align="center" data-graph-type="column" id="tabela">
                        <thead>
                            <tr id="nImprime">
                        <form class="form-control" action="EstoqueCientes.php" method="POST" id="CarregaCliente">
                            <!-- utilizar função Js -->
                            <div class="form-inline" id="nImprime">
                                <div class="form-group">
                                    <select class="form-control" name="Cliente" id="BoxCliente" required >
                                        <!-- local script -->
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
                            <th>Volume</th>
                            <th>Peso</th>
                        </tr>
                        <tr>
                            <th><input type="text" class="form-control" autofocus id="txtColuna1" placeholder="Busca..."/></th>
                        </tr>
                        </thead>
                        <tbody>
                            <?php
                            function limparPonto($valor) {
                                $valor = trim($valor);
                                $valor = str_replace(".", "", $valor);
                                return $valor;
                            }
                            function limparVirgula($valor) {
                                $valor = str_replace(",", ".", $valor);
                                return $valor;
                            }

                            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                                $conn = $conexao->getConexao();
                                $daoEstoque = new daoEstoque();
                                $cliente = filter_input(INPUT_POST, "Cliente");
                                $_var["cliente"] = $cliente;
                                $sqlClienteAtual = "SELECT Nome FROM cliente where ID = $cliente ;";
                                $ClienteAtual = mysqli_query($conn, $sqlClienteAtual);
                                while ($Rcliente = mysqli_fetch_assoc($ClienteAtual)) {
                                    $_var["RegistraClinete"] = $Rcliente["Nome"];
                                    echo "<p> Cliente: " . $_var["RegistraClinete"] . "</p>";
                                }
                                $_var["SomaVolume"] = 0; $_var["SomaPeso"] = 0; $_var["flag"] = 0; $contLinhas = 0;
                                foreach ($daoEstoque->TabelaEstoque_Formatada($cliente) as $id => $dados){
                                    $contLinhas +=1;
                                    $_var["SomaVolume"] += str_replace('.', '', $dados["Volume"]);
                                    $t = limparPonto($dados["Peso"]);
                                    $t = limparVirgula($t);
                                    $_var["SomaPeso"] += $t;
                                    
                                    if($dados["Volume"] < 0 || $dados["Peso"] < 0){
                                        if($contLinhas == 34){
                                            $contLinhas = 0;
                                            echo "<tr class='text-danger' id='Divide_folha'>";
                                            $_var["flag"] = 1;
                                        }else{
                                            echo "<tr class='text-danger' id='$contLinhas'>";
                                            $_var["flag"] = 1;
                                        }
                                    }else{
                                        if($contLinhas == 34){
                                        $contLinhas = 0;
                                        echo"<tr class='text-success' id='Divide_folha'>";
                                        }else{
                                            echo"<tr class='text-success' id='$contLinhas'>";
                                        }
                                    }
                                    echo "<td>".$dados['Nome']."</td>"."<td>".$dados['Volume']."</td>"."<td>".$dados['Peso']."</td>"."</tr>";
                                }
                                $conexao->fecharConexao();
                            }
                            ?>
                            <!-- botao impressao -->
                            <?php include_once './Op_Download.php'; ?>
                            <tr>
                            <td>Total</td>
                            <td><?php echo number_format(@$_var["SomaVolume"],0,",",".") . " un."; ?></td>
                            <td><?php echo number_format(@$_var["SomaPeso"],3,",",".") . " Kg"; ?></td>
                            </tr>
                            <?php
                        if (@$_var["flag"] === 1) {
                            echo '<tfoot>
                                    <td class="text-danger">Erro: Ha valores (-) Negativos,</td>
                                    <td class="text-danger">interferindo no calculo do Total,</td>
                                    <td class="text-danger">Por favor corrija !</td>'
                            . "<div class='table-responsive'>
                                <table class='table-condensed' id='rodapeImpresso'>
                                        <tbody>
                                            <tr>
                                                <td>Data Estoque:</td>
                                                <td>" . $_var['OlderData'] . "</td>
                                            </tr>
                                            <tr>
                                                <td>Data Digita&ccedil;&atilde;o:</td>
                                                <td>" . $_var['data'] . "</td>
                                            </tr>
                                            <tr class='Assinatura'>
                                                <td>Estoquista: </td>
                                                <td><hr></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>" .
                            '</tfoot>';
                        } else {
                            echo "<tfoot><tr>
                                <div class='table-responsive'>
                                    <table class='table-condensed' id='rodapeImpresso'>
                                        <tbody>
                                            <tr>
                                                <td>Data Estoque:</td>
                                                <td>" . $_var['OlderData'] . "</td>
                                            </tr>
                                            <tr>
                                                <td>Data Digita&ccedil;&atilde;o:</td>
                                                <td>" . $_var['data'] . "</td>
                                            </tr>
                                            <tr class='Assinatura'>
                                                <td>Estoquista: </td>
                                                <td><hr></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                        </tr></tfoot>";
                        }
                        ?>
                        </tbody>
                    </table>
                </div><br>
                <!-- Tabela nao formatada + grafico -->
                <div class="table-responsive" id="nImprime">
                    <table class="table table-striped highchart" data-graph-container-before="1"  data-graph-datalabels-enabled="1" data-graph-datalabels-align="center" data-graph-type="column" id="tabela" style="display:none;">
                        <caption><?php echo "Cliente: " . @$_var["RegistraClinete"]; ?></caption>
                        <thead>
                            <tr>
                                <th>Produtos</th>
                                <th>Peso</th>
                                <th>Volume</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $conn = $conexao->getConexao();
                            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                                $cliente = $_POST["Cliente"];
                                $_var["cliente"] = $cliente;
                                $sqlClienteAtual = "SELECT Nome FROM cliente where ID = $cliente";
                                $ClienteAtual = mysqli_query($conn, $sqlClienteAtual);
                                while ($Rcliente = mysqli_fetch_assoc($ClienteAtual)) {
                                    $_var["RegistraClinete"] = $Rcliente["Nome"];
                                }
                                $sqlProduto = "SELECT `ID` FROM `produto` ORDER BY `Nome`;";
                                $qryProduto = mysqli_query($conn, $sqlProduto);
                                $_var["SomaPeso"] = 0; $_var["SomaVolume"] = 0; $_var["flag"] = 0;
                                while ($produto = mysqli_fetch_assoc($qryProduto)) {
                                    $IDProduto = $produto["ID"];
                                    $sql = "SELECT `p`.`Nome`,`e`.`ProdutoID`, sum(`e`.`Volume`) AS `Volume`,sum(`e`.`Peso`) AS `Peso`
                                            FROM (`estoque` `e` JOIN `produto` `p`) where `e`.`ClienteID` = $cliente AND `p`.`ID` = `e`.`ProdutoID` AND `e`.`ProdutoID` = $IDProduto ;";
                                    $qry = mysqli_query($conn, $sql);
                                    while ($resultado = mysqli_fetch_assoc($qry)) {
                                        $_var["SomaPeso"] = $_var["SomaPeso"] + $resultado["Peso"];
                                        $_var["SomaVolume"] = $_var["SomaVolume"] + $resultado["Volume"];
                                        if ($resultado["Peso"] < 0 || $resultado["Volume"] < 0) { $_var["flag"] = 1; }
                                        if ($resultado["Peso"] != NULL && $resultado["Peso"] != 0 || $resultado["Volume"] != NULL && $resultado["Volume"] != 0) {
                                            ?>
                                            <tr>
                                                <td><?php echo $resultado["Nome"] ?></td>
                                                <td>
                                                    <?php
                                                    echo number_format($resultado["Volume"], 0, "", " ") . " un.";
                                                    if ($resultado["Volume"] < 0) { echo "<span class='text-danger'> - Erro! </span>"; }
                                                    ?>
                                                </td>
                                                <td><?php
                                            echo number_format($resultado["Peso"], 3, "", " ") . " Kg";
                                            if ($resultado["Peso"] < 0) { echo "<span class='text-danger'> - Erro! </span>"; }
                                            ?></td>
                                            </tr>
                <?php
            }// fim do if
        }//fim do while 01
    }//fim do while 02
    $conexao->fecharConexao();
}
?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="table-responsive form-table">
<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $_var["RegistraClinete"];
    $cliente = $_var["cliente"];
}
?>
                <div id="nImprime">
                    <table class="table" id="conferenciaTabela" style="page-break-before: always;">
                        <thead>
                            <tr>
                                <th><?php echo @$_var["RegistraClinete"]; ?></th>
                            </tr>
                            <tr>
                                <th>Movimenta&ccedil;&atilde;o de Estoque:</th>
                                <th>Volume</th>
                                <th>Peso</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                            <?php
                                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                                    $cliente = $_var["cliente"];
                                    echo $daoEstoque->RetornaEstoqueAnteriorFormatado($cliente);
                                }
                            ?>
                            </tr>
                            <?php
                                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                                    $cliente = $_var["cliente"];
                                    echo $daoEstoque->TotalEstoqueSituacaoFormatado($cliente);
                                }
                            ?>
                            <tr>
                                <td>Saldo Atual: <?php echo "<span class='text-info'>" . $_var["data"] . "</span>"; ?></td>
                                <!-- valores retornados do calculo anterior -->
                                <td><?php echo number_format(@$_var["SomaVolume"], 0, ",", ".") . " un."; ?></td>
                                <td><?php echo number_format(@$_var["SomaPeso"], 3, ",", ".") . " Kg"; ?></td>
                            </tr>
                            <tr>
                                <td>*</td>
                                <td>Data Estoque:</td>
                                <td><?php echo $_var["OlderData"]; ?></td>
                            </tr>
                            <tr>
                                <td>*</td>
                                <td>Data Digita&ccedil;&atilde;o:</td>
                                <td><?php echo $_var["data"]; ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
        <div id="nImprime">
<?php include_once './footer.php'; ?>
        </div>
        <a href="#top" id="top-link">Ir para o Topo</a>
    </body>
    <link rel="stylesheet" href="Isset/css/bootstrap.css">
    <link rel="stylesheet" href="Isset/css/styles.css">
    <link rel="stylesheet" type="text/css" href="Isset/FontAwesome/css/font-awesome.min.css">
    <style type="text/css">
        .form-table-x{background-color: #d8d8d8;border-radius: 9px;margin: 0 auto;max-width: 800px;padding: 15px;}.Assinatura td hr{width: 300px;border: black 0.5px solid;}#ApenasImpressao{display: block;}
        @media print {html, body {width: 100%; height: 100%; margin: 0;padding: 0; } *{border: 0pt; margin: 0pt; padding: 0pt;} section{margin: 0pt; padding: 0pt;} #TextoLogo strong{margin: 0pt; padding: 0pt;} .form-table{margin: 0pt; padding: 0pt;} section strong{margin: 0pt; padding: 0pt;} #rodapeImpresso tr td{margin: 0pt; padding: 0pt;} #tabela tr td{font-size: 10pt; padding: 0pt;} #tabela tr th{padding: 5pt;} #tabela thead tr th{padding: 0pt;} tfoot{padding: 0pt;} tfoot tr{padding: 0pt;} tfoot td{padding: 0pt;} tfoot tr td{padding: 0pt;} tbody p{margin: 0pt;padding: 0pt;} tbody tr td{font-size: 10pt; padding: 0pt;} #Divide_folha{page-break-before: always;}}
    </style>
    <link rel="stylesheet" type="text/css" media="print" href="Isset/css/print.css" />
</html>