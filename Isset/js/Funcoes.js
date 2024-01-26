// ip esta sendo passado do forma gloval via arquivo head.php;

function carrega() {
    var temp = document.getElementById("tabela_col_2").value;
    jQuery.ajax({
        type: "POST",
        url: "http://" + ip + "/Peixao/CRUD/RETRIAVE/R_TotalPorNota.php",
        data: {ConsultaNota: temp},
        success: function (txt)
        {
            $('#Resultado_Total_Nota').empty();
            $('#Resultado_Total_Nota').append(txt);
        }
    });
}
        
$(document).ready(function () {
    jQuery('#CadastraCliente').submit(function () {
        var dados = jQuery(this).serialize();
        jQuery.ajax({
            type: "POST",
            url: "http://" + ip + "/Peixao/CRUD/CREATE/I_Cliente.php",
            data: dados,
            success: function (txt)
            {
                if (txt === 'success') {
                    alert("Cliente registrado");
                    //ClienteCadastrado();
                    Atualizar_ClientesAdmin();
                } else {
                    alert(txt);
                }
            }
        });
        return false;
    });
});

// Passa os dados do produto para ser registrado no Banco de Dados
$(document).ready(function () {
    jQuery('#CadastraProduto').submit(function () {
        var dados = jQuery(this).serialize();
        jQuery.ajax({
            type: "POST",
            url: "http://" + ip + "/Peixao/CRUD/CREATE/I_Produto.php",
            data: dados,
            success: function (txt)
            {
                if (txt == 'success') {
                    alert('Cadastro efetuado com Sucesso');
                    Atualizar_Produtos_Admin();
                } else {
                    alert("erro inesperado");
                }
            }
        });
        return false;
    });
});

// apagar Lancamento
function ApagarDados(n) {
    var codigo;
//    var resultado = true;
var resultado;
    codigo = n;
    jQuery.ajax({
        type: "POST",
        url: "http://" + ip + "/Peixao/CRUD/DELET/D_Lancamento.php",
        data: 'id=' + codigo,
        success: function (txt)
        {
            console.log(txt);
            if (txt == 'success') {
                return true;
                resultado = true;
            }else{
                return false;
                resultado = false;
            }
        }
    });
    return this;
}

// adiciona usuario
$(document).ready(function () {
    jQuery('#RegistraUsuario').submit(function () {
        var dados = jQuery(this).serialize();
        jQuery.ajax({
            type: "POST",
            url: "http://" + ip + "/Peixao/CRUD/CREATE/I_Usuario.php",
            data: dados,
            success: function (txt)
            {
                if (txt == 'success') {
                    InformaCadastro();
                    CarregaUsuarioNivel1(nivel);
                    CarregaUsuarioNivel2(nivel);
                } else {
                    alert(txt);
                }
            }
        });
        return false;
    });
});

// apagar usuario
function ApagarUsuario(n) {
    var codigo;
    var resultado = true;
    codigo = n;
    jQuery.ajax({
        type: "POST",
        url: "http://" + ip + "/Peixao/CRUD/DELET/D_Usuario.php",
        data: 'IdUsuario=' + codigo,
        success: function (txt)
        {
            if (txt == 'success') {
                resultado = true;
                return true;
            } else {
                resultado = false;
                return false;
            }
        }
    });
    return resultado;
}

// ================= TOTAL Por Numero da Nota =================
$(document).ready(function () {
    jQuery('#Total_por_Nota').submit(function () {
        // garante a inicialização correta da nota, sem duplicatas;
        var dados = jQuery(this).serialize();
        jQuery.ajax({
            type: "POST",
            url: "http://" + ip + "/Peixao/CRUD/RETRIAVE/TotalPorNota.php",
            data: dados,
            success: function (txt)
            {
                $('#Resultado_Total_Nota').empty();
                $('#Resultado_Total_Nota').append(txt);
            }
        });
        return false;
    });
});

// chama função imprimir
function Imprimir() {
    $('#Imprimir').empty();
    $('#Imprimir').append('<a href="#" onclick="window.print();">Imprimir</a>');
}

// mostra menssagem de erro
function Imprimeerro() {
    $('#ErroEstoque').empty();
    $('#ErroEstoque').append('<span class="text-danger">Erro: Ha valores (-) Negativos,'
            + ' interferindo no calculo do Total, ' + 'Por favor corrija !');
}

function ImprimeData() {
    $('#Data').empty();
    $.getJSON('http://' + ip + '/Peixao/CRUD/RETRIAVE/Data.php', function (lista) {
        for (index = 0; index < lista.length; index++) {
            var data = lista[index];
            $('#Data').append("<span><h4>Total Estocado até:" + data.Data + "</h4></span>");
        }
    });
}

$(document).ready(function () {
    jQuery('#Atualiza_Produto_Lancamento').submit(function () {
        var dados = jQuery(this).serialize();
        jQuery.ajax({
            type: "POST",
            url: "http://" + ip + "/Peixao/CRUD/UPDATE/A_lancamentoUser.php",
            data: dados,
            success: function (txt)
            {   
                if(txt === 'success'){
                    CancelarEdicaoLancamento();
                    CarregaLancamentoAdmin();
                    executaApdate();
                }else{
                    alert(txt);
                }
            }
        });
        return false;
    });
});