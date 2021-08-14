// JS que faz a requisicao de dados
function buscaDados(){
    // Variavel cd_produto que retorna o elemento cd_produto
    var cd_produto = document.querySelector("#cd_produto").value;
    // Verifica se o option selecionado e vazio (value="")
    if(!cd_produto){
    	// Apaga os valores dos elementos do formulario
      document.forms[0].reset();
      // Aborta o resto da funcao 
      return;
   	}
    // Instancia a classe XMLHttpReques
    ajax = new XMLHttpRequest();
    // Especifica o Method e a url que sera chamada
    ajax.open("GET","/web/json/id_produto.php?cd_produto="+cd_produto,true);
    // Executa na resposta do ajax
    ajax.onreadystatechange = function(){
    	// Se completar a requisicao
	    if(ajax.readyState == 4){
	        // Se retornar
		    if(ajax.status == 200){
		      // Converte a string retornada para dados em JSON no JS
		      var retornoJson = JSON.parse(ajax.responseText);
		      // Preenche os campos com o retorno dos dados em cada campo
          document.querySelector("#cd_fornecedor").value = retornoJson[0].cd_fornecedor;
		      document.querySelector("#nome").value = retornoJson[0].nome;
		      document.querySelector("#marca").value = retornoJson[0].marca;
		      document.querySelector("#codigo").value = retornoJson[0].codigo_barra;
		      document.querySelector("#cor").value = retornoJson[0].cor;
		      document.querySelector("#tamanho").value = retornoJson[0].tamanho;
		      document.querySelector("#genero").value = retornoJson[0].genero;
		      document.querySelector("#quantidade").value = retornoJson[0].quantidade;
		      document.querySelector("#valor_compra").value = retornoJson[0].valor_compra;
          document.querySelector("#porcentagem_revenda").value = retornoJson[0].porcentagem_revenda;
		    }
	    }
    }
  // Envia a solicitacao
  ajax.send();
}