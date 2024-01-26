// ip esta sendo passado do forma gloval via arquivo head.php;

function ListaLoginUsuario() {
    $('#LoginUsuario').empty();
    $.getJSON('http://' + ip + '/Peixao/CRUD/RETRIAVE/R_DadosLog.php', function (lista) {
        for (index = 0; index < lista.length; index++) {
            var LogUsuario = lista[index];
            $('#LoginUsuario').append('<tr><td>' + LogUsuario.User + '</td><td>' + LogUsuario.Data_Tempo + '</td><td>' + LogUsuario.Acesso + '</td></tr>');
        }
    });
}

function CarregaUsuarioNivel1(nivel) {
    $('#UsuarioN1').empty();
    $.getJSON('http://' + ip + '/Peixao/CRUD/RETRIAVE/R_DadosUsuario.php', function (lista) {
        for (index = 0; index < lista.length; index++) {
            var Usuario = lista[index];
            var temp = "";
            if (Usuario.id == nivel) {
                temp = '<input type="button" class="btn btn-md btn-danger disabled" value="Apagar" >';
            } else {
                temp = '<input type="button" onclick="FunctionApagarUsuario(' + Usuario.id + ')" class="btn btn-md btn-danger " value="Apagar" >';
            }
            $('#UsuarioN1').append('<tr><td>' + Usuario.nome + '</td><td>' + Usuario.usuario + '</td><td>' + Usuario.nivel +
                '<td><input type="button" data-toggle="modal" data-target="#myModal" onclick="PagEditarUsuario(' + Usuario.id + ')" class="btn btn-md btn-info" value="Editar"></td>' + '</td><td>' + temp + '</td></tr>');
        }
    });
}

function CarregaUsuarioNivel2(nivel) {
    $('#UsuarioN2').empty();
    $.getJSON('http://' + ip + '/Peixao/CRUD/RETRIAVE/R_DadosUsuario.php', function (lista) {
        for (index = 0; index < lista.length; index++) {
            var Usuario2 = lista[index];
            var temp = "";
            if (Usuario2.id == nivel) {
                temp = '<input type="button" onclick="PagEditarUsuario(' + Usuario2.id + ')" class="btn btn-md btn-info" value="Editar">';
            } else {
                temp = '<input type="button" class="btn btn-md btn-danger disabled" value="Apagar">';
            }
            $('#UsuarioN2').append('<tr><td>' + Usuario2.nome + '</td><td>' + Usuario2.usuario + '</td><td>' + Usuario2.nivel + '</td>' + '<td>' + temp + '</td></tr>');
        }
    });
}

function Atualizar_ClientesAdmin() {
    $('#Cliente').empty();
    $.getJSON('http://' + ip + '/Peixao/CRUD/RETRIAVE/R_Cliente.php', function (lista) {
        for (index = 0; index < lista.length; index++) {
            var clientes = lista[index];
            $('#Cliente').append('<tr>' + '<td>' + clientes.Nome + '</td>'
                + '<td align="center"><button type="button" class="btn btn-primary btn-sm" ' + ' onclick="Cod_Url(' + clientes.ID + ')" >Editar</button></td>' + '</tr>');
        }
    });
}

function Atualizar_ClientesUser() {
    $('#Cliente').empty();
    $.getJSON('http://' + ip + '/Peixao/CRUD/RETRIAVE/R_Cliente.php', function (lista) {
        for (index = 0; index < lista.length; index++) {
            var clientes = lista[index];
            $('#Cliente').append('<tr><td>' + clientes.Nome + '</td></tr>');
        }
    });
}

function Atualizar_Produtos() {
    $('#Lista_Produtos').empty();
    $.getJSON('http://' + ip + '/Peixao/CRUD/RETRIAVE/R_Produtos.php', function (lista) {
        for (index = 0; index < lista.length; index++) {
            var produtos = lista[index];
            $('#Lista_Produtos').append('<tr><td>' + produtos.ID + '</td><td>' + produtos.Nome + '</td></tr>');
        }
    });
}

