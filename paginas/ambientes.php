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

	<!--tags meta-->
	<?php echo METATAGS; ?>
	
	<title><?php echo TITULO_SITE; ?></title>
</head>
<body class="ambientes">
	<?php
		if(isset($_GET['escuro']))
		echo '<div class="sombra"></div><!--sombra-->' 
	?>
	
	<div class="localizacao-foto"><img src=""></div>
	<header>
		<a title="Página principal" href="<?php echo PATH; ?>"><p class="brilho"><?php echo NOME_EMPRESA; ?></p></a>
		<div>
			<a title="Contato" href="https://wa.me/5551984197554" target="_blank"></i><p class="brilho"><i class="fa fa-whatsapp"></i> <?php echo $infoSite['telefone']; ?></p></a>	
		</div>
	</header>
	<article class="ambientes"><a title="Todos ambientes" href="<?php echo PATH.'?ambientes'; ?>"><h1>Ambientes</h1></a></article>
	<div class="container-imgs">
		<?php
			$sql = MySql::conectar()->prepare("SELECT *,`info_categorias`.`id` AS 'id' FROM `info_categorias` LEFT JOIN `imgs-categorias` ON (`info_categorias`.`id` = `imgs-categorias`.`catid`) WHERE nome != '' GROUP BY `info_categorias`.`id`");
			$sql->execute();
			$categorias = $sql->fetchAll();
			foreach($categorias as $value){//lembrar que esse arquivo é carregado no diretório principal atravéz do include();
				if(($value['nome_img'] != '') && file_exists('imagens/'.$value['nome_img'])){
		?>

			<a href="<?php echo PATH; ?>?imagens&ambiente=<?php echo $value['id']; ?>">
				<div class="img-fundo" title="<?php echo 'Categoria: '.$value['nome']; ?>" style="background-image: url('<?php echo PATH.'imagens/'.$value['nome_img']; ?>')">
					<h3><?php echo $value['nome']; ?></h3><!--cat-titulo-->
				</div><!--img-fundo-->
			</a>
		<?php }} ?>
	</div><!--container-imgs-->
	
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
<script src="<?php echo PATH; ?>js/jquery.js"></script>
</html>