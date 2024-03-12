


<?php
	proteger();
	if(isset($_POST['salvar'])){
		//testar o número do form
		$sql = MySql::conectar()->prepare("SELECT texto FROM `info_site` WHERE nome = 'form-numero' LIMIT 1");
		$sql->execute();
		$formN = ($sql->fetch()['texto']);
		$Natual = $_POST['form-numero'];

		if(($formN != $Natual) && ctype_digit($Natual)){//estes 2 if verificam se o valor do $_POST['form-numero'] é apenas um número positivo menor que 256, por segurança
			$Natual = intval($Natual);
			if($Natual<256 && $Natual>=0){
				//tudo certo com o formulário
				foreach ($_POST as $key => $value) {//'name' do input deve ser o 'nome' da tabela info_site e 'value' do input será atualizado 
					if(is_string($key)){
						$sql = MySql::conectar()->prepare("UPDATE `info_site` SET texto = ? WHERE nome = ?");
						$sql->execute([$value,$key]);
					}
				}
				$status = 'Salvo';
				$arquivos = array_filter($_FILES,function($valor){//obtem um array com todos os arquivos de upload
					return ($valor['name'] != '') && ($valor['error'] === UPLOAD_ERR_OK);
				});

				if($arquivos != []){
					foreach ($arquivos as $key => $value){
						//M1-botao4-img
						//M1-botao-1
						if(preg_match('/(?<=M1-botao)(\d+)(?=-img)/i', $key,$numeros)){
							$botao = 'M1-botao-'.$numeros[0];
							//$arquivo é o conteudo do textarea
							$arquivo = trim($_POST[$botao]);//remove possíveis espaços em brando do final ou início da string
							$arquivo = removerCaracteresEspeciais($arquivo);
							if($arquivo != ''){//verifica se tem algo escrito na string do botão
								$nomeSalvo = $arquivo.'-img';
								if(carregarImagem($value,$nomeSalvo)){
									$nomeSalvoCompleto = $nomeSalvo.'.'.pathinfo($value['name'], PATHINFO_EXTENSION);
									$nomeAntigo = MySql::conectar()->prepare("SELECT texto FROM `info_site` WHERE nome = ?");
									$nomeAntigo->execute(array($key));
									$nomeAntigo = $nomeAntigo->fetch()['texto'];
									if(($nomeAntigo != $nomeSalvoCompleto) && file_exists(BASE_DIR_IMGS.$nomeAntigo)){
										unlink(BASE_DIR_IMGS.$nomeAntigo);
									}
									$sql = MySql::conectar()->prepare("UPDATE `info_site` SET texto = ? WHERE nome = ?");
									$sql->execute(array($nomeSalvoCompleto,$key));
								}
							}
						}else if(preg_match('/(?<=E2-img-)(\d+)$/i', $key,$numeros)){
							//$numeros armazena o número final do texto da imagem
							if(carregarImagem($value,IMAGEM_E2_1)){
								$nomeAntigo = MySql::conectar()->prepare("SELECT texto FROM `info_site` WHERE nome = ?");
								$nomeAntigo->execute(array($key));
								$nomeAntigo = $nomeAntigo->fetch()['texto'];
								$nomeSalvoCompleto = IMAGEM_E2_1.'.'.pathinfo($value['name'], PATHINFO_EXTENSION);
								if(($nomeAntigo != $nomeSalvoCompleto) && file_exists(BASE_DIR_IMGS.$nomeAntigo)){
									unlink(BASE_DIR_IMGS.$nomeAntigo);
								}
								$sql = MySql::conectar()->prepare("UPDATE `info_site` SET texto = ? WHERE nome = ?");
								$sql->execute(array($nomeSalvoCompleto,$key));
							}
						}else{
							$status = 'Erro no upload de imagens';
						}
					}
				}
			}
		}
	}
