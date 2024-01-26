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
        return;
      }

      $('#atualizarProduto').submit(function(){
        var dados = $( this ).serialize();
          $.ajax({
            type: 'POST',
            url: "http://"+ip+"/Peixao/CRUD/UPDATE/A_Produto.php",
            data: dados,
            success: function(data)
            {
                if(data == "ok"){
                  alert("Nome Produto Alterado com Sucesso");
                  window.location.assign("http://"+ip+"/Peixao/Produtos.php");
                }
              }
          });
          return false;
        });

      p();

    });

    function retorna(){
      window.location.assign("http://"+ip+"/Peixao/Produtos.php");
    }

    function CarregaDadosProduto(){
      var idproduto = document.getElementById("Set_Cod").value;
            $.ajax({
            type: 'POST',
            url: "http://"+ip+"/Peixao/Editar/RetornaDadosProduto.php",
            data: {produtoid:idproduto},
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
