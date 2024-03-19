<?php

	$sql = MySql::conectar()->prepare("SELECT * FROM `info_site`");
	$sql->execute();
	$infoSite = $sql->fetchAll();
	$infoSite = isolarChaves($infoSite);

?>

<!DOCTYPE html>
<html>
<head>
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Zen+Maru+Gothic:wght@300;400;500&display=swap" rel="stylesheet">
	<link href="<?php echo PATH; ?>css/estilo.css" rel="stylesheet">
	<link href="<?php echo PATH; ?>css/font-awesome.css" rel="stylesheet">
	<link rel="icon" href="<?php echo PATH; ?>favicon.ico" type="image/x-icon">

	<!--meta tags-->
	<?php echo METATAGS; ?>

	<!--titulo e icone-->
	<title><?php echo TITULO_SITE; ?></title>
</head>
<body class="contato-fundo">
	<style>
		::selection{
			background: rgb(255,77,77);
			color: #FFFFFF;
		}
	</style>

	<header>
		<p class="brilho"><?php echo NOME_EMPRESA; ?></p>
		<div>
			<a title="Todos ambientes" href="<?php echo PATH; ?>?ambientes"><!--<i id="icone_menu" class="fa fa-arrow-circle-o-down"></i>--><p class="brilho pglink">Ambientes</p></a>
			<a title="Contato" href="https://wa.me/5551984197554" target="_blank"><p class="brilho"><i class="fa fa-whatsapp"></i> <?php echo $infoSite['telefone']; ?></p></a>	
		</div>
	</header>
	<div class="contato-principal">
		<article class="info">
			<h2>Agende um atendimento</h2>
			<p>Você pode entrar em contato diretamente pelo número <a title="Contato" href="https://wa.me/5551984197554" target="_blank"><i class="fa fa-whatsapp"></i> <?php echo $infoSite['telefone']; ?></a> ou marcando um horário usando os campos abaixo</p>
			<form method="post" class="form-contato">
				<div>
					<label for="in_nome">Nome completo</label>
					<input type="text" name="nome" id="in_nome" placeholder="Nome...">
				</div>
				<div>
					<label for="in_email">E-mail para contato</label>
					<input type="email" name="email" id="in_email" placeholder="E-mail">
				</div>
				<div>
					<label for="in_data">Data sugerida</label>
					<input type="datetime-local" name="data" id="in_data" placeholder="Escolha uma data">
				</div>
				<div>
					<label for="in_fone">Número de telefone</label>
					<input type="number" name="fone" id="in_fone" placeholder="9813543354...">
				</div>
				<div tipo="total">
					<label for="in_msg">Descrição curta</label>
					<input type="text" name="msg" id="in_msg" placeholder="Gostaia de fazer uma cozinha, quarto...">
				</div>
				
			</form>
		</article><!--info-->
	</div><!--contato--fundo-->
	<footer>
		<article>
			<h1>
				<?php echo TITULO_SITE; ?>®
			</h1>
			<p>Todos os direitos reservados</p>
			<ul>
				<li><i class="fa fa-map-signs"></i>Localização: <?php echo $infoSite['Footer-texto-1']; ?></li>
				<li><i class="fa fa-envelope-o"></i> E-mail: <?php echo $infoSite['Footer-texto-2']; ?></li>
				<li><i class="fa fa-map-o"></i> <a href="https://maps.app.goo.gl/zRkpsVFmPffNUAjPA" target="_blank">Vizualizar no Google Maps</a></li>
			</ul>
		</article>
	</footer>
</body>
<script src="<?php echo PATH; ?>js/contato.js"></script>


</html>