function Atualizar_Produtos_Admin() {
    $('#Lista_Produtos').empty();
    $.getJSON('http://' + ip + '/Peixao/CRUD/RETRIAVE/R_Produtos.php', function (lista) {
        for (index = 0; index < lista.length; index++) {
            var produtos = lista[index];
            $('#Lista_Produtos').append('<tr><td>' + produtos.ID + '</td><td>' + produtos.Nome + '</td>'
                + '<td><button class="btn btn-sn btn-primary" onclick="EditarProduto(' + produtos.ID + ')" >Editar</button></td>' + '</tr>');
        }
    });
}

// retorma soma total estocado
function SomaTotal() {
    $('#TotalSoma').empty();
    $.getJSON('http://' + ip + '/Peixao/CRUD/RETRIAVE/R_TotalEstoqueSoma.php', function (lista) {
        for (index = 0; index < lista.length; index++) {
            var Soma = lista[index];
            $('#TotalSoma').append('<tr style="font-size:18px;"><td>Total Estoque</td><td>' + Soma.Volume + '</td><td>' + Soma.Peso + '</td></tr>');
        }
    });
}

// tabela com registro do estoque
function TotalEstoque() {
    $('#totalestoque').empty();
    $.getJSON('http://' + ip + '/Peixao/CRUD/RETRIAVE/R_TotalEstoque.php', function (lista) {
        for (index = 0; index < lista.length; index++) {
            var estoque = lista[index];
            if (estoque.Total_Volume > 0 || estoque.Total_Peso > 0) {
                $('#totalestoque').append('<tr class="text-success"><td>' + estoque.Cliente + '</td><td>' + estoque.Total_Volume + '</td><td>' + estoque.Total_Peso + '</td></tr>');
            } else {
                Imprimeerro();
                $('#totalestoque').append('<tr class="text-danger"><td>' + estoque.Cliente + '</td><td>' + estoque.Total_Volume + '</td><td>' + estoque.Total_Peso + '</td></tr>');
            }
        }
    });
    ImprimeData();
    SomaTotal();
    Imprimir();
}

function DataLancamentoTemp_User(dados) {
    var url = 'http://' + ip + '/Peixao/CRUD/RETRIAVE/R_Lancamento_por_Data.php' + dados;
    $('#TabelaLancamento').empty();
    $.getJSON(url, function (lista) {
        for (index = 0; index < lista.length; index++) {
            var data = lista[index];
            var temp = "";
            if (data.Observacao != null && data.Observacao != "") {
                temp = "ObsAtiva";
            } else {
                temp = "ObsDesativa";
            }
            $('#TabelaLancamento').append('<tr class="' + data.Class + '"><td>' + data.ClienteID + '</td><td>' + data.Data_Estoque + '</td><td>' +
                    data.NR + '</td><td>' + data.ProdutoID + '</td><td>' + data.Peso + ' Kg </td><td>' + data.Volume + '</td><td>' + data.situacao +
                    '</td><td class="nImprime"><button type="button" class="btn btn-info btn-md ' + temp + '" data-toggle="modal" data-target="#myModal' + data.ID +
                    '">Obs</button></td>' + '</tr>');
        }
    });
    CarregaModalLancamento();
}

function DataLancamentoTemp_Admin(dados) {
    var url = 'http://' + ip + '/Peixao/CRUD/RETRIAVE/R_Lancamento_por_Data.php' + dados;
    // alert(url);
    $('#TabelaLancamento').empty();
    $.getJSON(url, function (lista) {
        for (index = 0; index < lista.length; index++) {
            var data = lista[index];
            var temp = "";
            if (data.Observacao != null && data.Observacao != "") {
                temp = "ObsAtiva";
            } else {
                temp = "ObsDesativa";
            }
            $('#TabelaLancamento').append('<tr class="' + data.Class + '"><td>' + data.ClienteID + '</td><td>' + data.Data_Estoque + '</td><td>' +
                    data.NR + '</td><td>' + data.ProdutoID + '</td><td>' + data.Peso + ' Kg </td><td>' + data.Volume + '</td><td>' + data.situacao +
                    '</td><td class="nImprime"><button type="button" class="btn btn-info btn-md ' + temp + '" data-toggle="modal" data-target="#myModal' + data.ID + '">Obs</button></td>' +
                    '<td><input type="button" value="Excluir" class="btn btn-md btn-danger nImprime" onclick="myFunction(' + data.ID + ')"></td>' +
                    '<td><input type="button" value="Editar" class="btn btn-md btn-warning nImprime" onclick="Editar_Registo_Lanacamento(' + data.ID + ')"></td>' +
                    '</tr>');
        }
    });
    CarregaModalLancamento();
}

