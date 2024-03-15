<?php
	proteger();
?>
<!DOCTYPE html>
<html>
<head>
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Zen+Maru+Gothic:wght@300;400;500&display=swap" rel="stylesheet">
	<link href="<?php echo PATH; ?>css/estilo-agenda.css" rel="stylesheet">
	<link href="<?php echo PATH; ?>css/font-awesome.css" rel="stylesheet">
	<link rel="icon" href="<?php echo PATH; ?>favicon.ico" type="image/x-icon">

	<!--tags meta-->
	<?php echo METATAGS; ?>
	
	<title><?php echo TITULO_SITE.' | Agenda'; ?></title>
</head>
<body>
	<header>
		<p class="titulo">Agenda/Home</p>
		<p class="selecao"><a href="<?php echo PATH."?agenda=aceitos" ?>">Aceitos</a> | <a href="<?php echo PATH."?agenda=finalizados" ?>">Finalizados</a> | <a href="<?php echo PATH."?agenda=home" ?>">Home</a></p>
	</header>
	<div class="email">
		<h1></h1>
		<textarea></textarea>
		<div class="enviar-email" title="Enviar!"><i class="fa-regular fa-paper-plane" style="position: absolute;
	top: 50%;
	left: 45%;
	transform: translate(-50%,-50%);
	display: block;
	color: red;
	font-size: 25px;"></i></div><!--enviar-email-->
	<div class="cancelar" title="Cancelar!"><i class="fa-solid fa-xmark" style="position: absolute;
	top: 50%;
	left: 49%;
	transform: translate(-50%,-50%);
	display: block;
	color: red;
	font-size: 25px;"></i></div><!--cancelar-->
	</div><!--email-->
	<p class="vertical direita">Aprovados</p>
	<div class="container">
		<div class="avisos">
			<p class="aviso">Hoje(<?php echo 11; ?>)</p>
			<article>
				<?php
					for($i=0;$i<11;$i++){
				?>
					<p>Riquinho Rico | 13:54</p>
				<?php } ?>
			</article>
		</div><!--avisos-->
		
		<section class="lista">
			<div class="msg-completa" title="Clique para fechar"></div>
			<?php
				$msg = 'mensagem muito longa que não cabe em uma só linha por isso estou usando esses 3 pontinhos para indicar que haverá uma continuação dessa mensagem que já está longa de mais e eu ainda estou escrevendo não sei porque';
				for($i=0;$i<11;$i++){
					echo <<<ELEMENTOS
					<p cliente_id="$i" cliente_nome="Leitonia" cliente_hora="20:05" cliente_data="12/12/2024" title="Clique para expandir!">
					Leitônia | 12/12/2024 | 20:05 | <msglimit>$msg</msglimit> 
					<strong class="botoes" aceitar>Aceitar</strong> <strong class="botoes">Recusar</strong>
					</p>
					ELEMENTOS;
				}
			?>
		</section><!--lista-->
	</div><!--container-->
</body>
<script src="<?php echo PATH; ?>js/agenda-base.js"></script>
<script src="<?php echo PATH; ?>js/agenda-caixaEmail.js"></script>
<script src="<?php echo PATH; ?>js/agenda-exibirmsg.js"></script>
<script src="https://kit.fontawesome.com/577303188c.js" crossorigin="anonymous"></script>
</html>