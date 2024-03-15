//precisa de agenda-base.js

//adicionar evento ao botões de finalizar
document.querySelectorAll('strong.botoes').forEach(ele=>{
	ele.addEventListener('click', function(evento){
		evento.stopPropagation();
		let pai = this.parentNode;
		let cliente_id = pai.getAttribute('cliente_id');
		let nome = pai.getAttribute('cliente_nome');
		let hora = pai.getAttribute('cliente_hora');
		let data = pai.getAttribute('cliente_data');
		abrirConfirma('Deseja finalizar o atendimento de '+nome+', marcado para a data '+data+' | '+hora+' ?',()=>{
			enviar('ajaxPHP/controladorAgendaFinalizar.php',gerarFormSingle('finalizar',cliente_id),(respostaAjax)=>{
				console.log(respostaAjax);
			},null);
		},()=>{

		});
	});
});

function gerarFormSingle(cod,dado){
	let formulario = new FormData();
	formulario.append(cod,dado);
	return formulario;
}
//abrir caixa de confirmação
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
	},{'once':true});
	btn_nao.addEventListener('click',()=>{
		if(nao instanceof Function){
			nao();
		}
		fundo.attributeStyleMap.set('display','none');
	},{'once':true});
}