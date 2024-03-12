<?php
	define('TITULO_SITE', 'Móveis Cleusa');
	define('NOME_EMPRESA', 'Móveis Cleusa');
	define('PATH','http://localhost/sitecleusa/');
	define('PATH_MIN','sitecleusa');
	define('BASE_DIR_IMGS',__DIR__.'/imagens/');
	define('EXT_ACEITAS',['png','jpg','jpeg','webp']);//tipos de imagens aceitas
	define('TAMANHO_MAXIMO',8000000);//tamanho máximo de arquivos para upload
	define('IMAGEM_E2_1','Foto_perfil_E2img1');//primeira imagem de E2
	
	//tags meta
	define('METATAGS',<<<META
	<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="author" content="Renan Werle Ruschel">
		<meta name="keywords" content="moveis projetos sob medida ambientes salas cozinhas quartos banheiros cleusa casa apartamento planejados">
		<meta name="description" content="criacao de ambientes e moveis sob medida">
		<meta name="language" content="pt-BR">
	META);

	define('HOST','localhost');
	define('USER','root');
	define('PASSWORD','');
	define('DATABASE','sitecleusa');


	define('HORA_PERMITIDA','22:00');//formato hh:mm exemplo: 13:47
	define('TEMPO_PERMITIDO_MAX','24');//em horas formato int exemplo: 2
	date_default_timezone_set('America/Sao_Paulo');






	//configurações de sessão segura
	session_name('saves_site_config');
	session_start();
	session_regenerate_id();

	/*funções*/

	function verificarExtensao($ext){
		return in_array(strtolower($ext), EXT_ACEITAS);
	}

	function redirecionarJSpath($val = ''){
		echo "<script>window.location.pathname = '".PATH_MIN."/".$val."';</script>'";
	}

	function redirecionarJS($val = ''){
		echo "<script>window.location.href = window.location.pathname+'".$val."';</script>'";
	}

	function carregarImagem($arq,$nome){
		$tmp_name = $arq['tmp_name'];
		$nomeSafe = removerCaracteresEspeciais($nome);
		$ext = pathinfo($arq['name'], PATHINFO_EXTENSION);
		if((!verificarExtensao($ext)) || ($arq['size'] > TAMANHO_MAXIMO) || ($nomeSafe == '')){
			return false;
		}	
		return move_uploaded_file($tmp_name,BASE_DIR_IMGS.$nomeSafe.'.'.$ext);
	}

	function isolarChaves($sqldata){
		$dados = array_reduce($sqldata, function($total,$atual){//cada chave de dados agora é uma linha do banco de dados
		$total[$atual['nome']] = $atual['texto'];
			return $total;
		});
		return $dados;
	}

	function removerCaracteresEspeciais($texto){
		return preg_replace(['/[\\\<\>\:\"\/\|\?\*\']/i','/\./'],['','-'], $texto);
	}

	function verificarChave($chave){//verifica a chave de acesso
		if($chave != ''){
			$sql = MySql::conectar()->prepare("SELECT hash FROM `info_login` WHERE nome = 'chave_login'");
			$sql->execute();
			$hash = $sql->fetch();
			return password_verify($chave,$hash['hash']);
		}	
	}
	
	function verificarTok(){//verifica token de acesso da sessão
		if(isset($_SESSION['tok'])){
			if($_SESSION['tok'] != ''){
				$sql = MySql::conectar()->prepare("SELECT hash FROM `info_login` WHERE nome = 'tok'");
				$sql->execute();
				$hash = $sql->fetch();
				return hash_equals($hash['hash'],crypt($_SESSION['tok'],$hash['hash']));
			}
		}
		return false;
	}

	function verificarHora(){//verifica se está nos limites da hora permitida
		$dataAtual = new DateTime();
		$dataP = DateTime::createFromFormat('H:i',HORA_PERMITIDA);
		$dif = $dataAtual->diff($dataP);
		//$doze = new DateInterval("PT12H");
		$difV = ($dif->h*60*60)+($dif->i*60)+($dif->s);
		//$dozeV = ($doze->h*60*60)+($doze->i*60)+($doze->s);
		if($dif->invert == 0){
			$difV -= 24*60*60;
		}
		if($dif->invert == 1 || $difV < 0){
			//está dentro da hora permitida, verificar se o acesso ainda pode ser feito
			$interv = new DateInterval("PT".TEMPO_PERMITIDO_MAX."H");
			$intervV = ($interv->h*60*60)+($interv->i*60)+($interv->s);
			if(abs($difV)<=$intervV){
				return true;
			}
		}
		return false;
	}

	function gerarTok(){//gera um token de acesso que pode ser verificado depois
		$pos = str_split('./0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz');
		$chaves = array_rand($pos,6);
		$num = $pos[$chaves[0]].$pos[$chaves[1]];
		$presalt = $pos[$chaves[2]].$pos[$chaves[3]].$pos[$chaves[4]].$pos[$chaves[5]];
		if($num == '..')
			$num = '/.';
		$salt = '_'.$num.'..'.$presalt;
		$id = uniqid();
		$tok = crypt($id,$salt);
		if($tok != ''){
			$_SESSION['tok'] = $id;
			$sql = MySql::conectar()->prepare("UPDATE `info_login` SET hash = ? WHERE nome = 'tok'");
			$sql->execute([$tok]);
		}
	}

	function sair($f = null){
		session_destroy();
		$sql = MySql::conectar()->prepare("UPDATE `info_login` SET hash = 'expirado' WHERE nome = 'tok'");
		$sql->execute();
		if(is_callable($f)){
			$f();
		}
		die('Sessão encerrada');
	}

	function proteger($tipo = 0){

		switch ($tipo){
			case 0:
				if(verificarTok()){
					if(!verificarHora()){
						sair(function(){
							redirecionarJS();
						});	
					}
				}else{
					redirecionarJS('?login');
					die();
				}
				break;
			case 1:
				if(!verificarHora()){
					redirecionarJS();
					die();
				}
				break;
			case 2:
				if(!verificarTok()){
					die();
				}
				break;
			default:
				redirecionarJS();
				break;
		}
	}

	function painelNavegacao(){
		return '<div class="navegacao">
			<h3>Painel de edição</h3>
			<a class="sair" href="'.PATH.'index.php?sair">Sair</a>
			<br/>
			<a href="'.PATH.'?pgf=edicao-geral">Geral</a>
			<a href="'.PATH.'?pgf=editar-categorias">Categorias</a>
			<a href="'.PATH.'?pgf=imgs-home">Imagens</a>
		</div><!--navegacao-->';
	}

	function smartEscolha($dif = 0){
		$sql = MySql::conectar()->prepare("SELECT COUNT(catid) AS 'total' FROM `imgs-categorias` WHERE catid != ?");
		$sql->execute([$dif]);
		$total = $sql->fetch()['total'];
		if($total < 1){
			return false;
		}else if($total > 4){
			$total = 4;
		}
		$data = $sql->fetchAll();
		$sql = MySql::conectar()->prepare("SELECT COUNT(id) AS 'total', catid FROM `imgs-categorias` WHERE catid != ? GROUP BY catid");
		$sql->execute([$dif]);
		$num = $sql->fetchAll();//$num[total] = numero de imgs
		$n = $num;
		$cats = [];//array com as categorias ativas;
		foreach ($num as $key => $value) {
			$n[$key]['select'] = 0;//[select] = número de fotos selecionadas neste catid
			$cats[$key] = $value['catid'];
		}

		$soma = function($data){//soma o total de imagens selecionadas
			$soma = 0;
			foreach ($data as $value){
				$soma += $value['select'];
			}
			return $soma;
		};
		$max = count($cats);//numero de categorias
		$sec = 0;//contador de segurança do while
		$catEsc = $cats[(intval(date('j')) % $max)];//categoria escolhida como prioridade
		
		$ref = array_search($catEsc, $cats);//key para a categoria escolhida como prioridade
		if($ref === false){
			return false;//algo deu errado
		}
		$ultCat = $ref; //próxima key de categoria a ser incrementada
		
		if($max < 1){
			return false;//precisa ter no mínimo 1
		}
		while(($soma($n) < $total) && ($sec < 20)){

			if($n[$ultCat]['select'] < $n[$ultCat]['total']){
				$n[$ultCat]['select']++;
			}
			$ultCat++;
			if($ultCat > ($max -1)){
				$ultCat -=$max;
			}
			$sec++;//contador de segurança
		}
		$escolhidos = array_reduce($n,function($total,$atual){
			$total[] = ['catid' => $atual['catid'],'select' => $atual['select']];
			return $total;
		});
		$nomesFinal = [];
		foreach ($escolhidos as $value) {
			$sql = MySql::conectar()->prepare("SELECT `imgs-categorias`.`nome_img`, `info_categorias`.`nome` FROM `imgs-categorias` INNER JOIN `info_categorias` ON (`info_categorias`.`id` = `imgs-categorias`.`catid`) WHERE catid = ? LIMIT ?");
			$sql->bindParam(1, $value['catid'], PDO::PARAM_INT);
			$sql->bindParam(2, $value['select'], PDO::PARAM_INT);
			$sql->execute();
			$sql = $sql->fetchAll();
			foreach ($sql as $valor) {
				$img = $valor['nome_img'];
				$nomeCat = $valor['nome'];
				$nomesFinal[] = ['img' => $img, 'categoria' => $nomeCat];
			}
		}
		return $nomesFinal;
	}


?>