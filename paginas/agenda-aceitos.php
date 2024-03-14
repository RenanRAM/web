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
<?php
	$msg = 'mensagem muito longa que não cabe em uma só linha por isso estou usando esses 3 pontinhos para indicar que haverá uma continuação dessa mensagem que já está longa de mais e eu ainda estou escrevendo não sei porque';
?>
<body>
	<header>
		<p class="titulo">Agenda/Aceitos</p>
		<p class="selecao"><a href="<?php echo PATH."?agenda=pendentes" ?>">Aceitos</a> | <a href="">Finalizados</a> | <a href="">Home</a></p>
	</header>
	<div class="confirma-fundo">
		<div class="confirma-janela">
			<article>
				<h2>Confirmação!</h2>
				<p><?php echo $msg; ?></p>
			</article>
			<div class="btn-confirma">
				<div class="sim">Sim!</div>
				<div class="nao">Não!</div>
			</div>
		</div><!--confirma-janela-->
	</div><!--confirma-fundo-->
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
				
				for($i=0;$i<11;$i++){
					echo <<<ELEMENTOS
					<p cliente_id="$i" cliente_nome="Leitonia" cliente_hora="20:05" cliente_data="12/12/2024" title="Clique para expandir!">
					Leitônia | 12/12/2024 | 20:05 | <msglimit>$msg</msglimit> 
					<strong class="botoes">Finalizar</strong>
					</p>
					ELEMENTOS;
				}
			?>
			<div class="paginacao">
				<?php
					for($i=1;$i<50;$i++){
						$at = $i == 27?'atual':'';
						echo <<<ELEMENTOS
						<p pagina="$i" $at>$i</p>
						ELEMENTOS;
					}
				?>
			</div><!--paginacao-->
		</section><!--lista-->
	</div><!--container-->
</body>
<script src="<?php echo PATH; ?>js/agenda-finalizador.js"></script>
<script src="<?php echo PATH; ?>js/paginador.js"></script>
<script src="<?php echo PATH; ?>js/agenda-exibirmsg.js"></script>
</html>