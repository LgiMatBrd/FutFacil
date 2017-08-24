<?php
/********************************************/
/* ÁREA DE ADMINISTRAÇÃO DE JOGOS FUTFÁCIL
/*
/* Criador: Luigi Matheus Afornalli - SKORP
/* Criado em: 23-08-15
/* Última Atualização: 11-10-15
/* Versão: 1.0
/*
/* Releases
/* v1.0: Versão inicial da área de admin criado
/*
/*
/********************************************/
include('includes/header.html'); 
?>

<!-- ************************************* -->
<!-- INICIO TELA DE LOGIN                  -->
<!-- ************************************* -->
<div class="form">
		<div class="esconde" id="mostra-resposta"></div>
		<div style="display: block ! important;" id="login">
			<h1>Bem-vindo Sr. Admin! =)</h1>
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
					<input name="telefone" type="text" id="telefone-login-admin" maxlength="15" required autocomplete="off"/>
				</div>
				<button name="logar" class="button button-block"/>ENTRAR</button>
			</form>
		</div>
</div> 

<!-- ************************************* -->
<!-- INICIO ÁREA DE LOGADOS                -->
<!-- ************************************* -->
<div class="logado" style="display: none;">
	<div id="conteudo-admin-1"></div>
	<div class="row">
		<div class="col-xs-1"></div>
			<div id="conteudo-admin-2"></div>
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
	
	/* CÓDIGO PARA EFEITO DO TELEFONE */
	id('telefone-login-admin').onkeyup = function(){
		mascara( this, mtel );
	}
});

/********************************************/
/* AÇÕES PARA O ESTADO DO USUÁRIO
/********************************************/
function usuarioLogado() {
	$('.form').hide();
	$('.logado').fadeIn('slow');
	$('#conteudo-admin-1').load('includes/admin/navegacao-admin.html');
	$('#conteudo-admin-2').load('includes/admin/conteudo-admin.html');
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