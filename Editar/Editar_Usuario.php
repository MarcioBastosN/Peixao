<!DOCTYPE html>
<html ng-app>
<?php 
  include("../seguranca.php"); 
  // protegePagina();

  if(@$_SESSION['usuarioNivel'] == 3 ){
    echo "<script>alert('Não autorizado'); window.location.assign('http://localhost/peixao/Home.php');</script>";
  }

?>
  <head>
    <title>Peixao</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="../public/js/jquery/jquery.js"></script>
    <script src="../public/js/bootstrap.js"></script>
    <script src="../public/js/angular/angular.js"></script>

    <script type="text/javascript" src="../public/js/script.js"></script>
    <script src="../public/js/interface.js"></script>
    <script type="text/javascript" src="../public/js/Funcoes.js"></script>
    <?php include("Ret_Dados_User.php"); ?>
  </head>

<body>
  <!-- retorna o form com os dados do usuario -->
  <section>
    <!-- <div id="E_Modal_User"></div> -->
    <form method="post" class="form-signin" id="EditaUsuario" >
      <div id="E_Modal_User"></div>
    </form>
    <div class="form-signin">
      <strong>*Para continuar com a mesma senha NÃO preencha o campo senha</strong>
      <button onclick="RetornaMenuUsuario()" class="btn btn-block btn-danger">Voltar</button></div>
  </section>
</body>

<link rel="stylesheet" href="../public/css/bootstrap.css" />
<link rel="stylesheet" href="../public/css/styles.css" />
<link rel="stylesheet" type="text/css" href="../public/FontAwesome/css/font-awesome.min.css">
<style type="text/css">
  .form-signin{margin:0 auto;max-width:330px;padding:15px;background-color:#D8D8D8;border-radius:9px;}
</style>
</html>
