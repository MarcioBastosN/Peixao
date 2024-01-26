<!DOCTYPE html>
<html ng-app>
    <?php include_once './seguranca.php';
    protegePagina();
    ?>
    <head>
        <?php include_once './head.php'; ?>
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
        <?php if ($_SESSION['usuarioNivel'] <= 2) {echo "Atualizar_Produtos_Admin();";} else {echo "Atualizar_Produtos();";} ?>
            });
        </script>
    </head>
    <body>
        <header>
            <?php include_once './header.php'; ?>
        </header>
        <section style="padding-top:50px">
            <div class="ApenasImpressao">
                <div style="text-align:center">
                    <strong>Frigorifico "O PEIX&Atilde;O"</strong><br>
                    <strong>Lista de Produtos Cadastrados</strong><br>
                    <strong>
                        <?php date_default_timezone_set('America/Belem');
                        echo date('d') . " de " . date('M') . " de " . date('Y'); ?>
                    </strong><br>
                </div>
            </div>
            <?php if ($_SESSION['usuarioNivel'] <= 2) { ?>
                <div class="container-fluid nImprime">
                    <form class="form-inline" role="form">
                        <div class="form-group">
                            <button ng-click="cadastrar = !cadastrar" class="btn btn-primary btn-block">
                                <div ng-hide="cadastrar">Cadastrar Produto</div>
                                <div ng-show="cadastrar">Ocultar</div>
                            </button>
                        </div>
                        <?php include_once './Op_Download.php'; ?>
                    </form>
                </div>
                <div ng-show="cadastrar" class="nImprime">
                    <div class="container-fluid text-center">
                        <h2>Cadastro de Produtos</h2>
                        <form class="form-signin2" id="CadastraProduto" method="post" >
                            <div class="form-group">
                                <label for="nome">Produto</label>
                                <input type="text" id="nome" class="form-control" name="Nome" placeholder="Nome" ng-required="true">
                            </div>
                            <div class="form-group">
                                <input type="submit" value="Inserir" class="btn btn-success form-control">
                            </div>
                        </form>
                    </div>
                </div>
                <?php } ?>
            <div class="table-responsive form-table">
                <table class="table table-striped" id="tabela">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Produto</th>
                            <?php if ($_SESSION['usuarioNivel'] <= 2) {echo "<td id='nImprime'>Editar</td>";} ?>
                        </tr>
                        <tr>
                            <th></th>
                            <th><input type="text" class="form-control" autofocus id="txtColuna2" placeholder="Busca..."/></th>
                        </tr>
                    </thead>
                    <tbody id="Lista_Produtos">
                    </tbody>
                </table>
            </div>
        </section>
        <br>
        <?php include_once './footer.php'; ?>
        <a href="#top" id="top-link">Ir para o Topo</a>
    </body>
    <link rel="stylesheet" href="Isset/css/bootstrap.css">
    <link rel="stylesheet" href="Isset/css/styles.css">
    <link rel="stylesheet" type="text/css" href="Isset/FontAwesome/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" media="print" href="Isset/css/print.css" />
    <style type="text/css">
        .ApenasImpressao{display: none;}
        @media print{.ApenasImpressao{display: block;}}
    </style>
</html>