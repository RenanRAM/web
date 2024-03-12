$(function(){

	$('img').click(function(){
		let fonte = $(this).attr('src');
		$('.localizacao-foto img').attr('src',fonte);
		$('.localizacao-foto').css('display','block');
	});

	$('.localizacao-foto').click(function(){
		$(this).css('display','none');	
	});

	document.querySelectorAll('img').forEach(ele=>{
		ele.setAttribute('alt','Imagem');
	});

});