<!DOCTYPE html>
<html ng-app>
    <?php include_once './seguranca.php';
    protegePagina();
    ?>
    <head>
        <?php include_once './head.php'; ?>
        <script type="text/javascript" src='Isset/js/notification.js'></script>
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
            <?php if ($_SESSION['usuarioNivel'] != 3) {echo "Atualizar_ClientesAdmin();";} else {echo "Atualizar_ClientesUser();";} ?>
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
                    <strong>Lista de Clientes Cadastrados</strong><br>
                    <strong>
                        <?php date_default_timezone_set('America/Belem');
                        echo date('d') . " de " . date('M') . " de " . date('Y');
                        ?>
                    </strong><br>
                </div>
            </div>
            <?php if ($_SESSION['usuarioNivel'] <= 2) { ?>
                <div class="container-fluid nImprime">
                    <form id="Empresa" class="form-inline" role="form">
                        <div class="form-group">
                            <button ng-click="cadastrar = !cadastrar" class="btn btn-primary form-control">
                                <div ng-hide="cadastrar">Cadastrar Cliente</div>
                                <div ng-show="cadastrar">Ocultar</div>
                            </button>
                        </div>
                        <?php include_once './Op_Download.php'; ?>
                    </form>
                </div>
                <div ng-show="cadastrar" class="nImprime">
                    <div class="container-fluid text-center">
                        <h2>Cadastro de Clientes</h2>
                        <form class="form-signin2" id="CadastraCliente" method="post" >
                            <div class="form-group">
                                <label>Nome:</label>
                                <input type="text" class="form-control" name="Nome" placeholder="Digite o Nome do seu Cliente" required>
                            </div>
                            <input type="submit" value="Inserir" class="btn btn-success form-control">
                        </form>
                    </div>
                </div>
            <?php } ?>
            <div class="table-responsive form-table">
                <table class="table table-striped" id="tabela">
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <?php if ($_SESSION['usuarioNivel'] != 3) {echo "<th id='nImprime'>Editar</th>";} ?>
                        </tr>
                        <tr>
                            <th><input type="text" class="form-control" autofocus id="txtColuna1" placeholder="Busca_Cliente"/></th>
                        </tr>
                    </thead>
                    <tbody id="Cliente">
                    </tbody>
                </table>
            </div><br>
        </section>
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