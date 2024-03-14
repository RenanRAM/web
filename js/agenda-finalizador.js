document.querySelectorAll('strong.botoes').forEach(ele=>{
	ele.addEventListener('click', function(evento){
		evento.stopPropagation();
		let pai = this.parentNode;
		let cliente_id = pai.getAttribute('cliente_id');
		let nome = pai.getAttribute('cliente_nome');
		let hora = pai.getAttribute('cliente_hora');
		let data = pai.getAttribute('cliente_data');
		abrirConfirma('Deseja finalizar o atendimento de '+nome+', marcado para a data '+data+' | '+hora+' ?');
	});
});

function enviar(dados,sucFunc = null,errFunc = null){
	let xhr = new XMLHttpRequest();
	xhr.open("POST", "ajaxPHP/controladorAgendaFinalizar.php", true);
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


function abrirConfirma(msg = '',sim = null,nao= null){
	let fundo = document.querySelector('div.confirma-fundo');
	fundo.attributeStyleMap.set('display','block');
	let janela = fundo.querySelector('div.confirma-janela');
	//colocar mensagem
	janela.querySelector('article p').textContent = msg;
	let btn_nao = janela.querySelector('div.btn-confirma div.nao');
	let btn_sim = janela.querySelector('div.btn-confirma div.sim');
	btn_sim.addEventListener('click',()=>{
		if(sim instanceof Function){
			sim();
		}
		fundo.attributeStyleMap.set('display','none');
	});
	btn_nao.addEventListener('click',()=>{
		if(nao instanceof Function){
			nao();
		}
		fundo.attributeStyleMap.set('display','none');
	});
}