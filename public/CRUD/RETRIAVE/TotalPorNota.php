<?php 
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include_once '../../conn/conexao.php';
    $conexao = new conexao();
    $conn = $conexao->getConexao();
    @$_Nota = filter_input(INPUT_POST, "ConsultaNota");
    if(@$_Nota != ""){
        $sql = "SELECT SUM(`Volume`) AS `Volume`, SUM(`Peso`) AS `Peso` FROM `estoque` WHERE `NR` = '$_Nota';";
        $query = mysqli_query($conn, $sql);
        $conexao->fecharConexao();
        while($resultado = mysqli_fetch_assoc($query)){
                $resultado['Volume'] = number_format(@$resultado['Volume'],0,",",".");
                $resultado['Peso'] = number_format(@$resultado['Peso'],0,",",".");
                echo "<strong>Nota: ".@$_Nota." Peso: ".$resultado['Peso']."Kg Volume: ".$resultado['Volume']."un</strong>";
        }
    }
}
