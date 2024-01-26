<?php
#captura o host via php para trabalhar nos arquivo js;
	@$url = $_SERVER['HTTP_HOST'];
	echo '<script>var ip = "'. $url .'";</script>';
?>
<script type="text/javascript">

    $(document).ready(function() {

      function URL(){
        var Temp;
        Temp = getUrlVars();
        var codigo;
        codigo = Temp["cod"];
        // document.getElementById("Set_Cod").value = Temp["Codigo"];
        return codigo;
      }
      EditarUsuario_N_Admin(URL());
    });

function RetornaMenuUsuario(){
  window.location.assign("http://"+ip+"/peixao/Usuarios.php");
}

function EditarUsuario_N_Admin(id){
  var UrlTemp = 'http://'+ip+'/Peixao/PHP_CRUD/RETRIAVE/DadosUsuarioEdicao.php?Usuario='+id;
  $.getJSON(UrlTemp, function(lista) {
    $('#E_Modal_User').empty();
    for (index=0; index < lista.length; index++) {
      var TempUser = lista[index];
      $('#E_Modal_User').append('<div class="form-group"><label>ID</label>'+
          '<select class="form-control" name="E_Id_User" required>'+
            '<option value="'+TempUser.id+'" selected>Seu ID e unico - Não pode ser Editado</option>'+
          '</select>'+
        '</div>'+
        '<div class="form-group"><label>Nome</label>'+
        '<div class="input-group"><span class="input-group-addon"><i class="fa fa-user fa-fw"></i></span>'+
          '<input type="text" value="'+TempUser.nome+'" class="form-control" autofocus name="E_Nome_User" pattern="[a-zA-Z/\\S/\\D]{3,}" title="Apenas aceito Letras comprimento minimo de 3" required/>'+
        '</div></div>'+
        '<div class="form-group"><label>Usu&aacute;rio</label>'+
          '<div class="input-group"><span class="input-group-addon"><i class="fa fa-user fa-fw"></i></span>'+
          '<input type="text" value="'+TempUser.usuario+'" class="form-control" autofocus name="E_Usuario_User" pattern="[a-zA-Z/\\S/\\D]{3,}" title="Apenas aceito Letras comprimento minimo de 3" required/>'+
        '</div></div>'+
        '<div class="form-group"><label>Senha</label>'+
          '<div class="input-group"><span class="input-group-addon"><i class="fa fa-key fa-fw"></i></span>'+
          '<input type="password" class="form-control" name="E_senha_User" maxlength="12" title="Comprimento minimo 4, valores aceitos: a-z-A-Z-0-9 e !@#$%¨&*()" /></div></div>'+
        '<div class="form-group"><input type="submit" class="btn btn-success btn-block" value="Salvar"/></div>');
    }
  });
}

// regitra dados do usuario no banco
$(document).ready(function() {
  jQuery('#EditaUsuario').submit(function(){
    // alert("envio chegando");
    var dados = jQuery( this ).serialize();
      jQuery.ajax({
        type: "POST",
        url: "http://"+ip+"/Peixao/PHP_CRUD/UPADTE/AtualizaUsuario.php",
        data: dados,
        success: function( txt )
        {
          if (txt == 'ok') {
            alert( 'Cadastro efetuado com Sucesso');
            window.location.assign("http://"+ip+"/peixao/Usuarios.php");            
          }else{
            alert("Erro inesperado");
          }
        }
      });
    return false;
  });
});

</script>