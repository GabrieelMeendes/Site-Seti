<?php
	session_start();
  if(!isset($_SESSION['loginUsuario'])){
      header("location:index.php?erro=UsuarioInvalido");
    }
?>

<!DOCTYPE html>
<html>

<head>
  <title>Editar Usuario</title>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link href="css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" type="text/css" media="screen" href="style.css" />
  <link href="http://fonts.googleapis.com/css?family=Source+Sans+Pro:200,300,400,600,700,900" rel="stylesheet" />
  <link href="default.css" rel="stylesheet">

  <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
  <script src="main.js"></script>

</head>

<body>
  <div id="header">
	  <div id="menu" class="container">
	  	<ul>
        <li><a href="menu.php" accesskey="1" title="">Inicio</a></li>
        <li><a href="tabelaUsuarios.php" accesskey="3" title="">Tabela de Usuario</a></li>
        <li><a href="deslogar.php" accesskey="3" title="">Deslogar</a></li>
		  </ul>
	  </div>
  </div>
  
  <br>
  
  <div id="logo" class="container">
	  <h1><a class="icon icon-tasks"><span>Atualizar Usuário</span></a></h1>
  </div>
    <div class="text-center">
      <div class=" form-signin ">
        <form action=menu.php method=post id="editar">
          <label for="atualLogin" class="sr-only">Usuario Atual</label>
          <input type="text" id="atualLogin" value = "<?php print $_SESSION['loginUsuario'] ?>" class="form-control" disabled placeholder="Usuario a editar">
          <br>
          <label for="atualSenha" class="sr-only">Senha Atual</label>
          <input type="password" id="atualSenha" class="form-control" placeholder="Senha Atual">
          <br>
          <label for="mudarUsuario" class="sr-only">Usuario</label>
          <input type="text" id="mudarUsuario" class="form-control" placeholder="Novo nome de Usuario">
          <br>
          <label for="mudarSenha" class="sr-only">Senha</label>
          <input type="password" id="mudarSenha" class="form-control" placeholder="Nova Senha">
          <br>
          <div class="checkbox">
          </div>
          <br>
         <button class="btn btn-dark" onclick="editarUsers()" type="button">Editar</button>
        </form>
      </div>
  </div>
  
  <div id="copyright" class="container">
	   <p> <a href="http://www.seti.com.br/">@Seti-Tecnologia</a></p>
  </div>

</body>
</html>