<?php
/********************************************/
/* SISTEMA DE AGENDAMENTOS DE JOGOS FUTFÁCIL
/*
/* Criador: Luigi Matheus Afornalli - SKORP
/* Criado em: 23-08-15
/* Última Atualização: 11-10-15
/* Versão: 2.0
/*
/* Releases
/* v1.0: Versão inicial do sistema de login e cadastro lançada.
/* v1.1: Varias melhorias no código foram lançadas.
/* v1.2: Iniciando construção do campo de futebol e da estrutura dos jogadores.
/* v1.3: Criando função para receber os jogadores do usário e mostra-los na tela.
/* v1.4: Função para atualizar os dados dos jogares após serem alterados implementada.
/* v1.5: Melhoria do sistema de cadastro/login e código para formatação do campo do telefone implementado.
/* v1.6: Código de cadastro de usuário atualizado para cadastrar os jogadores do time.
/* v1.7: Função para implementar jogadores adicionada.
/* v1.8: Implementando função "Meu Perfil".
/* v1.9: Adicionando processo de marcar jogo.
/* v2.0: Criado as opções certas na hora de marcar o jogo.
/* v2.1: Agora os jogos marcados são salvos na db, falta criar área para rayron aprovar os jogos.
/*
/*
/********************************************/
include('includes/header.html'); 
?>

<!-- ************************************* -->
<!-- INICIO TELA DE LOGIN                  -->
<!-- ************************************* -->
<div class="form">
	<ul class="tab-group">
		<li class="tab active"><a href="#signup">Registrar</a></li>
		<li class="tab"><a href="#login">Entrar</a></li>
	</ul>
	<div class="tab-content">
		<div class="esconde" id="mostra-resposta"></div>
		<div id="signup">
			<h1>Registre-se de graça!</h1>
			<form name="registro" action="./classes/login-e-registro.php" method="post">
				<input type="hidden" name="acao" value="registro">
				<div class="field-wrap">
					<label>
					Nome Completo<span class="req">*</span>
					</label>
					<input name="nome" type="text" required autocomplete="off" />
				</div>
				<div class="field-wrap">
					<label>
					Email<span class="req">*</span>
					</label>
					<input name="email" type="text" required autocomplete="off" />
				</div>
				<div class="field-wrap">
					<label>
					Telefone<span class="req">*</span>
					</label>
					<input name="telefone" type="text" id="telefone-registro" maxlength="15" required autocomplete="off" />
				</div>
				<button type="submit" class="button button-block"/>COMEÇAR</button>
			</form>
		</div>
		<div id="login">
			<h1>Bem-vindo novamente!</h1>
			<form name="logar" action="./classes/login-e-registro.php" method="post">
				<input type="hidden" name="acao" value="logar">
				<div class="field-wrap">
					<label>
					Nome ou Email<span class="req">*</span>
					</label>
					<input name="nome_ou_email" type="text" required autocomplete="off"/>
				</div>
				<div class="field-wrap">
					<label>
					Telefone<span class="req">*</span>
					</label>
					<input name="telefone" type="text" id="telefone-login" maxlength="15" required autocomplete="off"/>
				</div>
				<p class="forgot">
					<a href="#">Esqueceu a senha?</a>
				</p>
				<button name="logar" class="button button-block"/>ENTRAR</button>
			</form>
		</div>
	</div>
</div> 

<!-- ************************************* -->
<!-- INICIO ÁREA DE LOGADOS                -->
<!-- ************************************* -->
<div class="logado" style="display: none;">
	<div id="conteudo-logado2"></div>
	<div class="row">
		<div class="col-xs-1"></div>
			<div id="conteudo-logado"></div>
		<div class="col-xs-1"></div>
	</div>
</div>

<?php include('includes/footer.html'); ?>
<script>
/********************************************/
/* VERIFICA SE O USUÁRIO JÁ ESTA LOGADO
/********************************************/
$(document).ready(function(){
	if (getCookie("logado") == "sim") {
		usuarioLogado();
	} else {
		usuarioDeslogado();
	}
	id('telefone-registro').onkeyup = function(){
		mascara( this, mtel );
	}
	id('telefone-login').onkeyup = function(){
		mascara( this, mtel );
	}
});

/********************************************/
/* AÇÕES PARA O ESTADO DO USUÁRIO
/********************************************/
function usuarioLogado() {
	$('.form').hide();
	$('.logado').fadeIn('slow');
	$('#conteudo-logado2').load('includes/logado/navegacao-superior.html');
	$('#conteudo-logado').load('includes/logado/conteudo-logado.html');
}

function usuarioDeslogado() {
	$('.logado').hide();
	$('.form').fadeIn('slow');
}

/********************************************/
/* FUNÇÃO PARA PEGAR DADOS DO COOKIE
/********************************************/
function getCookie(cname) {
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for(var i=0; i<ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0)==' ') c = c.substring(1);
        if (c.indexOf(name) == 0) return c.substring(name.length,c.length);
    }
    return "";
} 

/********************************************/
/* RECEBE AS RESPOSTAS DO PHP
/********************************************/
var Resposta = function Resposta(dados)
{
	if (dados) {
		$('#mostra-resposta').removeClass('esconde');
		$("#mostra-resposta").show().delay(10000).fadeOut();
		document.getElementById("mostra-resposta").innerHTML = dados.ok;
		if (dados.logado == 'sim') {
			usuarioLogado();
			document.cookie="logado=sim";
			document.cookie="ID="+dados.ID;
		} else {
			usuarioDeslogado();
			document.cookie="logado=nao";
		}
	}
}


/********************************************/
/* CHECA A AUTENTICACAO DO USUARIO
/********************************************/
/*function isAutenticado() {
		var meuForm = $("form");
		var meuajax = $.param($(meuForm).serializeArray());
		$.ajax({
			type: "POST",
			url: '/classes/login-e-registro.php',
			data: meuajax,
			success: function(){  
				alert('1');
			},
			error: function(XMLHttpRequest, textStatus, errorThrown, errorThrown1) { 
				alert('2');
			},  
			dataType: 'jsonp'
		});
		return 'teste';
}
alert(isAutenticado());*/

/********************************************/
/* FAZ O REQUEST PARA O PHP
/********************************************/
var post;
$(document).ready(function(){
	$("form").submit(function (_event_) {	
		_event_.preventDefault();
		var meuForm = this;
		var meuajax;
		meuajax = $.param($(meuForm).serializeArray());
		post = meuajax;
		$.postJSON = function(url, data, func) { $.post(url+(url.indexOf("?") == -1 ? "?" : "&")+"callback=?", data, func, "json"); }
		$.postJSON(meuForm.action, { ajax: meuajax }, Resposta);

	});
});
</script>