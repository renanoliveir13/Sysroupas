// JS que faz a requisicao de dados
function buscaDados(elem) {
	// Variavel cd_venda que retorna o elemento cd_venda
    var campos = elem.closest('.campos');
	var cd_venda = campos.querySelector('.cd_venda').value;
	// Verifica se o option selecionado e vazio (value="")
	if(!cd_venda) {
		// Apaga os valores dos elementos do formulario
		let input_selects = campos.querySelectorAll('input,select');
		let len = input_selects.length;
		for (let i=0; i<len; i++) {
			input_selects[i].value = '';
		}
		// Aborta o resto da funcao 
		return;
	}
	// Instancia a classe XMLHttpReques
	ajax = new XMLHttpRequest();
	// Especifica o Method e a url que sera chamada
	ajax.open("GET","/web/json/id_venda.php?cd_venda="+cd_venda,true);
	// Executa na resposta do ajax
	ajax.onreadystatechange = function() {
		// Se completar a requisi��o
		if (ajax.readyState == 4) {
			// Se retornar
			if(ajax.status == 200){
        		// Converte a string retornada para dados em JSON no JS
        		var retornoJson = JSON.parse(ajax.responseText);
        		// Preenche os campos com o retorno dos dados em cada campo
        		let total_produtos = retornoJson.produtos.length;
				let options_produtos = '<option value="" title="Por padrão a opção é vazia, escolha abaixo o produto desejado"> Nenhum </option>';
				for (let i=0; i<total_produtos; i++) {
					options_produtos += '<option value="' + retornoJson.produtos[i].cd_produto + '" data-cd_produto_venda="' + retornoJson.produtos[i].cd_produto_venda + '">' + retornoJson.produtos[i].nome + '</option>';
				}
        		campos.querySelector(".cd_produto").innerHTML = options_produtos;
    		}
		}
	}
	// Envia a solicitacao
	ajax.send();
}

function buscaDados2(elem) {
    var campos = elem.closest('.campos');
	// Variavel cd_produto que retorna o elemento cd_produto
    var cd_produto = elem.value;
    // Verifica se o option selecionado e vazio (value="")
    if(!cd_produto){
    	// Apaga os valores dos elementos do formulario
		campos.querySelector('.valor_item').value = '';
	  	campos.querySelector('.quantidade').value = '';
		// Aborta o resto da funcao 
		return;
   	}
	let cd_produto_venda = elem.options[elem.selectedIndex].dataset.cd_produto_venda;
    // Instancia a classe XMLHttpReques
    var ajax = new XMLHttpRequest();
    // Especifica o Method e a url que sera chamada
    ajax.open("GET","/web/json/id_produto_venda.php?cd_produto_venda="+cd_produto_venda,true);
    // Executa na resposta do ajax
    ajax.onreadystatechange = function(){
    	// Se completar a requisicao
	    if(ajax.readyState == 4){
	        // Se retornar
		    if(ajax.status == 200){
				// Converte a string retornada para dados em JSON no JS
				var retornoJson = JSON.parse(ajax.responseText);
				// Preenche os campos com o retorno dos dados em cada campo
				let produtos = document.querySelectorAll('.cd_produto');
				let len_produtos = produtos.length;
				let quantidade = 0;
				for (let i=0; i<len_produtos; i++) {
					if (produtos[i].value == cd_produto) {
					quantidade += parseInt(document.querySelectorAll('.quantidade')[i].value) || 0
					}
				}
				campos.querySelector(".valor_item").value = retornoJson[0].valor_item;
				let campo_quantidade = campos.querySelector(".quantidade");
				campo_quantidade.value = retornoJson[0].quantidade;
				campo_quantidade.max = retornoJson[0].quantidade;
				campos.querySelector('.cd_produto_venda').value = cd_produto_venda;
		    }
	    }
    }
    // Envia a solicitacao
    ajax.send();
}