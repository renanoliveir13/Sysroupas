// JS que faz a requisicao de dados
function buscaDados(){
    // Variavel cd_funcionario que retorna o elemento cd_funcionario
    var cd_funcionario = document.querySelector("#cd_funcionario").value;
    // Verifica se o option selecionado e vazio (value="")
    if(!cd_funcionario){
    	// Apaga os valores dos elementos do formulario
      	document.forms[0].reset();
      	// Aborta o resto da funcao
      	return;
   	}
    // Instancia a classe XMLHttpReques
    ajax = new XMLHttpRequest();
    // Especifica o Method e a url que sera chamada
    ajax.open("GET","/web/json/id_funcionario.php?cd_funcionario="+cd_funcionario,true);
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
		      document.querySelector("#cpf").value = retornoJson[0].cpf;
		      document.querySelector("#telefone").value = retornoJson[0].telefone;
		      document.querySelector("#email").value = retornoJson[0].email;
		    }
	    }
    }
    // Envia a solicitacao
    ajax.send();
}
window.onload = buscaDados;