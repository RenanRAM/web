<?php
	$chaves_esperadas = ['nome','email','data','fone','msg'];//chaves esperadas a serem recebidas pelo post
	define('TAMANHO_TEXTO_MAX',78);
	$datatest = '/^\d{4}\-\d{2}\-\d{2}T\d{2}\:\d{2}$/';//expressão regular para testar a data
	$emailtest = '/^[\w\-\.]+@[\w\-\.]+\.[\w\-\.]+$/';// || testar o email
	
	$verificar = function($chaves,$posts){//verifica se as chaves estão certas
		if(count($chaves) != count($posts)){
			return false;
		}
		foreach($chaves as $valor){
			if(!array_key_exists($valor, $posts)){
				return false;
			}else if(($posts[$valor] == '') || !is_string($posts[$valor])){
				return false;
			}
		}
		return true;
	};
	//strip_tags('a');
	//trim()
	$postsVerificados = $_POST;

	$verificar_valores = function(&$posts) use ($datatest,$emailtest){//verifica e corrige os valores
		if(!preg_match($datatest, $posts['data']) || !preg_match($emailtest, $posts['email'])){
			return false;
		}
		foreach ($posts as $key=>$texto) {//verifica o tamanho das strings
			if(strlen($texto) > TAMANHO_TEXTO_MAX){
				if($key === 'msg'){//corrige a mensagem
					$posts['msg'] = substr($posts['msg'],0,TAMANHO_TEXTO_MAX);
				}else{
					return false;
				}
			}
		}
		if(!preg_match('/\d/',$posts['fone'])){//testar se possui algum número, fone não é tão importante, apenas este teste é o suficiente
			return false;
		}
		$posts['nome'] = strip_tags(trim($posts['nome']));//normalizar
		$posts['fone'] = strip_tags(trim($posts['fone']));
		$posts['msg'] = strip_tags(trim($posts['msg']));
		return true;
	};
	

	//primeiro executar $verificar e, se der certo, executar $verificar_valores
	if($verificar($chaves_esperadas,$_POST)){
		echo $verificar_valores($postsVerificados)?'Certo':'Errado';
		echo "  ".$postsVerificados['msg'];
	}

?>