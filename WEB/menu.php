<?php
	session_start();
  if(!isset($_SESSION['loginUsuario'])){
      header("location:index.php?erro=UsuarioInvalido");
    }
?>

<html>
<head>
	<title>Bem-Vindo A Seti</title>

	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="keywords" content="" />
	<meta name="description" content="" />

	<link href="http://fonts.googleapis.com/css?family=Source+Sans+Pro:200,300,400,600,700,900" rel="stylesheet" />
	<link href="default.css" rel="stylesheet" type="text/css" media="all" />
	<link href="fonts.css" rel="stylesheet" type="text/css" media="all" />
	<link href="default.css" rel="stylesheet">
	<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css"> 

</head>
<body>
	<div id="header">
		<div id="menu" class="container">
			<ul>
				<li><a href="tabelaUsuarios.php" accesskey="1" title="">Tabela de Usuarios</a></li>
				<li><a href="tabelaContatos.php" accesskey="2" title="">Agenda de Contatos</a></li>
				<li><a href="tabelaRotas.php" accesskey="3" title="">Acessar rotas</a></li>
				<li><a href="deslogar.php" accesskey="4" title="">Deslogar</a></li>
			</ul>
		</div>
	</div>
	<div id="logo" class="container">
		<h1><a class="icon icon-tasks"><span>Bem Vindo a Seti-Tecnologia</span></a></h1>
	</div>



	<div id="page" class="container">
		<div id="content">
			<div class="title">
				<h2> Seti</h2>
					<span class="byline">Firewall, IDS, IPS, VPN, QOS, Antispam, E-mail, Balanceamento e Redundância de links, Cluster, Appliance, Controle de Skype, Controle de Navegação, Colaboração, Hotspot, Relatórios.</span>
			</div>
		</div>
			<div id="sidebar"><a href="http://www.seti.com.br/" class="image image-full"><img src="http://www.seti.com.br/wp-content/uploads/2018/07/12fgh.jpg" alt="" /></a></div>
	</div>
	
		<br><br>
	<h2 class="w3-center"></h2>
	<div class="w3-content w3-section image image-full" style="width: 100%" >
		<img class="mySlides" src="img/14550119_370824023307020_8613089267498876928_n.jpg" style="height:65%">
		<img class="mySlides" src="img/14624564_1861970930699245_859226315146919936_n.jpg" style="height:65%">
		<img class="mySlides" src="img/14676666_658235377686330_5767545508297965568_n.jpg" style="height:65%">
		<img class="mySlides" src="img/14714525_1801949920047916_5471211761514315776_n.jpg" style="height:65%">
		<img class="mySlides" src="img/15056742_220383151731627_2719821068490506240_n.jpg" style="height:65%">
		
	</div>


	<div id="copyright" class="container">
	   <p> <a href="http://www.seti.com.br/">@Seti-Tecnologia</a></p>
  </div>
</body>

</html>

<script>

var myIndex = 0;
carousel();

function carousel() {
    var i;
    var x = document.getElementsByClassName("mySlides");
    for (i = 0; i < x.length; i++) {
       x[i].style.display = "none";  
    }
    myIndex++;
    if (myIndex > x.length) {myIndex = 1}    
    x[myIndex-1].style.display = "block";  
    setTimeout(carousel, 4000); // Change image every 2 seconds
}

</script>