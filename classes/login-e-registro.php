<?php
/**************************************/
/* CONTROLE DE REGISTRO E LOGIN FUTFÁCIL
/*
/* Criador: Luigi Matheus Afornalli - SKORP
/* Data: 22-08-15
/* Versão: 1.0
/*
/**************************************/
include('../config/config.php');

$AJAX = array();
parse_str($_POST['ajax'], $AJAX);

/**************************************/
/* SALVA ALGUMAS VARIAVEIS QUE VAMOS ULTILIZAR
/**************************************/
date_default_timezone_set('America/Sao_Paulo');
$data_registro = date("Y-m-d H:i:s");
$ultimo_login = date("Y-m-d H:i:s");
$email = isset($_GET['email']) ? $_GET['email'] : '';
$nome = isset($_GET['nome']) ? $_GET['nome'] : '';
$nome_ou_email = isset($_GET['nome_ou_email']) ? $_GET['nome_ou_email'] : '';
$telefone = isset($_GET['telefone']) ? $_GET['telefone'] : '';
$flags = 'FLAG_ZERO';

/**************************************/
/* EXECUTA AS AÇÕES ENVIADAS PELO AJAX
/**************************************/
if ($AJAX['acao'] == 'registro') {
	
	// MONSTA A QUERY PARA VERIFICAR SE O USUÁRIO JÁ EXISTE
	$query = "SELECT * FROM futfacil_capitao WHERE NOME='$nome' and (EMAIL='$email' OR TELEFONE='$telefone')";
	// EXECUTA A QUERY
	$resultado = mysql_query($query);
	// EXECUTA AS AÇÕES CASO O USUÁRIO EXISTA OU NÃO
	if(mysql_num_rows($resultado) >= 1)
	{
		// USUÁRIO JÁ EXISTE
		print_r($_GET['callback'].'('.json_encode(array('ok' => 'Já existe um usuário ultilizando estes dados! <br> Caso seja você, recupere a senha na tela de login.'), JSON_UNESCAPED_UNICODE).');');
	}
	else
	{
		// USUÁRIO NÃO EXISTE, ENTÃO ELE É CADASTRADO NO SISTEMA
		$query = "
		INSERT INTO futfacil_capitao 
			(
				DATA_REGISTRO,
				ULTIMO_LOGIN, 
				NOME, 
				EMAIL, 
				TELEFONE,
				FLAGS
			)
		VALUES('" 
			. $data_registro . "',
			'" . $ultimo_login . "',
			'" . $nome . "',
			'" . $email . "',
			'" . $telefone . "',
			'" . $flags . "'
		);";
		
		// EXECUTO A QUERY PARA CADASTRAR O USUÁRIO
		$resultado = mysql_query($query);

		// VERIFICO E RETORNO O RESULTADO A TELA DE REGISTRO
		if ($resultado) {
			
			// PEGO O ID DO USUÁRIO QUE ACABOU DE SER CADASTRADO
			$query = "SELECT * FROM futfacil_capitao WHERE NOME='$nome' and (EMAIL='$email' OR TELEFONE='$telefone')";
			$resultado = mysql_query($query);
			$row = mysql_fetch_array($resultado);
			$ID = $row['ID'];
				
			// MONTO A QUERY QUE VAI CADASTRAR O TIME DO CAPITÃO 'VAZIO'
			$query = "INSERT INTO futfacil_times (JOGADOR_CAPITAO, JOGADOR_POS, JOGADOR_NOME, JOGADOR_TELEFONE) VALUES ('$ID', 'GL', 'NENHUM', '(00) 0000-0000'),('$ID', 'LE', 'NENHUM', '(00) 0000-0000'), ('$ID', 'MC', 'NENHUM', '(00) 0000-0000'), ('$ID', 'LD', 'NENHUM', '(00) 0000-0000'), ('$ID', 'AE', 'NENHUM', '(00) 0000-0000'), ('$ID', 'AC', 'NENHUM', '(00) 0000-0000'),('$ID', 'AD', 'NENHUM', '(00) 0000-0000');";
			$resultado = mysql_query($query);
			
			// VERIFICO SE O TIME FOI CRIADO OU NÃO
			if ($resultado) {
				// RETORNA A MENSAGEM AVISANDO QUE FUNCIONOU
				print_r($_GET['callback'].'('.json_encode(array('ok' => 'Você foi cadastrado com sucesso! <br> Agora você já pode logar! =)'), JSON_UNESCAPED_UNICODE).');');
			} else {
				// CASO TENHA DADO ERRO:
				print_r($_GET['callback'].'('.json_encode(array('ok' => 'Ocorreu um erro, entre em contato consoco! COD: CAD#02 <br> Contato: suporte@skorp.com.br'), JSON_UNESCAPED_UNICODE).');');
			}
			
		} else {
			// CASO TENHA DADO ERRO:
			print_r($_GET['callback'].'('.json_encode(array('ok' => 'Ocorreu um erro, entre em contato consoco! COD: CAD#01 <br> Contato: suporte@skorp.com.br'), JSON_UNESCAPED_UNICODE).');');
		}
	}
	
} elseif ($AJAX['acao'] == 'logar') {
	
	// VERIFICA SE EXISTE UM USUÁRIO COM OS DADOS INFORMADOS
	$query = "SELECT * FROM futfacil_capitao WHERE TELEFONE='$telefone' and (EMAIL='$nome_ou_email' OR NOME='$nome_ou_email')";
	$resultado = mysql_query($query);
	// SALVA O ID DO USUÁRIO EM UMA VARIAVEL
	$row = mysql_fetch_array($resultado);
	$ID = $row['ID'];
	// EXECUTA AS AÇÕES CASO O USUÁRIO EXISTA OU NÃO
	if(mysql_num_rows($resultado) == 1)
	{
		$query = "UPDATE futfacil_capitao SET ULTIMO_LOGIN='$ultimo_login' WHERE EMAIL='$email' and TELEFONE='$telefone'";
		$resultado = mysql_query($query);
		if($resultado) {			
			// RETORNA MENSAGEM DE LOGADO COM SUCESSO
			print_r($_GET['callback'].'('.json_encode(array('ok' => 'Você foi logado com sucesso! Redirecioanndo... =)','logado' => 'sim','ID' => $ID), JSON_UNESCAPED_UNICODE).');');
		}
		else
		{
			// RETORNA MENSAGEM DE ERRO AO LOGAR
			print_r($_GET['callback'].'('.json_encode(array('ok' => 'Erro ao efetuar o login.<br>Entre em contato com o suporte.'), JSON_UNESCAPED_UNICODE).');');
		}
	}
	else 
	{
		// USUÁRIO NÃO ENCONTRADO
		print_r($_GET['callback'].'('.json_encode(array('ok' => 'Usuário não encontrado.'), JSON_UNESCAPED_UNICODE).');');
	}

} elseif ($AJAX['acao'] == 'query_jogadores') {
	
	// SETA O ID DO USUÁRIO OU ENTÃO RETORNA UM ERRO
	if (isset($AJAX['ID']))
	{
		$ID = $AJAX['ID'];
	}
	else
	{
		print_r($_GET['callback'].'('.json_encode(array( 'ok' => 'ID do usuário não foi informado!' ), JSON_UNESCAPED_UNICODE).');');
	}
	
	// BUSCA OS JOGADORES DO TIME
	$query = "SELECT * FROM futfacil_times WHERE `JOGADOR_CAPITAO` = $ID";
	//$query = "SELECT $PEDIDO FROM `futfacil_times` WHERE `JOGADOR_CAPITAO` = $ID AND `JOGADOR_POS` = 'GL'";
	$resultado = mysql_query($query);
	

	while ($row = mysql_fetch_array($resultado, MYSQL_NUM)) {
		$ajax[$row[2]] = array(
			'JOGADOR_ID' => $row[0],
			'JOGADOR_CAPITAO' => $row[1],
			'JOGADOR_POS' => $row[2],
			'JOGADOR_NOME' => $row[3],
			'JOGADOR_TELEFONE' => $row[4]
		);
	}
	
	print_r($_GET['callback'].'('.json_encode(array('ok' => $ajax), JSON_UNESCAPED_UNICODE).');');
	
} elseif ($AJAX['acao'] == 'editar-jogador') {
	
	// DEFINE AS VARIAVEIS QUE VAMOS ULTILIZAR
	$ID = $AJAX['ID'];
	$sigla = $AJAX['posicao'];
	$nome = $AJAX['nome_jogador'];
	$telefone = $AJAX['telefone_jogador'];
	
	// MONTA A QUERY PARA EDITAR O JOGADORES
	$query = "UPDATE futfacil_times SET JOGADOR_NOME='$nome' , JOGADOR_TELEFONE='$telefone' WHERE JOGADOR_POS='$sigla' and JOGADOR_CAPITAO='$ID'";
	// EXECUTO A QUERY PARA CADASTRAR O USUÁRIO
	$resultado = mysql_query($query);

	// VERIFICO E RETORNO O RESULTADO A TELA DE REGISTRO
	if ($resultado) {
		print_r($_GET['callback'].'('.json_encode(array('ok' => 'Jogador editado com sucesso!'), JSON_UNESCAPED_UNICODE).');');
	} else {
		print_r($_GET['callback'].'('.json_encode(array('erro' => 'Erro ao editar o jogador!'), JSON_UNESCAPED_UNICODE).');');
	}

} elseif ($AJAX['acao'] == 'query_perfil') {
	
	// DEFINE AS VARIAVEIS QUE VAMOS ULTILIZAR
	$ID = $AJAX['ID'];
	
	// MONTA A QUERY PARA EDITAR O JOGADORES
	$query = "SELECT * FROM futfacil_capitao WHERE ID='$ID'";
	// EXECUTO A QUERY PARA CADASTRAR O USUÁRIO
	$resultado = mysql_query($query);

	// VERIFICO E RETORNO O RESULTADO A TELA DE REGISTRO
	if ($resultado) {
		$row = mysql_fetch_array($resultado);
		
		$ajax['ID'] = $row['ID'];
		$ajax['NOME'] = $row['NOME'];
		$ajax['EMAIL'] = $row['EMAIL'];
		$ajax['TELEFONE'] = $row['TELEFONE'];
		
		print_r($_GET['callback'].'('.json_encode(array('ok' => $ajax), JSON_UNESCAPED_UNICODE).');');
	} else {
		print_r($_GET['callback'].'('.json_encode(array('erro' => 'Erro ao editar o usuário!'), JSON_UNESCAPED_UNICODE).');');
	}
 
} elseif ($AJAX['acao'] == 'salva_editar_perfil') {
	
	// DEFINE AS VARIAVEIS QUE VAMOS ULTILIZAR
	$ID = $AJAX['ID'];
	$NOME = $AJAX['editar-perfil-nome'];
	$EMAIL = $AJAX['editar-perfil-email'];
	$TELEFONE = $AJAX['editar-perfil-telefone'];
	
	// MONTA A QUERY PARA EDITAR O JOGADORES
	$query = "UPDATE futfacil_capitao SET NOME='$NOME' , EMAIL='$EMAIL' , TELEFONE='$TELEFONE' WHERE ID='$ID'";
	// EXECUTO A QUERY PARA CADASTRAR O USUÁRIO
	$resultado = mysql_query($query);

	// VERIFICO E RETORNO O RESULTADO A TELA DE REGISTRO
	if ($resultado) {
		print_r($_GET['callback'].'('.json_encode(array('ok' => 'Perfil editado com sucesso!'), JSON_UNESCAPED_UNICODE).');');
	} else {
		print_r($_GET['callback'].'('.json_encode(array('erro' => 'Erro ao editar o perfil!'), JSON_UNESCAPED_UNICODE).');');
	}
 
} elseif ($AJAX['acao'] == 'marcar-jogo-final') {
	// DEFINE AS VARIAVEIS QUE VAMOS ULTILIZAR
	$ID = $AJAX['ID'];
	$PERIODO = $AJAX['PER'];
	$TELEFONE = $AJAX['confirmacao-telefone'];
	
	// MONSTA A QUERY PARA VERIFICAR SE JÁ HÁ JOGOS MARCADOS
	$query = "SELECT * FROM futfacil_jogos WHERE futfacil_jogos.JOGO_TIME_1 = '$ID' OR futfacil_jogos.JOGO_TIME_2 = '$ID' AND futfacil_jogos.JOGO_CANCELADO = '0'";
	$resultado = mysql_query($query);
	if(mysql_num_rows($resultado) >= 1)
	{
		// JÁ TEM JOGOS MARCADOS
		print_r($_GET['callback'].'('.json_encode(array('erro' => 'Você já tem jogos marcados!', 'color' => 'rgb(204, 31, 31)'), JSON_UNESCAPED_UNICODE).');');
	}
	else
	{
		// VERIFICA SE TEM JOGOS COM OS MESMOS REQUISITOS
		$query = "SELECT * FROM futfacil_jogos WHERE futfacil_jogos.JOGO_PERIODO = '$PERIODO' AND futfacil_jogos.JOGO_TIME_2 = '0' LIMIT 1";
		$resultado = mysql_query($query);
		if(mysql_num_rows($resultado) >= 1)
		{
			// ENCONTROU JOGADOR ENTÃO ATUALIZA O JOGO
			$row = mysql_fetch_array($resultado);
			$row = $row['JOGO_ID'];
			$query = "UPDATE `futfacil_web`.`futfacil_jogos` SET `JOGO_ATUALIZADO`='$data_registro', `JOGO_TIME_2`='$ID', `JOGO_TELEFONE_2`='$TELEFONE', `JOGO_APROVADO`='2' WHERE (`JOGO_ID`='$row');";
			$resultado = mysql_query($query);

			// VERIFICO E RETORNO O RESULTADO A TELA DO USUÁRIO
			if ($resultado) {
				print_r($_GET['callback'].'('.json_encode(array('ok' => 'Jogador encontrado! <br /> Entraremos em contato por telefone para confirmação do jogo.', 'color' => 'rgb(26, 177, 136)'), JSON_UNESCAPED_UNICODE).');');
			} else {
				print_r($_GET['callback'].'('.json_encode(array('erro' => 'Erro ao marcar novo jogo!', 'color' => 'rgb(204, 31, 31)'), JSON_UNESCAPED_UNICODE).');');
			}
		}
		else
		{
			// NÃO TEM JOGOS IGUAL ENTÃO CRIAMOS UM NOVO
			$query = "INSERT INTO futfacil_jogos (JOGO_CRIADO,JOGO_ATUALIZADO,JOGO_PERIODO,JOGO_TIME_1,JOGO_TIME_2,JOGO_TELEFONE_1,JOGO_APROVADO) VALUES('$data_registro','$data_registro','".$PERIODO."','".$ID."','0','".$TELEFONE."','1');";
			$resultado = mysql_query($query);

			// VERIFICO E RETORNO O RESULTADO A TELA DO USUÁRIO
			if ($resultado) {
				print_r($_GET['callback'].'('.json_encode(array('ok' => 'Novo jogo marcado com sucesso!', 'color' => 'rgb(26, 177, 136)'), JSON_UNESCAPED_UNICODE).');');
			} else {
				print_r($_GET['callback'].'('.json_encode(array('erro' => 'Erro ao marcar novo jogo!', 'color' => 'rgb(204, 31, 31)'), JSON_UNESCAPED_UNICODE).');');
			}
		}		
	}
	
} elseif ($AJAX['acao'] == 'meusjogos') {
	// DEFINE AS VARIAVEIS QUE VAMOS ULTILIZAR
	$ID = $AJAX['ID'];
	
	// MONSTA A QUERY PARA VERIFICAR SE O USUÁRIO JÁ EXISTE
	$query = "SELECT * FROM futfacil_jogos WHERE JOGO_TIME_1='$ID' OR JOGO_TIME_2='$ID'"; 
	$resultado = mysql_query($query);

	while ($row = mysql_fetch_array($resultado, MYSQL_NUM)) {
		// BUSCA OS NOMES DOS JOGADORES PELOS IDS
		$ID1 = $row[5];
		$query = "SELECT * FROM futfacil_capitao WHERE ID = '$ID1'"; 
		$resultado2 = mysql_query($query);
		$row2 = mysql_fetch_array($resultado2);
		
		// BUSCA OS NOMES DOS JOGADORES PELOS IDS
		$ID2 = $row[6];
		$query = "SELECT * FROM futfacil_capitao WHERE ID = '$ID2'"; 
		$resultado3 = mysql_query($query);
		$row3 = mysql_fetch_array($resultado3);
		
		// SALVA OS RESULTADOS NA ARRAY
		$lista[$row[0]] = array(
			'JOGO_ID' => $row[0],
			'JOGO_CRIADO' => $row[1],
			'JOGO_ATUALIZADO' => $row[2],
			'JOGO_DATA' => $row[3],
			'JOGO_PERIODO' => $row[4],
			'JOGO_TIME_1' => $row[5],
			'JOGO_TIME_2' => $row[6],
			'JOGO_TELEFONE_1' => $row[7],
			'JOGO_TELEFONE_2' => $row[8],
			'JOGO_APROVADO' => $row[9],
			'JOGO_DIA' => $row[10],
			'JOGO_MES' => $row[11],
			'JOGO_HORA' => $row[12],
			'JOGO_ENDERECO' => $row[13],
			'JOGO_TELEFONE_CONTATO' => $row[14],
			'JOGO_CANCELADO' => $row[15],
			'NOME_TIME_1' => $row2['NOME'],
			'NOME_TIME_2' => $row3['NOME']
			);
	}
	
	if(mysql_num_rows($resultado) >= 1)
	{
		print_r($_GET['callback'].'('.json_encode(array('ok' => 'Você já tem jogos marcados!', 'color' => 'rgb(204, 31, 31)', 'lista' => $lista), JSON_UNESCAPED_UNICODE).');');
	}
	else
	{
		print_r($_GET['callback'].'('.json_encode(array('erro' => 'Você não tem jogos marcados no momento!', 'color' => 'rgb(204, 31, 31)'), JSON_UNESCAPED_UNICODE).');');
	}
} elseif ($AJAX['acao'] == 'jogos-admin') {
	// DEFINE AS VARIAVEIS QUE VAMOS ULTILIZAR
	$ID = $AJAX['ID'];
	
	// MONSTA A QUERY PARA VERIFICAR SE O USUÁRIO JÁ EXISTE
	$query = "SELECT * FROM futfacil_jogos"; 
	$resultado = mysql_query($query);

	while ($row = mysql_fetch_array($resultado, MYSQL_NUM)) {
		// BUSCA OS NOMES DOS JOGADORES PELOS IDS
		$ID1 = $row[5];
		$query = "SELECT * FROM futfacil_capitao WHERE ID = '$ID1'"; 
		$resultado2 = mysql_query($query);
		$row2 = mysql_fetch_array($resultado2);
		
		// BUSCA OS NOMES DOS JOGADORES PELOS IDS
		$ID2 = $row[6];
		$query = "SELECT * FROM futfacil_capitao WHERE ID = '$ID2'"; 
		$resultado3 = mysql_query($query);
		$row3 = mysql_fetch_array($resultado3);
		
		// SALVA OS RESULTADOS NA ARRAY
		$lista[$row[0]] = array(
			'JOGO_ID' => $row[0],
			'JOGO_CRIADO' => $row[1],
			'JOGO_ATUALIZADO' => $row[2],
			'JOGO_DATA' => $row[3],
			'JOGO_PERIODO' => $row[4],
			'JOGO_TIME_1' => $row[5],
			'JOGO_TIME_2' => $row[6],
			'JOGO_TELEFONE_1' => $row[7],
			'JOGO_TELEFONE_2' => $row[8],
			'JOGO_APROVADO' => $row[9],
			'JOGO_DIA' => $row[10],
			'JOGO_MES' => $row[11],
			'JOGO_HORA' => $row[12],
			'JOGO_ENDERECO' => $row[13],
			'JOGO_TELEFONE_CONTATO' => $row[14],
			'JOGO_CANCELADO' => $row[15],
			'NOME_TIME_1' => $row2['NOME'],
			'NOME_TIME_2' => $row3['NOME']
			);
	}
	
	if(mysql_num_rows($resultado) >= 1)
	{
		print_r($_GET['callback'].'('.json_encode(array('ok' => 'Você já tem jogos marcados!', 'color' => 'rgb(204, 31, 31)', 'lista' => $lista), JSON_UNESCAPED_UNICODE).');');
	}
	else
	{
		print_r($_GET['callback'].'('.json_encode(array('erro' => 'Você não tem jogos marcados no momento!', 'color' => 'rgb(204, 31, 31)'), JSON_UNESCAPED_UNICODE).');');
	}
	
} elseif ($AJAX['acao'] == 'confirmar-jogo') {
	// DEFINE AS VARIAVEIS QUE VAMOS ULTILIZAR
	$ID = $AJAX['ID'];
	$JOGO_ID = $AJAX['JOGO_ID'];
	$DIA = $AJAX['confirmacao-jogo-dia'];
	$HORA = $AJAX['confirmacao-jogo-hora'];
	$MES = $AJAX['confirmacao-jogo-mes'];
	$ENDERECO = $AJAX['confirmacao-jogo-endereco'];
	$TELEFONE = $AJAX['telefone-contato'];
	$DATA = '2016-'.$MES.'-'.$DIA;
	
	// MONSTA A QUERY PARA VERIFICAR SE O USUÁRIO JÁ EXISTE
	$query = "UPDATE `futfacil_web`.`futfacil_jogos` SET `JOGO_DATA` = '$DATA',`JOGO_ATUALIZADO` = '$data_registro',`JOGO_APROVADO` = '3',`JOGO_DIA` = '$DIA',`JOGO_MES` = '$MES',`JOGO_HORA` = '$HORA',`JOGO_ENDERECO` = '$ENDERECO',`JOGO_TELEFONE_CONTATO` = '$TELEFONE' WHERE (`JOGO_ID` = '$JOGO_ID');"; 
	$resultado = mysql_query($query);
	
	if($resultado)
	{
		print_r($_GET['callback'].'('.json_encode(array('ok' => 'Jogo confirmado com sucesso!', 'color' => 'rgb(26, 177, 136)', 'rows' => $row), JSON_UNESCAPED_UNICODE).');');
	}
	else
	{
		print_r($_GET['callback'].'('.json_encode(array('erro' => 'Erro ao confirmar o jogo!', 'color' => 'rgb(204, 31, 31)'), JSON_UNESCAPED_UNICODE).');');
	}
	
} elseif ($AJAX['acao'] == 'finalizar-jogo') {
	// DEFINE AS VARIAVEIS QUE VAMOS ULTILIZAR
	$ID = $AJAX['ID'];
	$JOGO_ID = $AJAX['JOGO_ID'];
	$IMPD1 = $AJAX['impredimentos-time-1'];
	$IMPD2 = $AJAX['impredimentos-time-2'];
	$FALTAS1 = $AJAX['faltas-time-1'];
	$FALTAS2 = $AJAX['faltas-time-2'];
	$GOLS1 = $AJAX['gols-time-1'];
	$GOLS2 = $AJAX['gols-time-2'];
	
	// MONSTA A QUERY PARA VERIFICAR SE O USUÁRIO JÁ EXISTE
	$query = "UPDATE `futfacil_web`.`futfacil_jogos` SET `JOGO_ATUALIZADO` = '$data_registro',`JOGO_APROVADO` = '5' WHERE (`JOGO_ID` = '$JOGO_ID');"; 
	$resultado = mysql_query($query);
	
	if($resultado)
	{
		print_r($_GET['callback'].'('.json_encode(array('ok' => 'Jogo finalizado com sucesso!', 'color' => 'rgb(26, 177, 136)', 'rows' => $row), JSON_UNESCAPED_UNICODE).');');
	}
	else
	{
		print_r($_GET['callback'].'('.json_encode(array('erro' => 'Erro ao finalizar o jogo!', 'color' => 'rgb(204, 31, 31)'), JSON_UNESCAPED_UNICODE).');');
	}
	
} elseif ($AJAX['acao'] == 'jogo-realizado') {
	// DEFINE AS VARIAVEIS QUE VAMOS ULTILIZAR
	$ID = $AJAX['ID'];
	$JOGO_ID = $AJAX['JOGO_ID'];
	
	// MONSTA A QUERY PARA VERIFICAR SE O USUÁRIO JÁ EXISTE
	$query = "UPDATE `futfacil_web`.`futfacil_jogos` SET `JOGO_APROVADO` = '4' WHERE (`JOGO_ID` = '$JOGO_ID');"; 
	$resultado = mysql_query($query);
	
	if($resultado)
	{
		print_r($_GET['callback'].'('.json_encode(array('ok' => 'Mudança no estado do jogo realizada com sucesso!', 'color' => 'rgb(26, 177, 136)', 'rows' => $row), JSON_UNESCAPED_UNICODE).');');
	}
	else
	{
		print_r($_GET['callback'].'('.json_encode(array('erro' => 'Erro ao mudar o estado do jogo!', 'color' => 'rgb(204, 31, 31)'), JSON_UNESCAPED_UNICODE).');');
	}
	
} elseif ($AJAX['acao'] == 'jogo-cancelar') {
	// DEFINE AS VARIAVEIS QUE VAMOS ULTILIZAR
	$ID = $AJAX['ID'];
	$JOGO_ID = $AJAX['JOGO_ID'];
	
	// MONSTA A QUERY PARA VERIFICAR SE O USUÁRIO JÁ EXISTE
	$query = "UPDATE `futfacil_web`.`futfacil_jogos` SET `JOGO_CANCELADO` = '1' WHERE (`JOGO_ID` = '$JOGO_ID');"; 
	$resultado = mysql_query($query);
	
	if($resultado)
	{
		print_r($_GET['callback'].'('.json_encode(array('ok' => 'Jogo cancelado com sucesso!', 'color' => 'rgb(26, 177, 136)', 'rows' => $row), JSON_UNESCAPED_UNICODE).');');
	}
	else
	{
		print_r($_GET['callback'].'('.json_encode(array('erro' => 'Erro ao cancelar o jogo!', 'color' => 'rgb(204, 31, 31)'), JSON_UNESCAPED_UNICODE).');');
	}
	
} elseif ($AJAX['acao'] == 'receber-dados') {
	// DEFINE AS VARIAVEIS QUE VAMOS ULTILIZAR
	$ID = $AJAX['ID'];
	$JOGO_ID = $AJAX['JOGO_ID'];
		
	// MONSTA A QUERY PARA VERIFICAR SE O USUÁRIO JÁ EXISTE
	$query = "SELECT * FROM futfacil_jogos WHERE JOGO_ID = '$JOGO_ID'"; 
	$resultado = mysql_query($query);
	$row = mysql_fetch_array($resultado);
	
	// BUSCA OS NOMES DOS JOGADORES PELOS IDS
	$ID1 = $row['JOGO_TIME_1'];
	$query = "SELECT * FROM futfacil_capitao WHERE ID = '$ID1'"; 
	$resultado2 = mysql_query($query);
	$row2 = mysql_fetch_array($resultado2);
	
	// BUSCA OS NOMES DOS JOGADORES PELOS IDS
	$ID2 = $row['JOGO_TIME_2'];
	$query = "SELECT * FROM futfacil_capitao WHERE ID = '$ID2'"; 
	$resultado3 = mysql_query($query);
	$row3 = mysql_fetch_array($resultado3);

	
	if(mysql_num_rows($resultado) >= 1 || mysql_num_rows($resultado2) >= 1 || mysql_num_rows($resultado3) >= 1)
	{
		print_r($_GET['callback'].'('.json_encode(array('ok' => 'Dados encontrados!', 'lista' => $row, 'jgd1' => $row2, 'jgd2' => $row3), JSON_UNESCAPED_UNICODE).');');
	}
	else
	{
		print_r($_GET['callback'].'('.json_encode(array('erro' => 'Nenhum jogo encontrado com este ID!', 'color' => 'rgb(204, 31, 31)'), JSON_UNESCAPED_UNICODE).');');
	}
	
} elseif ($AJAX['acao'] == 'sair') {
	print_r($_GET['callback'].'('.json_encode(array('ok' => 'Você foi deslogado com sucesso!','logado' => 'nao'), JSON_UNESCAPED_UNICODE).');');
} else {
	print_r($_GET['callback'].'('.json_encode(array('ok' => 'ERRO NA OPEREÇÃO! USO INVÁLIDO DESTA FUNÇÃO.'), JSON_UNESCAPED_UNICODE).');');
}
