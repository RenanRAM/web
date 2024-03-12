

<?php
	proteger();
	$cat = MySql::conectar()->prepare("SELECT nome FROM `info_categorias` WHERE nome != ''");
	$cat->execute();
	$cat = $cat->fetchAll();
?>



<!DOCTYPE html>
<html>
<head>
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Zen+Maru+Gothic:wght@300;400;500&display=swap" rel="stylesheet">
	<link href="<?php echo PATH; ?>css/estilo-edicao.css" rel="stylesheet">
	<link href="<?php echo PATH; ?>css/font-awesome.css" rel="stylesheet">
	<link rel="icon" href="<?php echo PATH; ?>favicon.ico" type="image/x-icon">

	<!--tags meta-->
	<?php echo METATAGS; ?>
	
	<title><?php echo TITULO_SITE; ?></title>
</head>
<body>
	<header><?php echo painelNavegacao(); ?></header>
	<p class="vertical direita">Categorias</p>
	<p class="vertical esquerda">Editar</p>
	<div class="categoria-container">
		<?php
			foreach($cat as $valor){
		?>

		<div class="categoria-single">
			<?php echo $valor['nome']; ?><i class="fa fa-times"></i>
		</div><!--categoria-single-->
		<?php } ?>
		<div id="adiciona" class="categoria-single">
			<textarea></textarea><i class="fa fa-check"></i>
		</div><!--categoria-single-->
		<div class="categoria-adicionar">
			Adicionar <i class="fa fa-plus"></i>
		</div><!--categoria-single-->
		<div id="salvar">Salvar</div>
	</div><!--categoria-container-->
	
</body>
<script src="<?php echo PATH; ?>js/edicao-categoria.js"></script>
</html>