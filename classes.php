<?php
	
	class MySql{

		private static $pdo;

		public static function conectar(){
			if(self::$pdo == null){
				try{
					self::$pdo = new PDO('mysql:host='.HOST.';dbname='.DATABASE,USER,PASSWORD,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
					self::$pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
				}catch(Exception $e){
					echo '<h2>Erro ao conectar no banco de dados SQL</h2>';
				}
			}

			return self::$pdo;
		}
	}

	class getControl{

		private $status = 0;
		private $padrao = 'paginas/inde.php';
		private $ark = '';

		public function __construct($rotaPadrao = ''){
			if($rotaPadrao != ''){
				$this->padrao = $rotaPadrao;
			}
			$this->ark = $this->padrao;
		}

		public function rota($getc,$arquivo,$getvalor = null){
			$valor = 0;
			if($this->status != 1){
				if(($getc == '' || $getc == 0) && $_SERVER['QUERY_STRING'] == ''){
					$this->status = 1;
					$this->ark = 'paginas/'.$arquivo;
					return true;
				}else if(isset($_GET[$getc])){
					$valor = $_GET[$getc];
					if($getvalor != null){
						if($getvalor == $valor){
							$this->ark = 'paginas/'.$arquivo;
							$this->status = 1;
							return true;
						}
					}else{
						$this->ark = 'paginas/'.$arquivo;
						$this->status = 1;
						return true;
					}		
				}
			}
			return false;
		}

		public function proteger($arr,$func = 0){
			if(is_callable($func)){
				if(is_array($arr)){
					$rota = in_array(true, $arr);
				}
				$resultado = $func();
				if(!is_bool($resultado)){
					return false;
				}
				if(!$resultado && $rota){
					//função de proteção não foi aprovada e existe uma rota no array, precisa resetar a rota para o padrão
					$this->ark = $this->$padrao;
				}else if($resultado && $rota){
					//tudo certo, pode continuar
					return true;
				}
			}
			return false;
		}

		public function ver(){
			return $this->ark;
		}
	}

?>