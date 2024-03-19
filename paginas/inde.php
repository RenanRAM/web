
<?php
	$sql = MySql::conectar()->prepare("SELECT * FROM `info_site`");
	$sql->execute();
	$infoSite = $sql->fetchAll();
	$infoSite = isolarChaves($infoSite);

	$extras = smartEscolha(0);
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
<body>
	<style>
		::selection{
			background: rgb(255,77,77);
			color: #FFFFFF;
		}
	</style>
	<?php
		if(isset($_GET['escuro']))
		echo '<div class="sombra"></div><!--sombra-->' 
	?>
	<div class="localizacao-foto"><img src=""></div>
	<header>
		<p class="brilho"><?php echo NOME_EMPRESA; ?></p>
		<div>
			<a title="Todos ambientes" href="<?php echo PATH; ?>?ambientes"><!--<i id="icone_menu" class="fa fa-arrow-circle-o-down"></i>--><p class="brilho pglink">Ambientes</p></a>
			<a title="Contato" href="https://wa.me/5551984197554" target="_blank"><p class="brilho"><i class="fa fa-whatsapp"></i> <?php echo $infoSite['telefone']; ?></p></a>	
		</div>
	</header>
	<div class="grade-principal">
		<div class="E1">
			<article class="brilho">
				<h2>
					<div class="icone"><i class="fa fa-wrench"></i></div>
					<?php echo $infoSite['E1-titulo-1']; ?>

				</h2>
				<p>
					<?php echo $infoSite['E1-texto-1']; ?>
				</p>
			</article>
		</div><!--E1-->
		<div class="E2">
			<article class="brilho">
				<h2>
					<?php echo $infoSite['E2-titulo-1']; ?>
				</h2>
				<hr/>
				<p>
					<?php echo $infoSite['E2-texto-1']; ?>
				</p>
			</article><!--brilho-->
			<img title="Foto Perfil" class="foto-perfil" src="<?php echo PATH.'imagens/'.$infoSite['E2-img-1']?>" />
			<article class="brilho">
				<p>
					<?php echo $infoSite['E2-texto-2']; ?>
				</p>
			</article><!--brilho-->
			<div class="grade-icones">
				<a title="Contato" href="https://wa.me/5551984197554" target="_blank"><i class="fa fa-whatsapp"></i></a>
				<a title="Contato" href="https://wa.me/5551984197554" target="_blank"><i class="fa fa-whatsapp"></i></a>
				<a title="Contato" href="https://wa.me/5551984197554" target="_blank"><i class="fa fa-whatsapp"></i></a>
				<a title="Contato" href="https://wa.me/5551984197554" target="_blank"><i class="fa fa-whatsapp"></i></a>
			</div><!--grade-icones-->
		</div><!--E2-->
		<div title="Referência" class="E3">
			<article class="endereco">
				<h3>
					<?php echo $infoSite['E3-titulo-1']; ?>
				</h3>
				<p>
					<?php echo $infoSite['E3-texto-1']; ?>
				</p>
			</article><!--endereco-->
		</div><!--E3-->
		<div class="M1">
			<div class="selecao">
				<div class="botoes">
					<?php echo $infoSite['M1-botao-1']==''?'':'<button real type="button">'.$infoSite['M1-botao-1'].'</button>'; ?>
					<?php echo $infoSite['M1-botao-2']==''?'':'<button real type="button">'.$infoSite['M1-botao-2'].'</button>'; ?>
					<?php echo $infoSite['M1-botao-3']==''?'':'<button real type="button">'.$infoSite['M1-botao-3'].'</button>'; ?>
					<?php echo $infoSite['M1-botao-4']==''?'':'<button real type="button">'.$infoSite['M1-botao-4'].'</button>'; ?>
				</div><!--botoes-->
				
				<?php echo $infoSite['M1-botao-1']==''?'':'<img title="Imagem: '.$infoSite['M1-botao-1'].'" src="'.PATH.'/imagens/'.$infoSite['M1-botao1-img'].'" />'; ?>
				<?php echo $infoSite['M1-botao-2']==''?'':'<img title="Imagem: '.$infoSite['M1-botao-2'].'" src="'.PATH.'/imagens/'.$infoSite['M1-botao2-img'].'" />'; ?>
				<?php echo $infoSite['M1-botao-3']==''?'':'<img title="Imagem: '.$infoSite['M1-botao-3'].'" src="'.PATH.'/imagens/'.$infoSite['M1-botao3-img'].'" />'; ?>
				<?php echo $infoSite['M1-botao-4']==''?'':'<img title="Imagem: '.$infoSite['M1-botao-4'].'" src="'.PATH.'/imagens/'.$infoSite['M1-botao4-img'].'" />'; ?>
			</div><!--selecao-->
		</div><!--M1-->
		<div class="M2">
			<article>
				<div class="linhas">
					<hr>
					<div class="icone"><i class="fa fa-picture-o brilho"></i></div>
					<hr>
				</div><!--linhas-->
				<h1>
					<?php echo $infoSite['M2-titulo-1']; ?>
				</h1>
				<p>
					<?php echo $infoSite['M2-texto-1']; ?>
				</p>
			</article><!--brilho-->
			<a href="<?php echo PATH.'?ambientes'; ?>">
				<div class="extras">
					<?php
						if(is_array($extras)){
							foreach ($extras as $value) {
								if(file_exists('imagens/'.$value['img'])){
									//o atributo 'fixa' impede que a imagem seja clicavel com a função que coloca a imagem no centro do javascript 
					?>
						<div><h2><?php echo $value['categoria']; ?></h2><img title="Imagem amostra de <?php echo $value['categoria']; ?>" fixa src=<?php echo PATH.'imagens/'.$value['img']; ?> /></div>
					<?php }}} ?>
				</div><!--extras-->
			</a>
		</div><!--M2-->
	</div><!--grade-principal-->
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
<script type="text/javascript">
	/*Constantes*/
	const tempoSlide = <?php echo $infoSite['tempo-slide']; ?>;
</script>
<script src="<?php echo PATH; ?>js/jquery.js"></script>
<script src="<?php echo PATH; ?>js/seletor.js"></script>
<?php if(isset($_GET['escuro'])){ ?>
	<script type="text/javascript">
		document.addEventListener('mousemove', function(event) {

			document.querySelector('.sombra').style.top = event.clientY+'px';
			document.querySelector('.sombra').style.left = event.clientX+'px';
		});
	</script>
<?php } ?>
</html>