<?php
function run_s4($prog, $params, $backGround = false, $debug = false){
	if (strlen($prog) < 1)
		return "A operaÃ§Ã£o nÃ£o foi informada.";

	if (!strstr($prog, "sudo "))
    $prog = "sudo ".$prog;
  
	$cmd = $prog." ";

	if (is_array($params)){
		foreach ($params as $p){
			if (!strlen($p) || $p == "undefined")
				$cmd .= "'' ";
			else if ($p == "NaN")
				$cmd .= "'0' ";
			else {
				if (strstr($p, "\\"))
					$p = str_replace("\\", "[S4_BARRAC]" ,$p);
				$cmd .= escapeshellarg(escapeshellcmd($p))." ";
			}
		}
	}

	if ($backGround == true)
		$cmd .= "&";
	else
		$cmd .= ";echo $? >&3";

	if ($debug)
		`echo "$cmd" >> /tmp/debug`;

	$descriptorspec = array(
			0 => array("pipe", "r"), // stdin
			1 => array("pipe", "w"), // stdout
			2 => array("pipe", "w"), // stderr
			3 => array("pipe", "w")  // exit_code
			);

	$saida = "";
	$process = proc_open($cmd, $descriptorspec, $pipes, NULL, NULL);
	if (is_resource($process)) {
		fclose($pipes[0]);
		if (!$backGround){
			while(!feof($pipes[1])){
				set_time_limit(0);
				$str = fgets($pipes[1]);
				ob_flush();
				flush();

				$saida .= str_replace(array("\r\n","\r","\n","\\r","\\n","\\r\\n"), "" ,$str);
			}
		}
		fclose($pipes[1]);
		fclose($pipes[2]);
		if (!$backGround && !feof($pipes[3]))
			$cod = rtrim(fgets($pipes[3], 5), "\n");
		fclose($pipes[3]);
		$rv = proc_close($process);

		if ($cod == 99) {
			if (strlen($saida)) return $saida;
			else return "99";//
		} else if ($cod == 98) {
			if (strlen($saida)) return $saida;
			else return "98";//LicenÃ§a de usuÃ¡rios de e-mails chegou ao limite.
		} else if ($cod == 97) {
			if (strlen($saida)) return $saida;
			else return "97";//LicenÃ§a de usuÃ¡rios de navegaÃ§Ã£o chegou ao limite.
		} else if ($cod == 77) {
			if (strlen($saida)) return $saida;
			else return "77";//LicenÃ§a atual nÃ£o permite acesso ao mÃ³dulo.
		} else if ($cod == 76) {
			if (strlen($saida)) return $saida;
			else return "76";//Somente clientes contratuais podem atualizar o S4.
		} else if ($cod == 1) {
			if (strlen($saida)) return $saida;
			else return $erro;// Erro de execuÃ§Ã£o
		} else if ($cod && $cod != 143 && $cod != 141) {
			return "Falha ao executar operação.";
		}
	}
	return $saida;
}