$(function(){
	const PATH = 'http://localhost/sitecleusa/';
	let imgAtual = 0;

	$('.selecao img').eq(imgAtual).css('display','block');
	$('.selecao button').eq(imgAtual).addClass('btn-ativo');

	$('.selecao button').click(function(){
		$('.selecao button').removeClass('btn-ativo');
		$(this).addClass('btn-ativo');
		imgAtual = $(this).index();
		//$('.selecao img').hide();
		$('.selecao img').fadeOut(500);
		//$('.selecao img').eq(imgAtual).css('display','block');
		$('.selecao img').eq(imgAtual).fadeIn(500);
	})

	$('img:not([fixa])').click(function(){
		let fonte = $(this).attr('src');
		$('.localizacao-foto img').attr('src',fonte);
		$('.localizacao-foto').css('display','block');
	})

	$('.grade-principal div.E3').click(function(){
		let fonte = $(this).css('background-image');
		fonte = fonte.replace('..',PATH).slice(5,-2);
		requestAnimationFrame(()=>{
			$('.localizacao-foto img').attr('src',fonte);
			$('.localizacao-foto').css('display','block');
		});
	})

	$('.localizacao-foto').click(function(){
		$(this).css('display','none');	
	})


		
	let maxSlide = $('div.selecao img').length - 1;
	let delay = parseInt(tempoSlide);
	
	let changeSlideId = changeSlide();

	function changeSlide(){
		let idSet = setInterval(function(){
			$('div.selecao img').eq(imgAtual).fadeOut(1000);
			imgAtual++;
			if(imgAtual > maxSlide)
				imgAtual = 0;
			$('div.selecao img').eq(imgAtual).fadeIn(1000);
			$('.selecao button[real]').removeClass('btn-ativo');
			$('.selecao button[real]').eq(imgAtual).addClass('btn-ativo');	
		},delay * 1000);
		return idSet;
	}

	document.querySelectorAll('img').forEach(ele=>{
		ele.setAttribute('alt','Imagem');
	});

	document.addEventListener("visibilitychange", function(){//otimização de processamento
		if (document.hidden) {
			// A guia não está visível
			//parar a animação mais pesada
			clearInterval(changeSlideId);
		}else {
			// A guia está visível
			//retornar a animação
			changeSlideId = changeSlide();
		}
	});
})