// lista tabela lançamento automatico (ultimos 30 dias - definido)
function CarregaLancamentoAdmin() {
    $('#TabelaLancamento').empty();
    $.getJSON('http://' + ip + '/Peixao/CRUD/RETRIAVE/R_tabelaLancamento.php', function (lista) {
        for (index = 0; index < lista.length; index++) {
            var data = lista[index];
            var temp = "";
            if (data.Observacao != null && data.Observacao != "") {
                temp = "ObsAtiva";
            } else {
                temp = "ObsDesativa";
            }
            $('#TabelaLancamento').append('<tr class="' + data.Class + '"><td>' + data.ClienteID + '</td><td>' + data.Data_Estoque + '</td><td>' +
                    data.NR + '</td><td>' + data.ProdutoID + '</td><td>' + data.Peso + ' Kg </td><td>' + data.Volume + '</td><td>' + data.situacao +
                    '</td><td class="nImprime"><button type="button" class="btn btn-info btn-md ' + temp + '" data-toggle="modal" data-target="#myModal' + data.ID + '">Obs</button></td>' +
                    '<td><input type="button" value="Excluir" class="btn btn-md btn-danger nImprime" onclick="myFunction(' + data.ID + ')"></td>' +
                    '<td><input type="button" value="Editar" class="btn btn-md btn-warning nImprime" onclick="Editar_Registo_Lanacamento(' + data.ID + ')"></td>' +
                    '</tr>');
        }
    });
    CarregaModalLancamento();
}

function CarregalancamentoUser() {
    $("#TabelaLancamento").empty();
    $.getJSON('http://' + ip + '/Peixao/CRUD/RETRIAVE/R_tabelaLancamento.php', function (lista) {
        for (index = 0; index < lista.length; index++) {
            var data = lista[index];
            var temp = "";
            if (data.Observacao != null && data.Observacao != "") {
                temp = "ObsAtiva";
            } else {
                temp = "ObsDesativa";
            }
            $("#TabelaLancamento").append("<tr class=" + data.Class + "><td>" + data.ClienteID + "</td><td>" + data.Data_Estoque + "</td>" +
                    "<td>" + data.NR + "</td><td>" + data.ProdutoID + "</td><td>" + data.Peso + " Kg </td><td>" + data.Volume + "</td><td>"
                    + data.situacao + "</td><td class='nImprime'><button type='button' class='btn btn-info btn-md " + temp + "' data-toggle='modal' data-target='#myModal" + data.ID + "''>Obs</button></td></tr>");
        }
    });
    CarregaModalLancamento();
}

function CarregaModalLancamento() {
    $('#ModalObs').empty();
    $.getJSON('http://' + ip + '/Peixao/CRUD/RETRIAVE/R_tabelaLancamento.php', function (lista) {
        var option = ''
        for (index = 0; index < lista.length; index++) {
            var data = lista[index];
            option += '<div id="myModal' + data.ID + '" class="modal fade" role="dialog"><div class="modal-dialog"><div class="modal-content"><div class="modal-header">' +
                    '<button type="button" class="close" data-dismiss="modal">&times;</button>' + '<h4 class="modal-title">Observação</h4></div><div class="modal-body"><p>' + data.Observacao + '</p>' +
                    '</div><div class="modal-footer"><button type="button" class="btn btn-default" data-dismiss="modal">Close</button>' + '</div></div></div></div>';
        }
        $('#ModalObs').append(option);
    });
}

