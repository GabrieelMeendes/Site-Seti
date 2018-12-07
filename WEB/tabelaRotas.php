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
  <link href="jquery-ui-1.12.1.custom/jquery-ui.min.js">

  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/free-jqgrid/4.15.5/jquery.jqgrid.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script src="main.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.11/jquery.mask.min.js"></script>
    

  <title>Tabela de Rotas</title>

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
	  <h1><a class="icon icon-tasks"><span>Rotas</span></a></h1>
  </div>
  <div class="configs">
    <table id="grid"></table>
    <div id="paddtree"></div>
  </div>    
  
  <form id="dialog" autocomplete="off" action=index.php method=post title="Cadastrar Rota" style="display:none">
    <br>
    <label for="network" class="sr-only">Destino</label>
    <button type="button" id="ex" >Ex:</button>
    <a style="display:NONE" id="ex1">000.000.000.000/00</a>
    <br>
    <input type="text"  id="network" class="form-control"  placeholder="Network">
    <br>
    <button type="button" id="ex2" >Ex:</button>
    <a style="display:NONE" id="ex3">000.000.000.000</a>
    <br>
    <label for="gateway" class="sr-only">Gateway</label>
    <input type="text" id="gateway" class="form-control" placeholder="Gateway">
    <br>
    <label for="Metrica" class="sr-only">Metrica</label>
    <input type="text" id="metrica" class="form-control" placeholder="Metrica">
    <br>
    <label for="Iface" class="sr-only">Iface</label>
    <input type="text" id="iface" class="form-control" placeholder="I-Face ">
    <br>
    <button type="button" id="cadastrarRota" class="btn btn-dark" onclick="addRota()" >Cadastrar</button>
    <button class="btn btn-dark" onclick="voltarRotas()" type="button">Voltar</button> 
  </form>
  
  <div id="copyright" class="container">
	   <p> <a href="http://www.seti.com.br/">@Seti-Tecnologia</a></p>
  </div>

</body>
</html>

<script type="text/javascript">
  $('#network').mask('0ZZ.0ZZ.0ZZ.0ZZ/00', {
      translation: {
        'Z': {
          pattern: /[0-9]/, optional: true
        }
      }
  });

  $('#gateway').mask('0ZZ.0ZZ.0ZZ.0ZZ', {
      translation: {
        'Z': {
          pattern: /[0-9]/, optional: true
        }
      }
  });

  $(document).ready(function Jqgrid() {
    $("#grid").jqGrid({
      type: "POST",
      url: 'retrive.php?op=listarRota',
      datatype: "json",
      colNames: ["Destino","Roteador", "MascaraGen", "Opcoes", "Metrica", "Ref","Uso","Iface"],
      colModel: [
        { name: "Destino",index:'Destino' , width: 170, align: "center",sorttype:"float"},
        { name: "Roteador",index:'Roteador',  width: 170, align: "center",sorttype:"float"},
        { name: "MascaraGen",index:'MascaraGen',  width: 170, align: "center",sorttype:"float"},
        { name: "Opcoes", index:'Opcoes' ,width: 70, align: "center",sorttype:"float"},
        { name: "Metrica",index:'Metrica',  width: 80, align: "center",sorttype:"float" },
        { name: "Ref", index:'Ref', width: 70, align: "center",sorttype:"float" },
        { name: "Uso", index:'Uso', width: 70, align: "center",sorttype:"float" },
        { name: "Iface", index:'Iface' , width: 100, align: "center",sorttype:"float" },
      ],
      loadonce:true,
      pager : "#paddtree",
      guiStyle: "bootstrap"
    });
        
    $("#grid").jqGrid('filterToolbar', {autosearch: true,stringResult: false,searchOnEnter: false,defaultSearch: "cn"}); 

    jQuery("#grid").jqGrid('navGrid',"#paddtree",{add: false , del: false , edit:false,refresh:false,search:false});
    
    jQuery("#grid").jqGrid('navButtonAdd','#paddtree',{caption:"Adicionar", title:"Adicionar", buttonicon:"ui-icon-plus",url:"retrive.php?op=adicionar",onClickButton:
      function(){
        $( "#dialog" ).dialog();
      }
    })

    jQuery("#grid").jqGrid('navButtonAdd','#paddtree',{caption:"Remover", title:"Remover", buttonicon:"ui-icon-trash",onClickButton:
      function(){
        var selRowID = jQuery("#grid").jqGrid ('getGridParam', 'selrow');
        var ret = jQuery("#grid").jqGrid('getRowData', selRowID);
        var network = ret["Destino"];
        var gateway = ret["Roteador"];
        var mascara = ret["MascaraGen"];
        $.ajax({
          url:'retrive.php',
          method:'post',
          data: ({
            acao:'delRota',
            network : network,
            gateway : gateway,
            mascara : mascara
          }),
          success: function (data){
            if(data == "3"){
              alert("Rota deletada!")
              $("#grid").jqGrid('setGridParam', { datatype: 'json' }).trigger('reloadGrid', [{ page: 1 }]); 
            }
            if(data == "4"){
              alert("Está rota não pode ser deletada!")
            }
            if(data == "52"){
              alert("Selecione uma rota!")
            }
          }
        });
        
      }
    })
  })

  $("#ex").hover(function(){
    $("#ex1").toggle();
  });

  $("#ex2").hover(function(){
    $("#ex3").toggle();
  });


</script>

