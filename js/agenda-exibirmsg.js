//adicionar função aos elementos p da lista
document.querySelectorAll('section.lista > p').forEach(ele=>{
	ele.addEventListener('click',function(){
		exibirMsgCompleta(this);
	});
});

//adicionar função a div que mostra a mensagem completa
document.querySelector('section.lista div.msg-completa').addEventListener('click',function(){
	this.attributeStyleMap.set('display','none');
});

function exibirMsgCompleta(elep){
	let top = elep.offsetTop;
	let caixa = document.querySelector('div.msg-completa');
	caixa.textContent = elep.querySelector('msglimit').textContent;
	caixa.attributeStyleMap.set('top',top+'px');
	caixa.attributeStyleMap.set('display','block');
}