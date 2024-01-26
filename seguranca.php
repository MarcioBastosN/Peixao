<?php

include_once "conn.php";
include_once './conn/conexao.php';
// ==============================
$_SG['tabela'] = 'usuarios';       // Nome da tabela onde os usuários são salvos

// Verifica se precisa fazer a conexão com o MySQL
if ($_SG['conectaServidor'] == true) {
    $conn = new conexao();
    $conexao = $conn->getConexao();
    $_SG['link'] = $conexao;
}

// Verifica se precisa iniciar a sessão
if ($_SG['abreSessao'] == true)
  session_start();

function validaUsuario($usuario, $senha) {
  global $_SG;

  $cS = ($_SG['caseSensitive']) ? 'BINARY' : '';

  // Usa a função addslashes para escapar as aspas
  $nusuario = addslashes($usuario);
  $nsenha = addslashes($senha);

  // Monta uma consulta SQL (query) para procurar um usuário
  $sql = "SELECT `id`, `nome`, `nivel` FROM `".$_SG['tabela']."` WHERE ".$cS." `usuario` = '".$nusuario."' AND ".$cS." `senha` = '".$nsenha."' LIMIT 1";
  $query = mysqli_query($_SG['link'],$sql);
  $resultado = mysqli_fetch_assoc($query);

  // Verifica se encontrou algum registro
  if (empty($resultado)) {
    // Nenhum registro foi encontrado => o usuário é inválido
    return false;
  } else {
    // Definimos dois valores na sessão com os dados do usuário
    $_SESSION['usuarioID'] = $resultado['id']; // Pega o valor da coluna 'id do registro encontrado no MySQL
    $_SESSION['usuarioNome'] = $resultado['nome']; // Pega o valor da coluna 'nome' do registro encontrado no MySQL
    $_SESSION['usuarioNivel'] = $resultado['nivel'];

    // Verifica a opção se sempre validar o login
    if ($_SG['validaSempre'] == true) {
      // Definimos dois valores na sessão com os dados do login
      $_SESSION['usuarioLogin'] = $usuario;
      $_SESSION['usuarioSenha'] = $senha;
    }

    return true;
  }
}

  function get_client_ip() {
       $ipaddress = '';
       if (getenv('HTTP_CLIENT_IP'))
           $ipaddress = getenv('HTTP_CLIENT_IP');
       else if(getenv('HTTP_X_FORWARDED_FOR'))
           $ipaddress = getenv('HTTP_X_FORWARDED_FOR'&quot);
       else if(getenv('HTTP_X_FORWARDED'))
           $ipaddress = getenv('HTTP_X_FORWARDED');
       else if(getenv('HTTP_FORWARDED_FOR'))
           $ipaddress = getenv('HTTP_FORWARDED_FOR');
       else if(getenv('HTTP_FORWARDED'))
          $ipaddress = getenv('HTTP_FORWARDED');
       else if(getenv('REMOTE_ADDR'))
           $ipaddress = getenv('REMOTE_ADDR');
       else
           $ipaddress = 'UNKNOWN';

       return $ipaddress; 
  }

// Registra Acesso 
  function RegistraAcesso($user){
    global $_SG;
    @$conn = mysqli_connect($_SG['servidor'], $_SG['usuario'], $_SG['senha'],$_SG['banco']) or die("MySQL: Não foi possível conectar-se ao servidor");
    date_default_timezone_set('America/Belem');
    @$tempo = date("Y-m-d H:i:s");
    @$acesso = get_client_ip();
    @$sql = "INSERT INTO `registraacessos` (`User`,`Data_Tempo`, `Acesso`) VALUES ('$user', '$tempo', '$acesso')";
    @$query = mysqli_query($conn, $sql);
  }
  
/**
* Função que protege uma página
*/
function protegePagina() {
  global $_SG;

  if (!isset($_SESSION['usuarioID']) OR !isset($_SESSION['usuarioNome']) OR !isset($_SESSION['usuarioNivel'])) {
    // Não há usuário logado, manda pra página de login
    expulsaVisitante();
  } else if (!isset($_SESSION['usuarioID']) OR !isset($_SESSION['usuarioNome']) OR !isset($_SESSION['usuarioNivel'])) {
    // Há usuário logado, verifica se precisa validar o login novamente
    if ($_SG['validaSempre'] == true) {
      // Verifica se os dados salvos na sessão batem com os dados do banco de dados
      if (!validaUsuario($_SESSION['usuarioLogin'], $_SESSION['usuarioSenha'])) {
        // Os dados não batem, manda pra tela de login
        expulsaVisitante();
      }
    }
  }
}

/**
* Função para expulsar um visitante
*/
function expulsaVisitante() {
  global $_SG;

  // Remove as variáveis da sessão (caso elas existam)
  unset($_SESSION['usuarioID'], $_SESSION['usuarioNome'], $_SESSION['usuarioLogin'], $_SESSION['usuarioSenha'], $_SESSION['usuarioNivel']);

  // Manda pra tela de login
  header("Location: ".$_SG['paginaLogin']);
}