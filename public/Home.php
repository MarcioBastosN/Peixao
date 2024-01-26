<!DOCTYPE html>
<html ng-app>
    <?php include_once './seguranca.php';
        protegePagina();
    ?>
    <head>
        <?php include_once './head.php'; ?>
    </head>
    <body data-spy="scroll" data-target=".navbar" data-offset="50">
        <header>
            <?php include_once './header.php'; ?>
        </header>
        <section style="padding-top:50px">
            <div class="container-fluid text-center">
                <div class="row">
                    <div id="section1" class="col-sm-4">
                        <h3>Clientes</h3>
                        <a href="Clientes.php">
                            <img src="Isset/images/pessoas.png" class="img img-responsive" style="width:100%" alt="Image">
                        </a><br>
                        <span>Adicionar / Editar </span>
                    </div>
                    <div id="section2" class="col-sm-4">
                        <h3>Produtos</h3>
                        <a href="Produtos.php">
                            <img src="Isset/images/produto.png" class="img img-responsive" style="width:100%" alt="Image"><br>
                        </a>
                        <span>Cadastrar / Editar</span>
                    </div>
                    <div id="section5" class="col-sm-4">
                        <h3>Lan&ccedil;amento</h3>
                        <a href="Lancamento.php">
                            <img src="Isset/images/lancamento.png" class="img img-responsive" style="width:100%" alt="Image"><br>
                        </a>
                        <span>Lan&ccedil;amentos diversos </span>
                    </div>			    
                    <div id="section3" class="col-sm-4">
                        <h3>Notas</h3>
                        <a href="pdf2.php">
                            <img src="Isset/images/nota.png" class="img img-responsive" style="width:100%" alt="Image"><br>
                        </a>
                        <span>Consultar e Gerar Notas !</span>
                    </div>
                    <div id="section4" class="col-sm-4">
                        <h3>Confer&ecirc;ncia</h3>
                        <a href="Conferencia.php">
                            <img src="Isset/images/consulta.png" class="img img-responsive" style="width:100%" alt="Image"><br>
                        </a>
                        <span>Confer&ecirc;ncia Clientes</span>
                    </div>
                    <div id="section7" class="col-sm-4">
                        <h3>Estoque</h3>
                        <a href="TotalEstoque.php">
                            <img src="Isset/images/estoque.png" class="img img-responsive" style="width:100%" alt="Image"><br>
                        </a>
                        <span>Confer&ecirc;ncia Estoque</span>
                    </div>
                </div>
            </div>
        </section>
        <div class="footer">
            <?php include_once './footer.php'; ?>
        </div>
    </body>
    <style type="text/css">
        .footer{position: relative;bottom: 0px;}
    </style>
    <link rel="stylesheet" type="text/css" href="Isset/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="Isset/css/styles.css">
    <link rel="stylesheet" type="text/css" href="Isset/FontAwesome/css/font-awesome.min.css">
</html>
