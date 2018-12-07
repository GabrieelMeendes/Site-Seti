<?php
	session_start();
  if(isset($_SESSION['loginUsuario'])){
      header("location:menu.php");
    }
?>

<html>

<head>
  <title>Tela de Login</title>
  
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <link href="style.css" rel="stylesheet">
  
  <script src="main.js"></script>
  <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
</head>

<body class="text-center configs1">
  <form class="form-signin">
    <img class="mb-4" src="http://www.seti.com.br/wp-content/uploads/2018/07/Sem-t%C3%ADtulo-2-300x136.png" alt="" width="152" height="72">
    <h1 class="h3 mb-3 font-weight-normal"></h1>
    <label for="inputUsuario" class="sr-only">Usuario</label>
    <input type="usuario" id="loginUsuario" class="form-control" placeholder="Usuario" required autofocus>
    <label for="inputPassword" class="sr-only">Password</label>
    <input type="password" id="senhaUsuario" class="form-control" placeholder="Password" required>
    <div class="checkbox mb-3">
    <label>
    <input type="checkbox" value="Lembrar-me"> Lembrar me
    </label>
    <hr>
    <a href=cadastrar.html>Cadastrar Usuário</a>
    </div>
    <button class="btn btn-dark btn-block" onclick="login()" type="button">Entrar</button>
  </form>
</body>
</html>
