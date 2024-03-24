<!--
	para fazer:
	-ok ajustar melhor a imagem central selecionada quando estiver em telas menores
	-ok adicionar foto e texto no campo E3
	-ok botões de troca de slide
	-ok animação de troca de slide
	-ok texto no campo M2
	-ok imagem de alta resolução para backgroung do campo M2
	-ok(whatsapp pronto, falta outras redes sociais) links reais para redirecionar às redes sociais
	-ok efeitos de animação lentos para deixar o site menos estático
	-ok icone do site
	-logomarca
	-ok colocar mais coisas no footer
	-ok fazer imagem aparecer na hora que carrega no sistema de edição
	-ok upload de imagens do E2
	-ok proteger contra reenvio do formulário
	-ok remover foto antiga de perfil
	-melhorar sistema de formulário para evitar conflito com mais de 1 usuário, não precisa pois só tem 1 usuário
	-ok sistema de edição completo!
	-?opção para trocar a cor de algumas coisas?
	-ok sistema de senha (key) para entrar na página de edição, usar funções de hash do php
	-ok proteção por camadas
	-ok sistema inteligente de horários para editar e detecção de possíveis invasões
	-ok pagina de erro
	-outras configurações do .htaccess
	-ok metatags SEO
	-mapeamento do site no google (ver aulas de SEO)
	-ok colocar title="titulo do link" nas tags <a> e <img>
	-ok colocar alt="texto alternativo" nas tags <img>
	-ok reduzir a altura dos slides para telas menores no responsivo
	-script para geração automática das tabelas do banco de dados
	-agenda status: em andamento...
	-finalizar o front da página de contato
	-icones do form de contato
	-ok animação de enviado do contato
	-ok adicionar botão de enviar no form contato
	-ok validar a solicatação via php
	-ok validar campos do formulario contato via JS
	-criar banco de dados de solicitações com status
	-impedir o envio de muitas solicitações do mesmo cliente via tempo
	-ok criar mascara para o input de número de telefone

	-!sistema de backup!
-->

<?php
	include('config.php');
	include('classes.php');
	if(isset($_GET['sair'])){
		sair();
	}
	$controle = new getControl();

	$controle->rota(0,'inde.php');
	$controle->rota('ambientes','ambientes.php');
	$controle->rota('imagens','imagens.php');
	$controle->rota('contato','contato.php',);
	$controle->rota('pgf','editar-categorias.php','editar-categorias');
	$controle->rota('pgf','editar.php','edicao-geral');
	$controle->rota('pgf','categoria.php','cat');
	$controle->rota('pgf','gerenciar-imgs.php','imgs-home');
	$controle->rota('login','login.php');
	$controle->rota('agenda','agenda-home.php','home');
	$controle->rota('agenda','agenda-finalizados.php','finalizados');
	$controle->rota('agenda','agenda-aceitos.php','aceitos');
	
	/* protótipo de uma forma de proteção
	$controle->proteger([
		$controle->rota('pgf','editar-categorias.php','editar-categorias'),
		$controle->rota('pgf','editar.php','edicao-geral'),
		$controle->rota('pgf','categoria.php','cat'),
		$controle->rota('pgf','gerenciar-imgs.php','imgs-home')
	]);
	*/
	

	include($controle->ver());

?>