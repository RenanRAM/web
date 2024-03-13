const titulo_aceitar = "Marcar horário: ?data? ?hora? para ?nome?";
const titulo_recusar = "Recusar horário: ?data? ?hora? de ?nome?";
const frase_aceitar = "?nome?, sua solicitação de horário: ?data? ?hora? foi aceita!";
const frase_recusar = "?nome?, infelizmente este horário: ?data? ?hora? não está mais disponível.";

let caixa_email = document.querySelector('div.email');
let caixa_email_aberta = caixa_email.computedStyleMap().get('display').toString() == 'block';
let email_atual_aceito = false;

//pegar informações nos botões
document.querySelectorAll('strong.botoes').forEach(ele=>{
	ele.addEventListener('click', function(evento){
		evento.stopPropagation();
		let pai = this.parentNode;
		let cliente_id = pai.getAttribute('cliente_id');
		let nome = pai.getAttribute('cliente_nome');
		let hora = pai.getAttribute('cliente_hora');
		let data = pai.getAttribute('cliente_data');
		let aceitou = this.hasAttribute('aceitar');
		abrirCaixaEmail(aceitou,nome,data,hora,cliente_id);
	});
});

//adicionar evento no botão de cancelar
caixa_email.querySelector('div.cancelar').addEventListener('click',()=>{
	fecharCaixaEmail();
});

//adicionar evento no botão de enviar
caixa_email.querySelector('div.enviar-email').addEventListener('click',()=>{
	if(caixa_email_aberta){
		enviarEmail(obterConteudoEmail(),caixa_email.getAttribute('id_cliente'),email_atual_aceito);//email_texto,id_cliente,aceitou
	}else{
		alert('Erro, caixa de email não está aberta');
	}
});

function abrirCaixaEmail(aceitou,nome,data,hora,id){
	caixa_email.setAttribute('id_cliente',id);
	let titulo = caixa_email.querySelector('h1');
	let textarea = caixa_email.querySelector('textarea');
	let texto_titulo = '';
	let texto_textarea = '';
	email_atual_aceito = aceitou;
	if(aceitou){
		texto_titulo = titulo_aceitar;
		texto_textarea = frase_aceitar;
	}else{
		texto_titulo = titulo_recusar;
		texto_textarea = frase_recusar;
	}
	texto_titulo = texto_titulo.replace('?data?',data);
	texto_titulo = texto_titulo.replace('?hora?',hora);
	texto_titulo = texto_titulo.replace('?nome?',nome);
	texto_textarea = texto_textarea.replace('?nome?',nome);
	texto_textarea = texto_textarea.replace('?data?',data);
	texto_textarea = texto_textarea.replace('?hora?',hora);
	titulo.innerText = texto_titulo;
	//depois de editado, o textarea não muda seu conteudo a pelo .innerText... somente por .value
	textarea.value = texto_textarea;
	caixa_email.attributeStyleMap.set('display','block');
	caixa_email.attributeStyleMap.set('animation','abrirCaixaEmail 500ms ease-in 0s 1 normal both running');
	atualizarCaixaEmail();
}

function fecharCaixaEmail(){
	caixa_email.attributeStyleMap.set('display','block');
	caixa_email.attributeStyleMap.set('animation','fecharCaixaEmail 400ms ease-in 0s 1 normal forwards running');
	atualizarCaixaEmail();
}

function atualizarCaixaEmail(){
	caixa_email_aberta = caixa_email.computedStyleMap().get('display').toString() == 'block';
}

function obterConteudoEmail(){
	let cont = caixa_email.querySelector('textarea').value;
	//executar algumas validações e trim
	return cont;
}

function enviarEmail(email_texto,id_cliente,aceitou){
	let formulario = new FormData();
	formulario.append('email_texto',email_texto);
	formulario.append('aceitou',aceitou);
	formulario.append('id_cliente',id_cliente);
	enviar(formulario,()=>{removerAnimado(id_cliente)});
}

function removerAnimado(id){
	let elemento = document.querySelector('p[cliente_id="'+id+'"]');
	elemento.attributeStyleMap.set('bottom','-700px');
	elemento.attributeStyleMap.set('height','0px');
	elemento.attributeStyleMap.set('border','0');
	fecharCaixaEmail()
	setTimeout(()=>{elemento.remove();},700);
}

function enviar(dados,sucFunc = null,errFunc = null){
	let xhr = new XMLHttpRequest();
	xhr.open("POST", "ajaxPHP/controladorEmail.php", true);
	xhr.onreadystatechange = function() {
		if (xhr.readyState == 4 && xhr.status == 200) {
			console.log('Resposta do ajax: '+xhr.response);
			if(xhr.response = 'tudo certo' || true){//validar alguma resposta
				if(sucFunc!=null){
					sucFunc();
				}
			}
		}
	};
	xhr.onerror = function(){
		alert("Ocorreu um erro de comunicação com o servidor");
	}
	xhr.send(dados);
}
