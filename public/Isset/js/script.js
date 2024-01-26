// apagar Lancamento
function myFunction(n) {
    var x;
    if (confirm("Deseja realmente apagar o Cod: " + n) == true) {
        if (ApagarDados(n)) {
            InformaDelete();
            CarregaLancamentoAdmin();
        } else {
            alert("Erro!!!");
        }
    } else {
        x = "Operação cancelada: \n Cod: " + n + ", não foi excluido";
        alert(x);
    }
}

// Cadastra Lançamento ATIVAR ESTA FUNÇÃO
$(document).ready(function () {
    jQuery('#CadastraLancamento_USER').submit(function () {
        var dados = jQuery(this).serialize();
        jQuery.ajax({
            type: "POST",
            url: "http://" + ip + "/Peixao/CRUD/CREATE/I_LancamentoUser.php",
            data: dados,
            success: function (txt)
            {
                if (txt === 'success') {
                    CarregalancamentoUser();
                    document.getElementById("NR").value = "";
                    document.getElementById("listProduto").value = "";
                    document.getElementById("PesoProduto").value = "";
                    document.getElementById("VolumeProduto").value = "";
                    document.getElementById("Boxsituacao").value = "";
                    document.getElementById("ObsProduto").value = "";
                    document.getElementById("SelectBoxProduto").value = "";
                } else {
                    alert(txt);
                }
            }
        });
        return false;
    });
});

$(document).ready(function () {
    jQuery('#CadastraLancamento_Admin').submit(function () {
        var dados = jQuery(this).serialize();
        jQuery.ajax({
            type: "POST",
            url: "http://" + ip + "/Peixao/CRUD/CREATE/I_Lancamento.php",
            data: dados,
            success: function (txt)
            {
                if (txt === 'success') {
                    CarregaLancamentoAdmin();
                    document.getElementById("NR").value = "";
                    document.getElementById("listProduto").value = "";
                    document.getElementById("PesoProduto").value = "";
                    document.getElementById("VolumeProduto").value = "";
                    document.getElementById("Boxsituacao").value = "";
                    document.getElementById("ObsProduto").value = "";
                    executa();
                } else {
                    alert(txt);
                }
            }
        });
        return false;
    });
});

// retorna o valor total da sona independente da situção
    function TotalSomaProduto(dadosurl){
        $('#RespostaSoma').empty();
        var url = 'http://'+ip+'/Peixao/CRUD/RETRIAVE/R_Soma_Produto_Cliente.php'+dadosurl;
        $.getJSON(url, function(Lista) {
            for(var index = 0; index < Lista.length; index++){
                var dados = Lista[index];
                $('#RespostaSoma').append('<tr style="font-weight:bold">'+'<td>Total: </td>'+'<td>'+dados.Nome+'</td><td> Peso: '+dados.Peso+' Kg</td><td> Volume: '+dados.Volume+'</td></tr>');
            }
        });
    }
    // retorna a soma para situação === ACERTO
    function TotalSomaProdutoAcerto(dadosurl){
        $('#SomaAcerto').empty();
        var url = 'http://'+ip+'/Peixao/CRUD/RETRIAVE/R_Soma_AcertoProduto_Cliente.php'+dadosurl;
        $.getJSON(url, function(Lista) {
            for(var index = 0; index < Lista.length; index++){
                var dados = Lista[index];
                $('#SomaAcerto').append('<tr class="success">'+'<td>Acerto: </td>'+'<td>'+dados.Nome+'</td><td> Peso: '+dados.Peso+' Kg</td><td> Volume: '+dados.Volume+'</td></tr>');
            }
        });
    }
    // retorna a soma para situação === EMBALAGEM
    function TotalSomaProdutoEmbalagem(dadosurl){
        $('#SomaEmbalagem').empty();
        var url = 'http://'+ip+'/Peixao/CRUD/RETRIAVE/R_Soma_EmbalagemProduto_Cliente.php'+dadosurl;
        $.getJSON(url, function(Lista) {
            for(var index = 0; index < Lista.length; index++){
                var dados = Lista[index];
                $('#SomaEmbalagem').append('<tr class="info">'+'<td>Embalagem: </td>'+'<td>'+dados.Nome+'</td><td> Peso: '+dados.Peso+' Kg</td><td> Volume: '+dados.Volume+'</td></tr>');
            }
        });
    }
    // retorna a soma para situação === EXPEDIÇÂO
    function TotalSomaProdutoExpedicao(dadosurl){
        $('#SomaExpedicao').empty();
        var url = 'http://'+ip+'/Peixao/CRUD/RETRIAVE/R_Soma_ExpedicaoProduto_Cliente.php'+dadosurl;
        $.getJSON(url, function(Lista) {
            for(var index = 0; index < Lista.length; index++){
                var dados = Lista[index];
                $('#SomaExpedicao').append('<tr class="warning">'+'<td>Expedicao: </td>'+'<td>'+dados.Nome+'</td><td> Peso: '+dados.Peso+' Kg</td><td> Volume: '+dados.Volume+'</td></tr>');
            }
        });
    }
    // Retorna Numero Notas
    function NumeroNotas(dadosurl){
        $('#NotasProdutos').empty();
        var url = 'http://'+ip+'/Peixao/CRUD/RETRIAVE/R_Notas_Cliente.php'+dadosurl;
        $.getJSON(url, function(Lista) {
            for(var index = 0; index < Lista.length; index++){
                var dados = Lista[index];
                $('#NotasProdutos').append('<div class="col-xs-6 col-sm-3 col-md-3"><tr>'+'<td>NR: </td>'+'<td>'+dados.Nota+'</td></tr></div>');
            }
        });
    }
                        
