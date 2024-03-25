let formulario = document.querySelector('form');
let caixaResposta = document.querySelector('div.caixaResposta');
let btnEnviar = document.querySelector('button.btn-enviar');
let inputData =  document.getElementById('in_data');
let artInfo = document.querySelector('article.info');
const mascara = '(2)5-4';
const aviso_preenchimento_incorreto = "Preencha corretamente os campos destacados";
const cor_marcar = 'red';
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
	formulario.querySelectorAll('input').forEach(ele=>{//resetar os campos marcado
		ele.style.borderColor='';
	});
	let formdata = new FormData(formulario);//pegando o formulário do <form>
	let tudo_certo = true;
	let problemas = [];
	//expressões regulares para validar umas coisas
	let datatest = /^\d{4}\-\d{2}\-\d{2}T\d{2}\:\d{2}$/;
	let emailtest = /^[\w\-\.]+@[\w\-\.]+\.[\w\-\.]+$/;
	formdata.forEach(function(valor,chave){//cria um array contendo os campos com problemas
		let testeProblema = false;
		switch (chave){
		case 'email':
			testeProblema = !emailtest.test(valor);
		break;
		case 'data':
			testeProblema = !datatest.test(valor);
		break;
		default:
			testeProblema = valor == '';
		}
		if(testeProblema){
			problemas.push(chave);
			tudo_certo = false;
		}
	});
	if(tudo_certo){//verifica se tem algum problema
		//não temos problemas, porém temos que verificar tudo de novo no backend
		if(artInfo.querySelector('p[aviso]') != null){artInfo.querySelector('p[aviso]').remove();}
		let xhr = new XMLHttpRequest();
		xhr.open("POST", 'ajaxPHP/formContato.php', true);
		//xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		xhr.onreadystatechange = function() {
			if (xhr.readyState === 4 && xhr.status === 200) {
				console.log(xhr.responseText); //resposta do servidor
			}
		};
		xhr.send(formdata);
	}else{
		//temos problemas
		problemas.forEach((val)=>{//marca os campos com problema
			formulario.querySelector('input[name="'+val+'"]').style.borderColor = cor_marcar;
		});
		if(artInfo.querySelector('p[aviso]')== null){//mostr um aviso caso não tenha
			let comentario = document.createElement('p');
			comentario.setAttribute('aviso','');
			comentario.textContent= aviso_preenchimento_incorreto;
			artInfo.querySelector('p:first-of-type').insertAdjacentElement('afterend',comentario);
		}
	}
});

document.querySelector('input[name="fone"]').addEventListener('input',function(){//aplicação de uma máscara
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
				fim = true;//se o laço 'for' acabar naturalmente quer dizer que acabou a string da mascara
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
	principal:
	for(i_gab = 0; i_gab < tam_gab;i_gab++){//percorrer gabarito
		if(!(typeof gabarito[i_gab] === 'number')){
			aplicado += gabarito[i_gab];
		}else{
			aux = 0;
			for(;i_txt<tam_txt;i_txt++){
				if(aux == gabarito[i_gab]){//verificar se já foi tudo preenchido
					break;
				}
				aplicado+=texto.charAt(i_txt);
				aux++;
			}
			if(i_txt==tam_txt){// o texto acabou, sair de tudo
				break principal;
			}
		}
	}
	return aplicado;
}

function animarForm(texto = 'Enviado'){
	let novaDivCont = document.createElement('div');
	let novaDiv = document.createElement('div');
	let fraseP = document.createElement('p');
	fraseP.textContent=texto;
	novaDivCont.classList.add('animaCont');
	novaDiv.classList.add('anima');
	novaDivCont.appendChild(fraseP);
	let wform = formulario.clientWidth;
	let hform = formulario.clientHeight;
	//console.log(wform);
	formulario.attributeStyleMap.set('width',wform+"px");
	formulario.attributeStyleMap.set('margin','0');
	formulario.attributeStyleMap.set('border','0');
	artInfo.insertBefore(novaDivCont,formulario);
	novaDiv.appendChild(formulario);
	novaDivCont.appendChild(novaDiv);
	novaDiv.attributeStyleMap.set('width',wform+"px");
	novaDiv.attributeStyleMap.set('height',hform+"px");
	novaDiv.attributeStyleMap.set('animation','encolherForm 1300ms ease forwards');
}