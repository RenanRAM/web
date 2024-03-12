
addClick();
addRemove();

document.querySelector('#adiciona i').addEventListener('click',function(){
	document.getElementById('adiciona').style.display = 'none';
	document.querySelector('div.categoria-adicionar').style.display = 'block';
	let texto = document.querySelector('#adiciona textarea').value;
	if(texto != ''){
		document.querySelector('#adiciona textarea').value = '';
		let novaCategoria = document.createElement('div');
		let btn = document.createElement('i');
		btn.className = 'fa fa-times';
		novaCategoria.textContent = texto;
		novaCategoria.classList.add('categoria-single');
		novaCategoria.appendChild(btn);
		let ultimo = document.getElementById('adiciona');
		document.querySelector('div.categoria-container').insertBefore(novaCategoria,ultimo);
		addRemove();
	}
});

document.getElementById('salvar').addEventListener('click',function(){
	let cate = [];

	document.querySelectorAll('div.categoria-single:not(#adiciona)').forEach(ele =>{
		cate.push(ele.textContent.trim());
	});
	let data = JSON.stringify({'categorias':cate});
	enviarJson(data);
});

function addRemove(){
	document.querySelectorAll('div.categoria-single:not(#adiciona)').forEach(ele => {
		ele.querySelector('i').addEventListener('click',function(){
			this.parentNode.remove();
		});
	});
}

function addClick(){
	document.querySelector('div.categoria-adicionar').addEventListener('click',function(){
		document.getElementById('adiciona').style.display = 'block';
		document.querySelector('#adiciona textarea').focus();
		this.style.display = 'none';
	});
}

function enviarJson(dados){

	let xhr = new XMLHttpRequest();
	xhr.open("POST", "ajaxPHP/editar-categorias.php", true);
	xhr.setRequestHeader("Content-Type", "application/json;charset=UTF-8");
	xhr.onreadystatechange = function() {
		if (xhr.readyState == 4 && xhr.status == 200) {
			alert("Enviado/Salvo");
		}
	};
	xhr.send(dados);
}

