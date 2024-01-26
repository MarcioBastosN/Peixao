<!DOCTYPE html>
<html ng-app>
    <head>
        <title>Peixao</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script type="text/javascript" src="../Isset/js/jquery/jquery.js"></script>
        <script src="../Isset/js/bootstrap.js"></script>
        <script src="../Isset/js/angular/angular.js"></script>
        <script type="text/javascript" src="../Isset/js/script.js"></script>
        <script src="../Isset/js/interface.js"></script>
        <?php include_once './Ret_DadosProduto.php'; ?>

        <script type="text/javascript">
            $(document).ready(function () {
                $('[data-toggle="popover"]').popover();
            });
        </script>
    </head>

    <body onload="CarregaDadosProduto()">
        <section>
            <form id="atualizarProduto" class="form-signin" role="form">
                <div class="form-group text-center">
                    <span><h2>Editar Produto</h2></span>
                    <span>
                        <a href="#" data-toggle="popover" data-trigger="focus" title="Info"
                           data-content="Ao alterar o nome do produto você não altera a referencia do mesmo. Por isso dois ou mais produtos com mesmo nome são representados de forma diferente no estoque ! ">Info</a>
                    </span>
                </div>
                <div class="form-group">
                    <label for="Set_Cod">Codigo:</label>
                    <select name="codigo" class="form-control" required>
                        <option value="" id="Set_Cod">ProdutoID</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="nome">Produto:</label>
                    <input type="text" id="nome" value='' name="produto" class="form-control" required>
                </div>
                <div class="form-group">
                    <input type="submit" value="Confirmar Altera&ccedil;&atilde;o" class="btn btn-success btn-block">
                </div>
            </form>
            <div class="form-group form-signin">
                <input type="button" value="Cancelar / Limpar" class="btn btn-danger btn-block" onclick="retorna()">
            </div>
        </section>
    </body>

    <link rel="stylesheet" href="../Isset/css/bootstrap.css" />
    <link rel="stylesheet" href="../Isset/css/styles.css" />
    <style type="text/css">
        .form-signin{margin:0 auto; max-width:330px; padding:15px; background-color:#D8D8D8; border-radius:9px; }
    </style>
</html>
