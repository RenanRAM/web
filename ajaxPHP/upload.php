<?php
	include('../config.php');
	include('../classes.php');
?>

<?php
	proteger(2);
	$nomeP = 'catsImg';
	$catID = json_decode($_POST['idCategoria']);
	$sql = MySql::conectar()->prepare("SELECT count(id) as 'qnt' FROM `imgs-categorias`");
	$sql->execute();
	$quantidade = $sql->fetch()['qnt'];
	$qinicial = $quantidade;
	foreach ($_FILES as $key => $value) {
		if(carregarImagem($value,$nomeP.$quantidade)){
			$ext[$quantidade] = pathinfo($value['name'], PATHINFO_EXTENSION);
			$quantidade++;
		}
	}
	if($quantidade == $qinicial){
		die('Nenhum upload feito');
	}
	$query = '';
	for($q = $qinicial; $q<$quantidade; $q++){
		$query .="(null,'".$nomeP.$q.'.'.$ext[$q]."',".$catID."),";
	}
	if($query !== ''){
		$query = substr($query, 0,-1);
		$sql = MySql::conectar()->prepare("INSERT INTO `imgs-categorias` VALUES".$query);
		$sql->execute();
	}else{
		echo 'Erro: Sem imagens para upload, arquivo ajaxPHP/upload.php linha 27';
	}

	

?>