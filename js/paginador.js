//script independente

let paginador = document.querySelector('div.paginacao');


//esperar carregar css e fonte
window.addEventListener('load', function() {
//detectar paginador
	if(paginador != null){
		let atual = paginador.querySelector('p[atual]');
		let pg = atual.getAttribute('pagina');
		let numeropg = paginador.querySelector('p[pagina="'+pg+'"]');
		let scroll = numeropg.offsetLeft - numeropg.scrollWidth;
		if(scroll >= 0){
			paginador.scroll(scroll,0);
		}
	}
});
	