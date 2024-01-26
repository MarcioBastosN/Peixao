<!DOCTYPE html>
<html>
    <?php
    include_once './seguranca.php';
    protegePagina();
    if ($_SESSION['usuarioNivel'] == 3) {
        echo "<script>alert('Não autorizado'); window.location.assign('http://localhost/peixao/Home.php');</script>";
    }
    ?>
    <head>
        <?php include_once './head.php'; ?>
        <script type='text/javascript' src='Isset/js/notification.js'></script>
        <script type="text/javascript">
            $(document).ready(function () {
                <?php
                    if ($_SESSION['usuarioNivel'] == 1) {
                        echo "CarregaUsuarioNivel1(" . $_SESSION['usuarioID'] . "),";
                    } else if ($_SESSION['usuarioNivel'] == 2) {
                        echo "CarregaUsuarioNivel2(" . $_SESSION['usuarioID'] . "),";
                    }
                ?>
                ListaLoginUsuario();
            });
            setTimeout(function () {
                carregarFiltros("tabela");
            }, 900);
        </script>
    </head>
    <body data-spy="scroll" data-target=".navbar" data-offset="50">
        <header>
            <?php include_once './header.php'; ?>
        </header>
        <section style="padding-top:55px">
            <div class="container-fluid">
                <div style="background-color:rgba(128,128,128,0.6)">
                    <form action="" method="POST" class="form-inline text-center" id="RegistraUsuario">
                        <div class="form-group">
                            <label>*Usuario</label>
                            <input type="text" name="usuario" class="form-control" placeholder="Marcio" maxlength="60" required>
                        </div>
                        <div class="form-group">
                            <label>*Nome</label>
                            <input type="text" name="nome" class="form-control" placeholder="Marcio ... ... Bastos" maxlength="60" required>
                        </div>
                        <div class="form-group">
                            <label>*Senha</label>
                            <input type="password" name="senha" class="form-control" pattern="([\w\S]){4,12}" title="Comprimento minimo 4 e maximo 12, valores aceitos: 'a-z-A-Z-0-9 e !@#$%¨&*()'"required>
                        </div>
                        <div class="form-group">
                            <label>*Nivel de Acesso</label>
                            <select class="form-control" name="nivel" required>
                                <?php
                                if ($_SESSION['usuarioNivel'] == 1) { ?>
                                    <option value="1">Admin</option>
                                    <option value="2">Gerente</option>
                                    <option value="3" selected>Usuario</option>
                                    <?php } else if ($_SESSION['usuarioNivel'] == 2) { ?>
                                    <option value="2">Gerente</option>
                                    <option value="3" selected>Usuario</option>
                                    <?php } ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <input type="submit" value="Salvar" class="btn btn-success btn-block">
                        </div>	
                    </form>
                    <div id="informações">
                        <span>* Campo Obrigatorio</span>
                        <span>
                            <ul>
                                <li>Gerente: Pode realizar todas as operações </li>
                                <li>Usuario: Apenas visaualizar e gerar notas</li>
                            </ul>
                        </span>
                    </div>
                </div>
                <div id="CarregaUsuarios">
                    <div class="table-responsive">
                        <table class="table" id="tabela">
                            <thead>
                                <tr>
                                    <th>Nome</th>
                                    <th>Usuario</th>
                                    <th class="comFiltro">Nivel</th>
                                    <?php if ($_SESSION['usuarioNivel'] == 1) { echo "<th>Editar</th>"; } ?>
                                    <th>Apagar</th>
                                </tr>
                            </thead>	
                            <?php 
                                if ($_SESSION['usuarioNivel'] == 1) { echo '<tbody id="UsuarioN1"></tbody>';
                                } else if ($_SESSION['usuarioNivel'] == 2) {echo '<tbody id="UsuarioN2"></tbody>';}
                            ?>
                        </table>
                    </div>
                </div>
                <!-- fim div carrega usuario -->
                <?php if ($_SESSION['usuarioNivel'] == 1) { ?>
                    <div class="table-responsive">
                        <table class="table" id="tabela2">
                            <thead>
                                <tr>
                                    <th class="">Usuario</th>
                                    <th>Hora Acesso</th>
                                    <th>Ip Acesso</th>
                                </tr>
                            </thead>
                            <tbody id="LoginUsuario"></tbody>
                        </table>
                    </div>
                    <?php } ?>
            </div>
        </section>
    </body>
    <style type="text/css">
        input:required:valid {background-color: rgba(0,150,0,0.6);color:black;}
        input:required:invalid {background-color: rgba(150,0,0,0.6);color:black;}
    </style>
    <link rel="stylesheet" href="Isset/css/bootstrap.css">
    <link rel="stylesheet" href="Isset/css/styles.css">
    <link rel="stylesheet" type="text/css" href="Isset/FontAwesome/css/font-awesome.min.css">
</html>