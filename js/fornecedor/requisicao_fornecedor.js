// JS que faz a requisicao de dados
function buscaDados(){
    // Variavel cd_fornecedor que retorna o elemento cd_fornecedor
    var cd_fornecedor = document.querySelector("#cd_fornecedor").value;
    // Verifica se o option selecionado e vazio (value="")
    if(!cd_fornecedor){
    	// Apaga os valores dos elementos do formulario
      	document.forms[0].reset();
      	// Aborta o resto da funcao 
      	return;
   	}
    // Instancia a classe XMLHttpReques
    ajax = new XMLHttpRequest();
    // Especifica o Method e a url que sera chamada
    ajax.open("GET","/web/json/id_fornecedor.php?cd_fornecedor="+cd_fornecedor,true);
    // Executa na resposta do ajax
    ajax.onreadystatechange = function(){
       // Se completar a requisicao
	   if(ajax.readyState == 4){
    	   // Se retornar
    		if(ajax.status == 200){
        		// Converte a string retornada para dados em JSON no JS
        		var retornoJson = JSON.parse(ajax.responseText);
        		// Preenche os campos com o retorno dos dados em cada campo
        		document.querySelector("#nome").value = retornoJson[0].nome;
        		document.querySelector("#cnpj").value = retornoJson[0].cnpj;
        		document.querySelector("#telefone").value = retornoJson[0].telefone;
        		document.querySelector("#email").value = retornoJson[0].email;
        		document.querySelector("#estado").value = retornoJson[0].estado;
        		document.querySelector("#cidade").value = retornoJson[0].cidade;
        		document.querySelector("#bairro").value = retornoJson[0].bairro;
        		document.querySelector("#endereco").value = retornoJson[0].endereco;
        		document.querySelector("#numero").value = retornoJson[0].numero;
    		}
    	}
    }
    // Envia a solicitacao
    ajax.send();
}