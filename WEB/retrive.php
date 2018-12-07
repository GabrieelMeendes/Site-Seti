<?php
include("library.php");
session_start();

$acao = $_POST["acao"];
$op = $_GET["op"];

if ($op == "listarUsuario"){
  $ret  = exec("/home/seti/exercicio/WEB/binarios '$op'");
  echo $ret;
}

else if($acao == "cadastro"){
  $nome = $_POST["nome"];
  $login = $_POST["login"];
  $senha = $_POST["senha"];
  $params  = Array($acao,$nome,$login,$senha);
  $ret  = run_s4("/home/seti/exercicio/WEB/binarios",$params);
  echo $ret;
}

else if($acao == "login"){
  $loginUsuario = $_POST["loginUsuario"];
  $senhaUsuario = $_POST["senhaUsuario"];
  $params  = Array($acao,$loginUsuario,$senhaUsuario);
  $ret  = run_s4("/home/seti/exercicio/WEB/binarios",$params);
  if($ret == "1"){
    $_SESSION['loginUsuario'] = $loginUsuario;
    $_SESSION['senhaUsuario'] = $senhaUsuario;
  }
  echo $ret;
}

else if($acao == "editar"){
  $atualLogin = $_POST["atualLogin"];
  $atualSenha = $_POST["atualSenha"];
  $mudarUsuario = $_POST["mudarUsuario"];
  $mudarSenha = $_POST["mudarSenha"];
  $params  = Array($acao,$atualLogin,$atualSenha,$mudarUsuario,$mudarSenha);
  $ret = run_s4("/home/seti/exercicio/WEB/binarios",$params);
  echo $ret; 
}

else if ($op == "listar"){
  $params  = Array($op);
  $ret =  run_s4("/home/seti/exercicio/WEB/binarios", $params);
  echo $ret;
}

else if($acao == "remover"){
  $ID = $_POST["ret"];
  $params = Array($acao,$ID);
  $ret =  run_s4("/home/seti/exercicio/WEB/binarios", $params);
  echo $ret;
}

else if($acao == "adicionar"){
  $now = new DateTime();
  $datetime = $now->format('Y-m-d H:i:s'); 
  $nome = $_POST["nome"];
  $sobrenome = $_POST["sobrenome"];
  $endereco = $_POST["endereco"];
  $telefone = $_POST["telefone"];
  $data_nascimento = $_POST["data_nascimento"];
  $valores = explode("-",$data_nascimento);
  
  if($valores[0] < 1950 || $valores[0] > $datetime){
    echo "3";
  }
  else{
    $params = Array($acao,$nome,$sobrenome,$endereco,$telefone,$data_nascimento);
    $ret = run_s4("/home/seti/exercicio/WEB/binarios", $params);
    echo $ret;
  }
}

else if ($op == "listarRota"){
  $params  = Array($op);
  $ret = run_s4("/home/seti/exercicio/WEB/binarios",$params);
  echo $ret;
}

else if ($acao == "delRota"){
  $network = $_POST["network"];
  $gateway = $_POST["gateway"];
  $mascaraGen = $_POST["mascara"];
  if($network == "" || $gateway == ""){
    $ret = "5";
    echo $ret;
  }
  else if($network != "0.0.0.0"){
  $params  = Array($acao,$network,$mascaraGen,$gateway);
  $ret = run_s4("/home/seti/exercicio/WEB/binarios",$params);
  echo $ret;
  }else{
    $ret = "4";
    echo $ret;
  }
}

else if ($acao == "addRota"){
  $network = $_POST["network"];
  $gateway = $_POST["gateway"];
  $metrica = $_POST["metrica"];
  $iface = $_POST["iface"];
  $params  = Array($acao,$network,$gateway,$metrica,$iface);
  $ret = run_s4("/home/seti/exercicio/WEB/binarios",$params);
  echo $ret;
}

?>
