//funções base para todas as agendas
function removerAnimado(id){
	let elemento = document.querySelector('p[cliente_id="'+id+'"]');
	elemento.attributeStyleMap.set('bottom','-700px');
	elemento.attributeStyleMap.set('height','0px');
	elemento.attributeStyleMap.set('border','0');
	fecharCaixaEmail()
	setTimeout(()=>{elemento.remove();},700);
}

function enviar(local = "",dados,sucFunc = null,errFunc = null){
	if(local == ""){
		return false;
	}
	let xhr = new XMLHttpRequest();
	xhr.open("POST", local, true);
	xhr.onreadystatechange = function() {
		if (xhr.readyState == 4 && xhr.status == 200) {
			if(xhr.response = 'tudo certo' || true){//validar alguma resposta
				if(sucFunc!=null){
					sucFunc(xhr.response);
				}
			}
		}
	};
	xhr.onerror = function(){
		alert("Ocorreu um erro de comunicação com o servidor");
	}
	xhr.send(dados);
}