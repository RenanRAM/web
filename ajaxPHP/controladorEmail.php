<?php
	include('../config.php');
	include('../classes.php');

	proteger(2);
	$texto = $_POST['email_texto'];
	$aceitou = $_POST['aceitou'] == 1 || $_POST['aceitou'] == 'true';
	$id_cliente = $_POST['id_cliente'];

	//recuperar os dados do cliente com base neste id e enviar um email para ele, tambem retornar o status via echo

	echo "email enviado, tudo certo";
	//ou
	echo "Algo deu errado";

?>