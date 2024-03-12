let total = document.querySelectorAll("div.cat-imgs").length;
let selecionados = 0;
let maior = false;
document.querySelectorAll("div.cat-imgs").forEach(ele => {
	ele.addEventListener('click',function(){
		this.classList.toggle("sele");
		atualizarSelecao();
	});
});

document.querySelectorAll("div.opcoes div p").forEach(ele => {
	ele.addEventListener('click',function(){
		let cat = ele.getAttributeNode("categoria").value;
		let catid = ele.getAttributeNode("catid").value;
		addCategoria(cat,catid);
		liberarTudo();
	});
});

document.getElementById("selecionados").addEventListener('click',function(){
	if(selecionados < total){
		selecionarTudo();
	}else{
		liberarTudo();
	}
	atualizarSelecao();
});

document.getElementById("removerSelecao").addEventListener('click',function(){
	if(selecionados == 0){
		removerCategoria();
	}else{
		removerSelecionados();
		atualizarSelecao();
	}
});

document.getElementById("salvar").addEventListener('click',function(){
	let imgdata = [];
	document.querySelectorAll("div.cat-imgs").forEach(ele => {
		imgdata.push([ele.getAttributeNode("imgid").value,ele.getAttributeNode("catid").value]);
	});
	let data = imgdata;
	let idCat = document.querySelector('header.edicao').getAttributeNode("catid").value;
	enviarJson(JSON.stringify({'data':data,'catid':idCat}));
});

document.getElementById("arquivosInput").addEventListener('change',function(){
	let tamanho = this.files.length;
	let arqs = this.files;
	if(tamanho > 0){
		if(tamanho < 6){
			let formData = new FormData();
			for(let indice in arqs){
				formData.append('arquivo'+indice, arqs[indice]);
			}
			let idCat = document.querySelector('header.edicao').getAttributeNode("catid").value;
			formData.append('idCategoria', JSON.stringify(idCat));
			enviar(formData);
		}else{
			alert('Máximo 5 arquivos para cada upload');
		}
	}
});

document.querySelector('button.tamanho').addEventListener('click',alterarTamanho);

function selecionarTudo(){
	document.querySelectorAll("div.cat-imgs").forEach(ele => {
		ele.classList.add('sele');
	});
}

function liberarTudo(){
	document.querySelectorAll("div.cat-imgs").forEach(ele => {
		ele.classList.remove('sele');
		atualizarSelecao();
	});
}

function atualizarSelecao(){
	total = document.querySelectorAll("div.cat-imgs").length;
	selecionados = document.querySelectorAll("div.cat-imgs.sele").length;
	document.getElementById("selecionados").textContent = "Selecionados("+selecionados+")";
}

function removerSelecionados(){
	document.querySelectorAll("div.cat-imgs.sele").forEach(ele => {
		ele.remove();
	});
}

function addCategoria(categoria,catid){
	document.querySelectorAll("div.cat-imgs.sele").forEach(ele => {
		ele.getAttributeNode("catid").value = catid;
		let novaCategoria = document.createElement('div');
		novaCategoria.textContent = categoria;
		novaCategoria.classList.add('cat-titulo');
		let divAtual = ele.querySelectorAll("div.cat-titulo");
		if(divAtual.length>0){
			ele.querySelectorAll("div.cat-titulo").forEach(div1=>{
				div1.textContent = categoria;
			});
		}else{
			ele.prepend(novaCategoria);
		}
	});
}

function removerCategoria(){
	document.querySelectorAll("div.cat-imgs").forEach(ele => {
		ele.querySelectorAll("div.cat-titulo").forEach(div1=>{
			div1.remove();
		});
	});
}

function enviarJson(dados){
	let xhr = new XMLHttpRequest();
	xhr.open("POST", "ajaxPHP/edicao-imgs.php", true);
	xhr.setRequestHeader("Content-Type", "application/json;charset=UTF-8");
	xhr.onreadystatechange = function() {
		if (xhr.readyState == 4 && xhr.status == 200) {
			alert("Enviado/Salvo");
			location.reload();
		}
	};
	xhr.send(dados);
}

function enviar(dados){
	let xhr = new XMLHttpRequest();
	xhr.open("POST", "ajaxPHP/upload.php", true);
	xhr.onreadystatechange = function() {
		if (xhr.readyState == 4 && xhr.status == 200) {
			alert("Enviado/Salvo");
			location.reload();
		}
	};
	xhr.send(dados);
}

function alterarTamanho(){
	let container = document.querySelector('div.container-imgs');
	let botao = document.querySelector('button.tamanho');
	if(maior){
		container.classList.remove('maior');
		botao.textContent = '+';
		maior = false;
	}else{
		container.classList.add('maior');
		botao.textContent = '-';
		maior = true;
	}
}