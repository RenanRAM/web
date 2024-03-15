<?php
	include('../config.php');
	include('../classes.php');

	proteger(2);
	$id_cliente = $_POST['finalizar'];

	//recuperar os dados do cliente com base neste id e finalizar o atendimento marcado na agenda
	echo "Atendimento de ?pegar o nome do cliente com id: ".$id_cliente."? finalizado";

?>