// Função quebra galho temporaria
function refresh() {
    window.location.href = window.location;
}

function EditarProduto(id) {
    window.location.assign("http://" + ip + "/Peixao/Editar/Editar_Produto.php?Codigo=" + id);
}

// carrega a pag de edição do usuario
function PagEditarUsuario(cod) {
    window.location.assign("http://" + ip + "/Peixao/Editar/Editar_Usuario.php?cod=" + cod);
}

function Cod_Url(id) {
    window.location.assign("http://" + ip + "/Peixao/Editar/Editar_Cliente.php?Codigo=" + id);
}

// Pesquisa em tabela
$(function () {
    $("#tabela input").keyup(function () {
        var index = $(this).parent().index();
        var nth = "#tabela td:nth-child(" + (index + 1).toString() + ")";
        var valor = $(this).val().toUpperCase();
        $("#tabela tbody tr").show();
        $(nth).each(function () {
            if ($(this).text().toUpperCase().indexOf(valor) < 0) {
                $(this).parent().hide();
            }
        });
    });

    $("#tabela input").blur(function () {
        $(this).val("");
    });
});
// -------------------------------------------------------------------------
function getUrlVars() {
    var vars = [], hash;
    var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');

    for (var i = 0; i < hashes.length; i++) {
        hash = hashes[i].split('=');
        hash[1] = unescape(hash[1]);
        vars.push(hash[0]);
        vars[hash[0]] = hash[1];
    }
    return vars;
}

// -------------------------------------------------------------------------
jQuery.fn.topLink = function (settings) {
    settings = jQuery.extend({
        min: 1,
        fadeSpeed: 200
    }, settings);
    return this.each(function () {
        //listen for scroll
        var el = $(this);
        el.hide(); //in case the user forgot
        $(window).scroll(function () {
            if ($(window).scrollTop() >= settings.min) {
                el.fadeIn(settings.fadeSpeed);
            } else {
                el.fadeOut(settings.fadeSpeed);
            }
        });
    });
};

function atualizarCliente(n) {
    alert("Cod_cliente: " + n);
}

// alerta apagar usuario
function FunctionApagarUsuario(n) {
    var x;
    if (confirm("Deseja realmente apagar o Cod: " + n) == true) {
        if (ApagarUsuario(n)) {
//            alert("Usuario apagado!");
            InformaDeletUser();
            CarregaUsuarioNivel1(nivel);
            CarregaUsuarioNivel2(nivel);
        } else {
            alert("Erro!!!");
        }
    } else {
        x = "Operação cancelada: \n Cod: " + n + ", não foi excluido";
        alert(x);
    }
}

// oculta a tabela e exibe os dados anteriores do form principal -> da onde ?
function CancelarEdicaoLancamento() {
    $("#temptest").hide();
    $("#Editar_Oculta").animate({height: 'show'});
    $("#CadastraLancamento_Admin").animate({height: 'show'});
}