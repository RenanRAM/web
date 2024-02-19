<?php
	//comando para configurações do php
//ini_set(varname, newvalue);
$cor = '#000000';
	if(isset($_GET['acao'])){
		$cor = $_GET['cor'];
	}
?>

<form method="get">
	<input type="color" name="cor" value="<?php echo $cor; ?>">
	<input type="color" name="cor2" value="<?php echo $cor; ?>">
	<input type="submit" name="acao" value="enviar">
</form>

<p popover id="id1">Texto que aparece</p>

<input type="button" value="Clicar" popovertarget="id1">