$(function(){

	let imgAtual = 0;

	$('.selecao button').click(mostrarInput);
	$('.selecao button').on('input',mostrarInput);
	$('.selecao img').eq(imgAtual).css('display','block');

	$('.selecao button').click(function(){
		imgAtual = $(this).index();
		$('.selecao img').hide();
		$('.selecao img').eq(imgAtual).css('display','block');
	})

	function mostrarInput(){
		imgAtual = $(this).index();
		let textobtn = $(this).find('textarea').val();
		$('label.label-input-file').hide();		
		if(textobtn != ''){
			$('label.label-input-file').eq(imgAtual).css('display','block');
			$('label.label-input-file p').eq(imgAtual).text('Carregar imagem para: '+textobtn);
		}
	}

	apagaTemp();

	function apagaTemp(){
		setTimeout(function(){
			$('[temporario]').fadeOut(900);
		},3000);
	}

	$('.selecao .img-inputs input[type=file]').on('change',function(event) {
		let arquivo = event.target.files[0];
		let selecionado = $(this).parent().index();
		let preview = $('.selecao img').eq(selecionado);
		if (arquivo) {
			let leitor = new FileReader();
			leitor.onload = function(e){
				preview.attr('src', e.target.result);
			}
			leitor.readAsDataURL(arquivo);
		}else{
			preview.attr('src', 'safe.png');
		}
	});

	$('.E2 label.label-input-file-E2').on('change',function(event) {
		let arquivo = event.target.files[0];
		let preview = $('.E2 img.foto-perfil');
		if(arquivo){
			let leitor = new FileReader();
			leitor.onload = function(e) {
				preview.attr('src', e.target.result);
			}
			leitor.readAsDataURL(arquivo);
		}else{
			preview.attr('src', 'safe.png');
		}
	});

	//controle de tempo com input range
	let labelTempo = document.querySelector('label[for=controle-tempo]');
	let inputTempo = document.getElementById('controle-tempo');
	let tempoSlide = inputTempo.value;
	labelTempo.textContent = 'Tempo de troca de slide: '+tempoSlide+' s';
	inputTempo.addEventListener('input',ele =>{
		tempoSlide = inputTempo.value;
		labelTempo.textContent = 'Tempo de troca de slide: '+tempoSlide+' s';
	});
	
});