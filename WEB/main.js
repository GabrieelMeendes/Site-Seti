function cad() {
  $.ajax({
    url:'retrive.php',
    type:'post',
    data: ({
      acao:'cadastro',
      nome: $("#nome").val(),
      login: $("#login").val(),
      senha: $("#senha").val()
    }),
    success: function (data){
      if (data == 1) {
        alert("Usuario cadastrado !!!")
        location.href = "index.php";
      }
      else if (data == 2) {
        alert("Usuario já existe !!!");
      }
      else if (data == 3){
        alert("Error de cadastro !!! (Campo Vazio) ")
      }
    }
  });
}

function editarUsers(){
  $.ajax({
    url:'retrive.php',
    type:'post',
    data: ({
      acao:'editar',
      atualLogin:$("#atualLogin").val(),
      atualSenha:$("#atualSenha").val(),
      mudarUsuario:$("#mudarUsuario").val(),
      mudarSenha:$("#mudarSenha").val()
    }),
    success: function(data){
      if (data == 1){
        $('#editar').trigger('reset');
        alert("Usuario e Senha Alterados")
      }
      else if (data == 2){
        alert("Campos invalidos ou usuario não exite!!!");
      }
    }
  });
}
function voltarContatos() {
  $("#dialog").dialog('close');
  $('#dialog').trigger('reset');
}

function voltarRotas() {
  $("#dialog").dialog('close');
  $('#dialog').trigger('reset');
}


function voltar() {
  window.location.href = 'index.php';
}

function editarUsuario() {
  window.location.href = 'editarUsuario.php';
}

function login() {
  $.ajax({
    url: 'retrive.php',
    type: 'post',
    data: ({
      acao:'login',
      loginUsuario: $("#loginUsuario").val(),
      senhaUsuario: $("#senhaUsuario").val(),
    }),
    success: function (data) {
      if (data === "1") {
        location.href = "menu.php";
      }
      else if (data === "2") {
        alert("Usuario não cadastrado!!!");
      }
    }
  });
}

function removerContato() {
  $.ajax({
    url: 'retrive.php',
    type: 'post',
    data: ({
      acao:'remover',
      contatoID: $("#ID").val(),
    }),
    success: function (data) {
      if (data == 1) {
        alert ("Usuario Deletado!");
      }
      else if (data == 2) {
        alert("Aconteceu um erro ao tentar deletar o Contato!");
      }
    }
  });
}

function cadastrarContato() {
  $.ajax({
    url: 'retrive.php',
    type: 'post',
    data: ({
      acao:'adicionar',
      nome: $("#nome").val(),
      sobrenome: $("#sobrenome").val(),
      endereco: $("#endereco").val(),
      telefone: $("#telefone").val(),
      data_nascimento: $("#data_nascimento").val(),
    }),
    success: function (data) {
 
      if (data == 1) {
        $("#dialog").dialog('close');
        $('#dialog').trigger('reset');
        $("#grid").jqGrid('setGridParam', { datatype: 'json' }).trigger('reloadGrid', [{ page: 1 }]);
        alert ("Contato Adicionado!");
      }
      else if (data == 2) {
        alert("Aconteceu um erro ao tentar adicionar o Contato!");
      }
      else if (data == 3){
        alert ("Data de nascimento invalida !")
      }
      else if (data == 5){
        alert("Preencha os campos corretamente.")
      }
      
    }
  });
}


function addRota() {
  $.ajax({
    url: 'retrive.php',
    type: 'post',
    data: ({
      acao:'addRota',
      network: $("#network").val(),
      gateway: $("#gateway").val(),
      metrica: $("#metrica").val(),
      iface: $("#iface").val(),
    }),
    success: function (data) {
      if (data == 1) {
        $("#dialog").dialog('close');
        $('#dialog').trigger('reset');
        $("#grid").jqGrid('setGridParam', { datatype: 'json' }).trigger('reloadGrid', [{ page: 1 }]);
        alert ("Rota Adicionada!");
      }
      else if (data == "") {
        alert("Aconteceu um erro ao adicionar a rota !");
      }   
    }
  });
}


