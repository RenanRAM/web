<?php
	include('../config.php');
	include('../classes.php');
?>
<?php
	proteger(2);
	$dadosJSON = file_get_contents('php://input');
	$dados = json_decode($dadosJSON, true);
	//print_r($dados);

	$catid = $dados['catid'];
	$dados = $dados['data'];
	//0 = imgId
	//1 = catId
	$sql = MySql::conectar()->prepare("SELECT id FROM `imgs-categorias` WHERE catid = ?");
	$sql->execute([$catid]);
	$sql = $sql->fetchAll();
	$dadosAtual = array_column($sql,'id');
	$dadosEdit = array_column($dados,0);
	$dadosExcluidos = array_diff($dadosAtual, $dadosEdit);//colocar carid = 0 para dizer que a imagem está livre
	foreach ($dadosExcluidos as $value) {
		if($catid == 0){
			$file = MySql::conectar()->prepare("SELECT nome_img FROM `imgs-categorias` WHERE id = ?");
			$file->execute([$value]);
			$file = $file->fetch()['nome_img'];
			if(file_exists('../imagens/'.$file)){
				unlink('../imagens/'.$file);
			}
			$sql = MySql::conectar()->prepare("DELETE FROM `imgs-categorias` WHERE id = ?");
			$sql->execute([$value]);
		}else{
			$sql = MySql::conectar()->prepare("UPDATE `imgs-categorias` SET catid = 0 WHERE id = ?");
			$sql->execute([$value]);	
		}

	}
	foreach ($dados as $value) {
		$sql = MySql::conectar()->prepare("UPDATE `imgs-categorias` SET catid = ? WHERE id = ?");
		$sql->execute([$value[1],$value[0]]);
	}

?>