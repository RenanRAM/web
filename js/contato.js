let formulario = document.querySelector('form');
let caixaResposta = document.querySelector('div.caixaResposta');
let btnEnviar = document.querySelector('header');
let inputData =  document.getElementById('in_data');

//setTimeout(()=>{formulario.submit();},5000);

window.addEventListener('load', function(){

	let dataAtual = new Date();
	let ano = dataAtual.getFullYear();
	let mes = String(dataAtual.getMonth() + 1).padStart(2, '0'); // Adiciona um zero à esquerda se necessário
	let dia = String(dataAtual.getDate()).padStart(2, '0');
	let hora = String(dataAtual.getHours()).padStart(2, '0');
	let minuto = String(dataAtual.getMinutes()).padStart(2, '0');

	let dataHoraMinima = ano + '-' + mes + '-' + dia + 'T' + hora + ':' + minuto;
	inputData.setAttribute("min", dataHoraMinima);
});

btnEnviar.addEventListener("click", function(evento) {
	console.log('Disparando');
	evento.preventDefault(); // Impede o envio padrão do formulário

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