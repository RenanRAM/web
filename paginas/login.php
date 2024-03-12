
<?php
	proteger(1);
	if(isset($_POST['enviar']) && isset($_POST['chave'])){
		//gerarTok(); funcionando
		//verificarTok(); funcionando
		if(verificarChave($_POST['chave'])){
			gerarTok();
			redirecionarJS('?pgf=edicao-geral');
		}
	}else{
		if(verificarTok()){
			redirecionarJS('?pgf=edicao-geral');
		}
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
	
	<title><?php echo TITULO_SITE; ?> Login</title>
</head>
<body>
	<p class="vertical esquerda">LOGIN</p>
	<div class="login">
		<article>
			<h3>Bem vindo, digite sua chave:</h3>
		</article>
		<form method="post">
			<input required type="password" name="chave" placeholder="Chave...">
			<input type="submit" name="enviar" value="Entrar">
		</form>
	</div><!--login-->
</body>
</html>