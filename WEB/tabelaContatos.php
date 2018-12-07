<?php
	session_start();
  if(!isset($_SESSION['loginUsuario'])){
      header("location:index.php");
    }
?>


<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap-theme.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/free-jqgrid/4.15.5/css/ui.jqgrid.min.css">
  <link href="style.css" rel="stylesheet"> 
  <link href="default.css" rel="stylesheet"> 
  <link href="http://fonts.googleapis.com/css?family=Source+Sans+Pro:200,300,400,600,700,900" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/themes/redmond/jquery-ui.min.css">
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/free-jqgrid/4.15.5/jquery.jqgrid.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.11/jquery.mask.min.js"></script>
  <script src="main.js"></script>

  <title>Tabela de Contatos</title>

</head>

<body>
  <div id="header">
	  <div id="menu" class="container">
		  <ul>
        <li><a href="menu.php" accesskey="1" title="">Inicio</a></li>
        <li><a href="deslogar.php" accesskey="3" title="">Deslogar</a></li>
		  </ul>
	  </div>
  </div>
  
  <div id="logo" class="container">
	  <h1><a class="icon icon-tasks"><span>Agenda de Contatos</span></a></h1>
  </div>
  <div class="configs">
    <table id="grid"></table>
    <div id="paddtree"></div>
  </div>    

  <form id="dialog" autocomplete="off" action=index.php method=post title="Cadastrar Contato" style="display:none">
    <br>
    <label for="nome" class="sr-only">Nome</label>
    <input type="text" id="nome"  maxlength="50" class="form-control" placeholder="Nome do Contato">
    <br>
    <label for="sobrenome" class="sr-only">Sobrenome</label>
    <input type="text" id="sobrenome" maxlength="20" class="form-control" placeholder="Sobrenome">
    <br>
    <label for="endereco" class="sr-only">Endereco</label>
    <input type="text" id="endereco" maxlength="20" class="form-control" placeholder="Endereco">
    <br>
    <label for="telefone" maxlength="20" class="sr-only">Telefone</label>
    <input type="tel" id="telefone" class="form-control" placeholder="Telefone">
    <br>
    <label for="data_nascimento" class="sr-only"> Data de Nascimento </label>
    <input type="DATE"  id="data_nascimento" class="form-control" placeholder="Data de Nascimento">
    <div class="checkbox"></div>
    <button type="button" id="cadastrarOnclick" class="btn btn-dark" onclick="cadastrarContato()" >Cadastrar</button>
    <button class="btn btn-dark" onclick="voltarContatos()" type="button">Voltar</button> 
  </form>
  
  <div id="copyright" class="container">
	  <p> <a href="http://www.seti.com.br/">@Seti-Tecnologia</a></p>
  </div>

</body>
</html>

<script type="text/javascript">
$('#telefone').mask('(00) 0000-00009');
  $(document).ready(function Jqgrid() {
    $("#grid").jqGrid({
      type: "POST",
      url: 'retrive.php?op=listar',
      datatype: "json",
      colNames: ["ID","Nome", "Sobrenome", "Endereco", "Telefone", "Data de Nascimento"],
      colModel: [
        { name: "ID",index:'ID' , width: 50, align: "center",sorttype:"float"},
        { name: "nome",index:'nome',  width: 140, align: "center",sorttype:"float"},
        { name: "sobrenome",index:'sobrenome',  width: 140, align: "center",sorttype:"float"},
        { name: "endereco", index:'endereco' ,width: 200, align: "center",sorttype:"float"},
        { name: "telefone",index:'telefone',  width: 140, align: "center",sorttype:"float" },
        { name: "data_nascimento", index:'data_nascimento' , width: 120, align: "center",sorttype:"float" },
      ],
      loadonce:true,
      pager : "#paddtree",
      guiStyle: "bootstrap"
    });
        
    $("#grid").jqGrid('filterToolbar', {autosearch: true,stringResult: false,searchOnEnter: false,defaultSearch: "cn"}); 

    $("#grid").jqGrid('navGrid',"#paddtree",{add: false , del: false , edit:false,refresh:false,search:false});
    
    $("#grid").jqGrid('navButtonAdd','#paddtree',{caption:"Adicionar", title:"Adicionar", buttonicon:"ui-icon-plus",url:"retrive.php?op=adicionar",onClickButton:
      function(){
        $("#dialog").dialog();
      }
    })

    $("#grid").jqGrid('navButtonAdd','#paddtree',{caption:"Remover", title:"Remover", buttonicon:"ui-icon-trash",onClickButton:
      function(){
        var selRowID = jQuery("#grid").jqGrid ('getGridParam', 'selrow');
        var ret = jQuery("#grid").jqGrid('getRowData', selRowID);
        var IDcontato = ret["ID"];
        $.ajax({
          url:'retrive.php',
          method:'post',
          data: ({
            acao:'remover',
            ret :IDcontato,
          }),
          success: function (data){
            if(data == "1"){
              alert("Usuario deletado!")
              $("#grid").jqGrid('setGridParam', { datatype: 'json' }).trigger('reloadGrid', [{ page: 1 }]); 
            }
            else{
              alert("Selecione um contato para DELETAR!");
            }
          }
        });
        
      }
    })
  })
</script>

