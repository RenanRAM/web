<?php
	proteger();
	$idCategoria = @(int)$_GET['cat'];
	if($idCategoria != 0){
		$catnome = MySql::conectar()->prepare("SELECT nome FROM `info_categorias` WHERE id = ?");
		$catnome->execute([$idCategoria]);
		//if($catnome->rowCount() > 0){
			$catnome = $catnome->fetch()['nome'];
		//}else{

		//}
	}else{
		$catnome = 'Livres';
	}


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
	<button class="tamanho" title="Alterar tamanho">+</button>
	<header class="edicao" catid="<?php echo $idCategoria; ?>">
		<?php echo painelNavegacao(); ?>

		<p id="selecionados">Selecionados(0)</p>
		<label for="arquivosInput"><i class="fa fa-plus"></i> Adicionar</label><input type="file" id="arquivosInput" multiple style="display:none;">
		<p id="removerSelecao"><i class="fa fa-times"></i> <?php echo match ($idCategoria) {
			0 => 'Excluir definitivo',
			default => 'Remover/Liberar',
		} ?></p>
		<div class="opcoes"><i class="fa fa-file-o"></i> Mover
			<div>
				<?php
					$sql = MySql::conectar()->prepare("SELECT * FROM `info_categorias` WHERE nome != '' AND id != ?");
					$sql->execute([$idCategoria]);
					$sql = $sql->fetchAll();
					foreach($sql as $value){
				?>
					<p categoria="<?php echo $value['nome']; ?>" catid="<?php echo $value['id']; ?>"><?php echo $value['nome']; ?></p>

				<?php } ?>
			</div>
		</div><!--opcoes-->
		<p id="salvar">Salvar</p>
	</header>
	<p class="vertical direita"><?php echo $catnome; ?></p>
	<p class="vertical esquerda">Editar</p>
	<div class="container-imgs">
		<?php
			$sql = MySql::conectar()->prepare("SELECT * FROM `imgs-categorias` WHERE catid = ?");
			$sql->execute([$idCategoria]);
			$sql = $sql->fetchAll();
			foreach($sql as $value){
		?>
			<div class="cat-imgs" imgid="<?php echo $value['id']; ?>" catid="<?php echo $value['catid']; ?>">
				<div class="img-fundo" style="background-image: url('<?php echo PATH.'imagens/'.$value['nome_img']; ?>')">
				</div><!--img-fundo-->
			</div><!--cat-imgs-->
		<?php } ?>
	</div><!--container-imgs-->	
	
</body>
<script src="<?php echo PATH; ?>js/categoria.js"></script>
</html>