function CarregaNomeProdutoEstoque(temp) {
    var TempUrl = 'http://' + ip + '/Peixao/CRUD/RETRIAVE/R_NomeProduto_lancamento.php?cod=' + temp;
    $.getJSON(TempUrl, function (lista) {
        for (index = 0; index < lista.length; index++) {
            var data = lista[index];
            document.getElementById("listProduto_A").value = data.Nome;
        }
    });
    return this;
}

function Editar_Registo_Lanacamento(valor) {
    if (confirm("O Produto selecionado será editado, quer mesmo continuar?\n após editado não e posivel recuperar os dados anteriores.") == true) {
        $("#CadastraLancamento_Admin").animate({height: 'hide'});
        $("#Editar_Oculta").animate({height: 'hide'});
        window.scrollTo(0, 0);
        var TempUrl = 'http://' + ip + '/Peixao/CRUD/RETRIAVE/R_EditarLancamento.php?cod=' + valor;
        $.getJSON(TempUrl, function (lista) {
            for (index = 0; index < lista.length; index++) {
                var data = lista[index];
                document.getElementById("cod_A").value = data.ID;
                // funtion retorna cliente - carrega lista cliente com cliente selecionado do edite
                CarregaListaClienteEstoque(data.ClienteID);
                document.getElementById("date_A").value = data.Data_Estoque;
                document.getElementById("NR_A").value = data.NR;
                // function busca produto retorna nome do produto
                CarregaNomeProdutoEstoque(data.ProdutoID);
                document.getElementById("PesoProduto_A").value = data.Peso;
                document.getElementById("VolumeProduto_A").value = data.Volume;
                // situação nao e necessario
                document.getElementById("ObsProduto_A").value = data.observacao;
                // console.log(data.Data_Estoque);
                Box_Situacao_Editar(data.situacao);
                // alert(data.situacao);
            }
        });
        // habilita a edição e exibe os valores carregados
        $("#temptest").animate({height: 'show'});
    } else {
        alert("Operação cancelada");
    }
}

//================================== BOX =======================================
// retorna o cliente ativo para a ediçao do lancamento
function CarregaListaClienteEstoque(temp) {
    $('#BoxClienteAtivoTemp').empty();
    $.getJSON('http://' + ip + '/Peixao/CRUD/RETRIAVE/R_ClienteAtivo.php', function (lista) {
        var option = "";
        for (index = 0; index < lista.length; index++) {
            var cliente = lista[index];
            if (cliente.ID == temp) {
                option += '<option value="' + cliente.ID + '" selected="selected">' + cliente.Nome + '</option>';
            } else {
                option += '<option value="' + cliente.ID + '">' + cliente.Nome + '</option>';
            }
        }
        $('#BoxClienteAtivoTemp').append(option);
    });
}

function Box_Cliente() {
    $('#BoxCliente').empty();
    $.getJSON('http://' + ip + '/Peixao/CRUD/RETRIAVE/R_Cliente.php', function (lista) {
        var option = '<option value="">Selecione um Cliente</option>'
        for (index = 0; index < lista.length; index++) {
            var cliente = lista[index];
            option += '<option value="' + cliente.ID + '">' + cliente.Nome + '</option>';
        }
        $('#BoxCliente').append(option);
    });
    return this;
}

function Box_Cliente_Ativo() {
    $('#BoxClienteAtivo').empty();
    $.getJSON('http://' + ip + '/Peixao/CRUD/RETRIAVE/R_ClienteAtivo.php', function (lista) {
        var option = "";
        for (index = 0; index < lista.length; index++) {
            var cliente = lista[index];
            if (cliente.ativo == 1) {
                option += '<option value="' + cliente.ID + '" selected="selected">' + cliente.Nome + '</option>';
            } else {
                option += '<option value="' + cliente.ID + '">' + cliente.Nome + '</option>';
            }
        }
        $('#BoxClienteAtivo').append(option);
    });
    return this;
}


//------------------------------------------------------------------------------

