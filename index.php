<!DOCTYPE html>
<html>
    <head>
        <title>Peix&atilde;o</title>
        <link rel="icon" type="image/png" href="Isset/images/07.ico" />
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script src="Isset/js/jquery/jquery.js"></script>
        <script src="Isset/js/bootstrap.js"></script>
        <script type="text/javascript" src="Isset/js/jquery-3.1.1.slim.min.js"></script>
        <script type="text/javascript" src="Isset/js/typewrite.js"></script>
        <style type="text/css">
            input:required:valid {background-color: rgba(0,150,0,0.6);color:black;}
            .footer2{position: fixed;bottom: 0px;width: 100%;background-color: rgba(128,128,128,0.6);}
            #typewriteText{color: black;font-size: 50px; font-family: 'Open Sans', Arial, Helvetica, sans-serif; width: 45%; margin:0 auto; }
            @media screen and (max-width: 480px){#typewriteText{color: black;font-size: 28px; font-family: 'Open Sans', Arial, Helvetica, sans-serif; width: 100%; margin:0 auto; }}
        </style>
        <script>
            $(document).ready(function () {
                $('#typewriteText').typewrite({
                    actions: [{delay: 1000}, {type: 'Bem Vindo ao Peixao.'}, {delay: 1500}, {select: {from: 0, to: 20}}, {delay: 200},
                        {remove: {num: 20, type: 'whole'}}, {delay: 100}, {type: 'Login Peixao'}, {delay: 500}, {select: {from: 6, to: 12}},
                        {delay: 500}, {remove: {num: 7, type: 'whole'}}, {type: '.'}]
                });
            });
        </script>
    </head>
    <body>
        <section>
            <div class="container fadeInDown animated">
                <div class="text-center" id="typewriteText"></div>
                <form method="post" action="valida.php" class="form-signin" id="form1">
                    <div class="form-group">
                        <p class="text-center">
                            <img src="Isset/images/login.png" class="img-circle">
                        </p>
                    </div>
                    <div class="form-group">
                        <label>Usu&aacute;rio</label>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-user fa-fw"></i></span>
                            <input type="text" class="form-control" autofocus name="usuario" pattern="[a-zA-Z/\\S/\\D]{3,}" title="Apenas aceito Letras comprimento minimo de 3" required/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Senha</label>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-key fa-fw"></i></span>
                            <input type="password" class="form-control" name="senha" pattern="([\w\S]){4,12}" title="Comprimento minimo 4, valores aceitos: 'a-z-A-Z-0-9 e !@#$%¨&*()'" required/>
                        </div>
                    </div>
                    <br>
                    <div class="form-group">
                        <input type="submit" class="btn btn-success btn-block" value="Entrar"/>
                    </div>
                </form>
            </div>
        </section>
        <footer class="container-fluid text-center footer2 fadeInUp animated">
            <a href="#" data-toggle="modal" data-target="#myModal" style="color:black; font-size:14px;">
                <span>Power by: Nomade solutions</span>
            </a>
        </footer>
        <div class="modal fade" id="myModal" role="dialog">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Desenvolvimento</h4>
                    </div>
                    <div class="modal-body">
                        <p>MarcioBastos</p>
                        <p>Email: marciobastosn@gmail.com</p>
                        <p>Contato: (93) 99175-3545</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </body>
    <link rel="stylesheet" href="Isset/css/bootstrap.css">
    <link rel="stylesheet" href="Isset/css/styles.css">
    <link rel="stylesheet" href="Isset/css/animate.css">
    <link rel="stylesheet" type="text/css" href="Isset/FontAwesome/css/font-awesome.min.css">
    <style type="text/css">
        .input-group-addon {background-color: rgba(0,150,0,0.6);}
    </style>
</html>
