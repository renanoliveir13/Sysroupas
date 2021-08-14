// // JS que faz a requisi��o de dados
// function buscaDados(elem) {
// 	// Variavel cd_venda que retorna o elemento cd_venda
// 	var cd_venda = elem.value;
// 	// Verifica se o option selecionado e vazio (value="")
// 	if (!cd_venda) {
// 		// Apaga os valores dos elementos do formulario
// 		document.forms[0].reset();
// 		// Aborta o resto da funcao 
// 		return;
// 	}
// 	// Instancia a classe XMLHttpReques
// 	ajax = new XMLHttpRequest();
// 	// Especifica o Method e a url que sera chamada
// 	ajax.open("GET", "/web/json/id_venda.php?cd_venda=" + cd_venda, true);
// 	// Executa na resposta do ajax
// 	ajax.onreadystatechange = function () {
// 		// Se completar a requisicao
// 		if (ajax.readyState == 4) {
// 			// Se retornar
// 			if (ajax.status == 200) {
// 				// Converte a string retornada para dados em JSON no JS
// 				var retornoJson = JSON.parse(ajax.responseText);
// 				// Preenche os campos com o retorno dos dados em cada campo
// 				let total_produtos = retornoJson.produtos.length;
// 				let options_produtos = '<option value="" title="Por padrão a opção é vazia, escolha abaixo o produto desejado"> Nenhum </option>';
// 				for (let i = 0; i < total_produtos; i++) {
// 					options_produtos += '<option value="' + retornoJson.produtos[i].cd_produto + '" data-cd_produto_venda="' + retornoJson.produtos[i].cd_produto_venda + '">' + retornoJson.produtos[i].nome + '</option>';
// 				}
// 				document.querySelector(".cd_produto").innerHTML = options_produtos;
// 				document.querySelector(".cd_funcionario").value = retornoJson[0].cd_funcionario;
// 				document.querySelector(".cd_cliente").value = retornoJson[0].cd_cliente;
// 			}
// 		}
// 	}
// 	// Envia a solicitacao
// 	ajax.send();
// }

function buscaDados2(elem) {
	// Variavel cd_produto que retorna o elemento cd_produto
	var cd_produto = elem.value;
	// Verifica se o option selecionado e vazio (value="")
	if (!cd_produto) {
		// Apaga os valores dos elementos do formulario
		document.querySelector('.valor_item').value = '';
		document.querySelector('.quantidade').value = '';
		// Aborta o resto da funcao 
		return;
	}
	let cd_produto_venda = elem.options[elem.selectedIndex].dataset.cd_produto_venda;
	// Instancia a classe XMLHttpReques
	var ajax = new XMLHttpRequest();
	// Especifica o Method e a url que sera chamada
	ajax.open("GET", "/web/json/id_produto_venda.php?cd_produto_venda=" + cd_produto_venda, true);
	// Executa na resposta do ajax
	ajax.onreadystatechange = function () {
		// Se completar a requisicao
		if (ajax.readyState == 4) {
			// Se retornar
			if (ajax.status == 200) {
				// Converte a string retornada para dados em JSON no JS
				var retornoJson = JSON.parse(ajax.responseText);
				// Preenche os campos com o retorno dos dados em cada campo
				let produtos = document.querySelectorAll('.cd_produto');
				let len_produtos = produtos.length;
				let quantidade = 0;
				for (let i = 0; i < len_produtos; i++) {
					if (produtos[i].value == cd_produto) {
						quantidade += parseInt(document.querySelectorAll('.quantidade')[i].value) || 0
					}
				}
				document.querySelector(".valor_item").value = retornoJson[0].valor_item;
				let campo_quantidade = document.querySelector(".quantidade");
				campo_quantidade.value = retornoJson[0].quantidade;				
				document.querySelector('.cd_produto_venda').value = cd_produto_venda;
			}
		}
	}
	// Envia a solicitacao
	ajax.send();
}


function excluirProdutoEntrada(id, item) {
	var http = new XMLHttpRequest();
	var url = '/web/json/id_produto_entrada_excluir.php';
	var params = 'cd_produto_entrada='+id;
	http.open('POST', url, true);

	//Send the proper header information along with the request
	http.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

	http.onreadystatechange = function () {//Call a function when the state changes.
		if (http.readyState == 4 && http.status == 200) {
			const response = JSON.parse(http.responseText);			
			if (response.success){
				excluirItem(item);
			}else{
				alert('Opa','Não foi possível excluir o item da venda.');
			}
		}
	}
	http.send(params);
}