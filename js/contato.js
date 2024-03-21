let formulario = document.querySelector('form');
let caixaResposta = document.querySelector('div.caixaResposta');
let btnEnviar = document.querySelector('header');
let inputData =  document.getElementById('in_data');
const mascara = '(2)5-4';
let imask = null;

//setTimeout(()=>{formulario.submit();},5000);

window.addEventListener('load', function(){
	//setar data mínima
	let dataAtual = new Date();
	let ano = dataAtual.getFullYear();
	let mes = String(dataAtual.getMonth() + 1).padStart(2, '0'); // Adiciona um zero à esquerda se necessário
	let dia = String(dataAtual.getDate()).padStart(2, '0');
	let hora = String(dataAtual.getHours()).padStart(2, '0');
	let minuto = String(dataAtual.getMinutes()).padStart(2, '0');

	let dataHoraMinima = ano + '-' + mes + '-' + dia + 'T' + hora + ':' + minuto;
	inputData.setAttribute("min", dataHoraMinima);

	//gerar gabarito para máscara
	imask = interpretarMask(mascara);
});

btnEnviar.addEventListener("click", function(evento) {
	console.log('Disparando');
	//evento.preventDefault(); // Impede o envio padrão do formulário

	let xhr = new XMLHttpRequest();
	xhr.open("POST", 'ajaxPHP/formContato.php', true);
	//xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

	xhr.onreadystatechange = function() {
		if (xhr.readyState === 4 && xhr.status === 200) {
			console.log(xhr.responseText); //resposta do servidor
		}
	};

	xhr.send(new FormData(formulario));
});

document.querySelector('input[name="fone"]').addEventListener('input',function(){
	this.value = aplicarMask(imask,this.value);
});

function interpretarMask(mask){//funcionando
	if(typeof mask === "string"){
		let tam = mask.length;
		let vetor = [];
		let aux = '';
		let char = null;
		let char_aux = null;
		let fim = false;
		for(let i = 0;i<tam;i++){
			char = mask.charAt(i);
			if(isNaN(Number(char)) || (char==' ')){//verifica se o caracter não é um número ou é ' '
				//não é um número
				vetor.push(char);
			}else{
				//é um número
				aux = '';
				char_aux = null;
				fim = true;
				for(let a = i;a<tam;a++){
					char_aux = mask.charAt(a);
					if(isNaN(Number(char_aux))){
						i = --a;//decrementar 1, pois o atual não é número
						fim = false;//ainda não acabou a string mask
						break;
					}
					aux += char_aux;
				}
				vetor.push(Number(aux));
				if(fim){
					break;
				}
			}
		}
		return vetor;
	}else{
		return false;
	}
}

function aplicarMask(gabarito,texto_pre){//funcionando
	if(!(Array.isArray(gabarito))){
		return false;
	}
	let texto = texto_pre.replace(/\D/g, '');//remover não números do texto aqui
	if(texto == ''){
		return '';
	}
	let tam_txt = texto.length;
	let tam_gab = gabarito.length;
	let aplicado = '';
	let i_gab = 0;
	let i_txt = 0;
	let aux = 0;
	for(i_gab = 0; i_gab < tam_gab;i_gab++){//percorrer gabarito
		if(!(typeof gabarito[i_gab] === 'number')){
			if(i_txt<tam_txt){//só adiciona um caracter do gabarito se 
				aplicado += gabarito[i_gab];
			}else{
				break;
			}
		}else{
			aux = 0;
			for(;i_txt<tam_txt;i_txt++){
				if(aux == gabarito[i_gab]){//verificar se já foi tudo preenchido
					break;
				}
				aplicado+=texto.charAt(i_txt);
				aux++;
			}
		}
	}
	return aplicado;
}