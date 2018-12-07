<?php
	session_start();
  if(!isset($_SESSION['loginUsuario'])){
      header("location:index.php?erro=UsuarioInvalido");
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
  <link href="http://fonts.googleapis.com/css?family=Source+Sans+Pro:200,300,400,600,700,900" rel="stylesheet" />
  <link href="style.css" rel="stylesheet"> 
  <link href="default.css" rel="stylesheet"> 
  
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/free-jqgrid/4.15.5/jquery.jqgrid.min.js"></script>
  
  <title>Tabela de Usuarios</title>

</head>

<body>
  <div id="header">
    <div id="menu" class="container">
		  <ul>
        <li><a href="menu.php" accesskey="1" title="">Inicio</a></li>
        <li><a href="editarUsuario.php" accesskey="2" title="">Editar Usuario</a></li>
        <li><a href="deslogar.php" accesskey="3" title="">Deslogar</a></li>
		  </ul>
	  </div>
  </div>
  
  <div id="logo" class="container">
	  <h1><a class="icon icon-tasks"><span>Tabela de Usuários</span></a></h1>
  </div>
  
  <div class="configs">
    <table id="grid"></table>
  </div>
  
  <div id="copyright" class="container">
	   <p> <a href="http://www.seti.com.br/">@Seti-Tecnologia</a></p>
  </div>
</body>
</html>


<script type="text/javascript">
  $(document).ready(function Jqgrid() {
    $("#grid").jqGrid({
      type: "POST",
      url: 'retrive.php?op=listarUsuario',
      datatype: "json",
      colNames: ["Usuario", "Login", "Senha"],
      colModel: [
        { name: "usuario", label: "usuario", width: 170, align: "center" },
        { name: "login", label: "login", width: 170, align: "center" },
        { name: "senha", label: "senha", width: 170, align: "center" },
      ],
      guiStyle: "bootstrap",
      iconSet: "fontAwesome",
      rownumbers: true,
      sortIconsBeforeText: true,
      headertitles: true,
      pager: true,
    });
  })
</script>