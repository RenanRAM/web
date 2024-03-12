<?php
	proteger();
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
	<header>
		<?php echo painelNavegacao(); ?>
	</header>
	<p class="vertical direita">Imagens</p>
	<p class="vertical esquerda">Gerenciar</p>
	<div class="container-imgs">
		<a href="<?php echo PATH; ?>?pgf=cat&cat=0">
			<?php
				$sql = MySql::conectar()->prepare("SELECT nome_img FROM `imgs-categorias` WHERE catid = 0 LIMIT 1");
				$sql->execute();
				if($sql->rowCount() > 0){
					$img0 = $sql->fetch()['nome_img'];
				}else{
					//$img0 = 'safe.png';
					$img0 ='';
				}
				
			?>
			<div class="cat-imgs">
				<div class="cat-titulo" style="background-color: lightgrey;">Fotos Livres</div><!--cat-titulo-->

				<div class="img-fundo" <?php echo $img0!=''?'style="background-image: url('.PATH.'imagens/'.$img0.')"':''; ?> >
					<i class="fa fa-pencil"></i>
					<p>Editar</p>
				</div><!--img-fundo-->
			</div><!--cat-imgs-->
		</a>
		<?php
			$sql = MySql::conectar()->prepare("SELECT *,`info_categorias`.`id` AS 'id' FROM `info_categorias` LEFT JOIN `imgs-categorias` ON (`info_categorias`.`id` = `imgs-categorias`.`catid`) WHERE nome != '' GROUP BY `info_categorias`.`id`");
			$sql->execute();
			$categorias = $sql->fetchAll();
			foreach($categorias as $value){
		?>
			<a href="<?php echo PATH; ?>?pgf=cat&cat=<?php echo $value['id']; ?>">
				<div class="cat-imgs">
					<div class="cat-titulo"><?php echo $value['nome'] ?></div><!--cat-titulo-->
					<div class="img-fundo" <?php echo $value['nome_img']!=''?'style="background-image: url('.PATH.'imagens/'.$value['nome_img'].')"':''; ?> >
						<i class="fa fa-pencil"></i>
						<p>Editar</p>
					</div><!--img-fundo-->
				</div><!--cat-imgs-->
			</a>
		<?php } ?>
	</div><!--container-imgs-->	
	
</body>
<script src="<?php echo PATH; ?>js/gerenciar-imgs.js"></script>
</html>