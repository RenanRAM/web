<?php
	include('../config.php');
	include('../classes.php');
?>

<?php
	proteger(2);
	$aplicarTrim = function(&$valor,$chave){
		$valor = ucfirst(trim($valor));
	};

	$dadosAtual = MySql::conectar()->prepare("SELECT nome FROM `info_categorias` WHERE nome != ''");
	$dadosAtual->execute();

	$dadosAtual = array_column($dadosAtual->fetchAll(),'nome');

	$dadosJSON = file_get_contents('php://input');
	$dados = json_decode($dadosJSON, true);
	//limpar arrays
	$dadosTrim = $dados['categorias'];
	array_walk($dadosTrim, $aplicarTrim);
	$dadosTrim = array_unique($dadosTrim,SORT_REGULAR);
	array_walk($dadosAtual, $aplicarTrim);
	//agora os arrays não tem expaços em branco nem valors duplicados

	if($dadosTrim !== null){//precisa ser !== pois se receber um array vazio não quer dizer que foi um erro, mas sim que tudo foi excluido
		$dadosEdit = $dadosTrim;
		$dadosNovos = array_diff($dadosEdit, $dadosAtual);//funcionando
		$dadosExcluidos = array_diff($dadosAtual, $dadosEdit);//funcionando
		foreach ($dadosExcluidos as $value){
			$sql = MySql::conectar()->prepare("UPDATE `info_categorias` SET nome = '' WHERE TRIM(nome) = ?");
			$sql->execute([(string) $value]);
			$sql = MySql::conectar()->prepare("UPDATE `imgs-categorias` SET catid = 0 WHERE catid = (SELECT id FROM `info_categorias` WHERE nome = '' LIMIT 1)");
			$sql->execute();
		}
		$disponivel = MySql::conectar()->prepare("SELECT count(nome) AS 'num' FROM `info_categorias` WHERE nome = ''");
		$disponivel->execute();
		$disponivel = (int) $disponivel->fetch()['num'];//número de espaços disponíveis para update
		$dadosNovosUpdate = array_slice($dadosNovos,0,$disponivel);
		$dadosNovosInserir = array_slice($dadosNovos,$disponivel);

		if($dadosNovosInserir != [] && $dadosNovosInserir != null){
			$query = '';
			foreach ($dadosNovosInserir as $value){
				$query .='(null,?),';
				$arr[] = $value;
			}
			$query = substr($query, 0,-1);
			$sql = MySql::conectar()->prepare("INSERT INTO `info_categorias` VALUES".$query);
			$sql->execute($arr);
		}

		if($dadosNovosUpdate != [] && $dadosNovosUpdate != null){
			$ids = MySql::conectar()->prepare("SELECT id FROM `info_categorias` WHERE nome = ''");
			$ids->execute();
			$ids = array_column($ids->fetchAll(),'id');
			if((count($dadosNovosUpdate) <= count($ids)) && array_is_list($dadosNovosUpdate)){
				foreach($dadosNovosUpdate as $chave => $value){
					$sql = MySql::conectar()->prepare("UPDATE `info_categorias` SET nome = ? WHERE id = $ids[$chave]");
					$sql->execute([$value]);
				}
			}else{
				echo 'Erro no update do banco de dados';
			}	
		}
	}
?>