/* função de testes
	$uploads = array_filter(array_column($_FILES,'name'),function($valor,$chave){
		$ar = [];
		if($valor != ''){
			$ar[$chave] = $valor;
		}
		return ($ar != []);
	},ARRAY_FILTER_USE_BOTH);
*/

	//pegar informações atuais
	$sql = MySql::conectar()->prepare("SELECT * FROM `info_site`");
	$sql->execute();
	$dados = $sql->fetchAll();
	$dados = isolarChaves($dados);
	$formN = abs((int) $dados['form-numero']);
	if($formN > 100){
		$formN = 0;
	}else{
		$formN++;
	}

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
<body>
	<?php echo painelNavegacao(); ?>
	<div class="localizacao-foto"><img src=""></div>
	<form id="f1" method="post" enctype="multipart/form-data">
		<header>
			<p class="brilho"><?php echo TITULO_SITE; ?></p>
			<?php
				if(isset($status)){
					echo '<p temporario class="brilho" style="color:#0F0; font-size:38px">'.$status.'</p>';
				}
			?>
			</i><p class="brilho"><i class="fa fa-whatsapp"></i> <textarea name="telefone"><?php echo $dados['telefone']; ?></textarea></p>

		</header>
		<div class="grade-principal">
			<div class="E1">
				<article class="brilho">
					<h2>
						<textarea name="E1-titulo-1"><?php echo $dados['E1-titulo-1']; ?></textarea>
					</h2>
					<p>
						<textarea name="E1-texto-1"><?php echo $dados['E1-texto-1']; ?></textarea>
					</p>
				</article>
			</div><!--E1-->
			<div class="E2">
				<article class="brilho">
					<h2>
						<textarea name="E2-titulo-1"><?php echo $dados['E2-titulo-1']; ?></textarea>
					</h2>
					<hr/>
					<p>
						<textarea name="E2-texto-1"><?php echo $dados['E2-texto-1']; ?></textarea>
					</p>
				</article><!--brilho-->
				<label class="label-input-file-E2"><p>Trocar imagem <i class="fa fa-image"></i> <i class="fa fa-rotate-right"></i></p><input name="E2-img-1" type="file" /></label>
				<img class="foto-perfil" src="<?php echo PATH.'imagens/'.$dados['E2-img-1']?>" />
				<article class="brilho">
					<p>
						<textarea name="E2-texto-2"><?php echo $dados['E2-texto-2']; ?></textarea>
					</p>
				</article><!--brilho-->
				<div class="grade-icones">
					<a href="https://wa.me/5551984197554" target="_blank"><i class="fa fa-whatsapp"></i></a>
					<a href="https://wa.me/5551984197554" target="_blank"><i class="fa fa-whatsapp"></i></a>
					<a href="https://wa.me/5551984197554" target="_blank"><i class="fa fa-whatsapp"></i></a>
					<a href="https://wa.me/5551984197554" target="_blank"><i class="fa fa-whatsapp"></i></a>
				</div><!--grade-icones-->
			</div><!--E2-->
			<div class="E3">
				<article class="endereco">
					<h3>
						<textarea name="E3-titulo-1"><?php echo $dados['E3-titulo-1']; ?></textarea>
					</h3>
					<p>
						<textarea name="E3-texto-1"><?php echo $dados['E3-texto-1']; ?></textarea>
					</p>
				</article><!--endereco-->
			</div><!--E3-->
			<div class="M1">
				<div class="selecao">
					<div class="botoes">
						<button type="button"><textarea name="M1-botao-1"><?php echo $dados['M1-botao-1']; ?></textarea></button>
						<button type="button"><textarea name="M1-botao-2"><?php echo $dados['M1-botao-2']; ?></textarea></button>
						<button type="button"><textarea name="M1-botao-3"><?php echo $dados['M1-botao-3']; ?></textarea></button>
						<button type="button"><textarea name="M1-botao-4"><?php echo $dados['M1-botao-4']; ?></textarea></button>
					</div><!--botoes-->
					<div class="img-inputs">
						<!--usar um for(){} para fazer isso-->
						<label class="label-input-file"><p></p><input name="M1-botao1-img" type="file" /></label>
						<label class="label-input-file"><p></p><input name="M1-botao2-img" type="file" /></label>
						<label class="label-input-file"><p></p><input name="M1-botao3-img" type="file" /></label>
						<label class="label-input-file"><p></p><input name="M1-botao4-img" type="file" /></label>
					</div>
					<div class="controle-tempo">
						<label for="controle-tempo"></label>
						<input type="range" name="tempo-slide" max="24" min="2" step="1" id="controle-tempo" value="<?php echo $dados['tempo-slide']; ?>"/>
					</div><!--controle-tempo-->
					<img src="<?php echo ($dados['M1-botao1-img']==''? PATH.'imagens/safe.png' : PATH.'/imagens/'.$dados['M1-botao1-img']);?>">
					<img src="<?php echo ($dados['M1-botao2-img']==''? PATH.'imagens/safe.png' : PATH.'/imagens/'.$dados['M1-botao2-img']);?>">
					<img src="<?php echo ($dados['M1-botao3-img']==''? PATH.'imagens/safe.png' : PATH.'/imagens/'.$dados['M1-botao3-img']);?>">
					<img src="<?php echo ($dados['M1-botao4-img']==''? PATH.'imagens/safe.png' : PATH.'/imagens/'.$dados['M1-botao4-img']);?>">
				</div><!--selecao-->
			</div><!--M1-->
			<div class="M2">
				<article style="width: 100%;">
					<h1>
						<textarea name="M2-titulo-1"><?php echo $dados['M2-titulo-1']; ?></textarea>
					</h1>
					<p>
						<textarea name="M2-texto-1"><?php echo $dados['M2-texto-1']; ?></textarea>
					</p>
				</article><!--brilho-->
				<div class="extras">
					<h1>Imagens aqui serão escolhidas automaticamente</h1>
				</div>
			</div><!--M2-->
		</div><!--grade-principal-->
		<footer>
			<article>
				<h1>
					<?php echo TITULO_SITE; ?>®
				</h1>
				<p>Todos os direitos reservados</p>
				<input type="hidden" name="form-numero" value="<?php echo $formN ?>" />
				<input type="submit" name="salvar" value="Salvar!" />
				<ul>
					<li><i class="fa fa-map-signs"></i> Localização: <textarea name="Footer-texto-1"><?php echo $dados['Footer-texto-1']; ?></textarea></li>
					<li><i class="fa fa-envelope-o"></i> E-mail: <textarea name="Footer-texto-2"><?php echo $dados['Footer-texto-2']; ?></textarea></li>
					<li><i class="fa fa-map-o"></i> <a href="https://maps.app.goo.gl/zRkpsVFmPffNUAjPA" target="_blank">Vizualizar no Google Maps</a></li>
				</ul>
			</article>
		</footer>
	</form>
</body>

<script src="<?php echo PATH; ?>js/jquery.js"></script>
<script src="<?php echo PATH; ?>js/edicao.js"></script>
</html>