function SelectBox_Produto() {
    $('#SelectBoxProduto').empty();
    $.getJSON('http://' + ip + '/Peixao/CRUD/RETRIAVE/R_Produtos.php', function (lista) {
        var option = '<option value="">Selecione um produto</option>';
        for (index = 0; index < lista.length; index++) {
            var produto = lista[index];
            option += '<option value="'+produto.ID+'">' + produto.Nome + '</option>'
        }
        $('#SelectBoxProduto').append(option);
    });
}

function SelctBox_Produto_Edicao() {
    $('#SelectBoxProduto_E').empty();
    $.getJSON('http://' + ip + '/Peixao/CRUD/RETRIAVE/R_Produtos.php', function (lista) {
        var option = '<option value="">Selecione um produto</option>';
        for (index = 0; index < lista.length; index++) {
            var produto = lista[index];
            option += '<option value="'+produto.ID+'">' + produto.Nome + '</option>'
        }
        $('#SelectBoxProduto_E').append(option);
    });
}
//------------------------------------------------------------------------------
function Box_Produto() {
    $('#BoxProduto').empty();
    $.getJSON('http://' + ip + '/Peixao/CRUD/RETRIAVE/R_Produtos.php', function (lista) {
        var option;
        for (index = 0; index < lista.length; index++) {
            var produto = lista[index];
            option += '<option value="'+produto.Nome+'">' + produto.Nome + '</option>'
        }
        $('#BoxProduto').append(option);
    });
}

function Box_Produto_Edicao() {
    $('#BoxProduto_E').empty();
    $.getJSON('http://' + ip + '/Peixao/CRUD/RETRIAVE/R_Produtos.php', function (lista) {
        var option;
        for (index = 0; index < lista.length; index++) {
            var produto = lista[index];
            option += '<option value="'+produto.Nome+'">' + produto.Nome + '</option>'
        }
        $('#BoxProduto_E').append(option);
    });
}

function Box_Situacao() {
    $('#Boxsituacao').empty();
    $.getJSON('http://' + ip + '/Peixao/CRUD/RETRIAVE/R_Situacao.php', function (lista) {
        var option = '<option value="">Situação</option>'
        for (index = 0; index < lista.length; index++) {
            var situacao = lista[index];
            option += '<option value=' + situacao.ID + '>' + situacao.Tipo + '</option>'
        }
        $('#Boxsituacao').append(option);
    });
}
//------------------------------------------------------------------------------
function Box_Situacao_Editar(valor) {
    $('#BoxsituacaoTemp').empty();
    $.getJSON('http://' + ip + '/Peixao/CRUD/RETRIAVE/R_Situacao.php', function (lista) {
        var option = '<option value="">Situação</option>'
        for (index = 0; index < lista.length; index++) {
            var situacao = lista[index];
            if (situacao.ID == valor) {
                option += '<option value=' + situacao.ID + ' selected>' + situacao.Tipo + '</option>'
            } else {
                option += '<option value=' + situacao.ID + '>' + situacao.Tipo + '</option>'
            }
        }
        $('#BoxsituacaoTemp').append(option);
    });
}

//=============================AJUSTAR -- na duvida vou fazer mais nao lenbro onde esta sendo utilizado ou se esta sendo usado
function TotalEstoqueNaoFormatado() {
    $('#totalestoqueNF').empty();
    $.getJSON('http://' + ip + '/Peixao/CRUD/RETRIAVE/R_DadosTotalEstoque_NaoFormatados.php', function (lista) {
        for (index = 0; index < lista.length; index++) {
            var estoque = lista[index];
            if (estoque.Total_Volume > 0 || estoque.Total_Peso > 0) {
                $('#totalestoqueNF').append('<tr class="text-success"><td>' + estoque.Cliente + '</td><td>' + estoque.Total_Volume + '</td><td>' + estoque.Total_Peso + '</td></tr>');
            } else {
                $('#totalestoqueNF').append('<tr class="text-danger"><td>' + estoque.Cliente + '</td><td>' + estoque.Total_Volume + '</td><td>' + estoque.Total_Peso + '</td></tr>');
            }
        }
    });
}