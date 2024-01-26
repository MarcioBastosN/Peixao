<?php
#captura o host via php para trabalhar nos arquivo js;
    @$url = $_SERVER['HTTP_HOST'];
    echo '<script>var ip = "'. $url .'";</script>';
?>
<script type="text/javascript">

    $(document).ready(function() {

      function p(){
        Temp = getUrlVars();
        document.getElementById("Set_Cod").value = Temp["Codigo"];
        return this;
      }

      $('#atualiza').submit(function(){
        var dados = $( this ).serialize();
          $.ajax({
            type: 'POST',
            url: "http://"+ip+"/Peixao/CRUD/UPDATE/A_Cliente.php",
            data: dados,
            success: function(data) 
            {
                if(data == "ok"){
                  alert("success");
                  window.location.assign("http://"+ip+"/Peixao/Clientes.php");
                }
              }
          });
          return false;
        });

      p();

    });

    function retorna(){
      window.location.assign("http://"+ip+"/Peixao/Clientes.php");
    }

    function CarregaValor(){
      var Nome = document.getElementById("Set_Cod").value;
            $.ajax({
            type: 'POST',
            url: "http://"+ip+"/Peixao/Editar/RetornaDados.php",
            data: {Nome:Nome},
            success: function(data) 
            {
              if(data != "Erro"){
                document.getElementById("nome").value = data;
              }
            }
          });
      return false;
    }

</script>