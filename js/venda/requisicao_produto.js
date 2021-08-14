function buscaDados(elem){  
    // Variavel cd_produto que retorna o elemento cd_produto
    
    var cd_produto = document.getElementById('produto').value;
    // Verifica se o option selecionado e vazio (value="")
    if(!cd_produto){
    	// Apaga os valores dos elementos do formulario
      let input_selects = campos.querySelectorAll('input,select');
      let len = input_selects.length;
      for (let i=0; i<len; i++) {
        if (!input_selects[i].classList.contains('cd_funcionario') && !input_selects[i].classList.contains('cd_cliente')) {
          input_selects[i].value = '';
        }
      }
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
          let produtos = document.querySelectorAll('.cd_produto');
          let len_produtos = produtos.length;
          console.log(len_produtos);
          let quantidade = 0;
          for (let i=0; i<len_produtos; i++) {
            if (produtos[i].value == cd_produto) {
              
              quantidade += parseInt(document.querySelectorAll('.quantidade')[i].value) || 0
            }
          }
		      document.getElementById("produto_valor").value = retornoJson[0].valor_revenda;
          document.getElementById("produto_total").value = retornoJson[0].valor_revenda;
          let quantidade_restante = (parseInt(retornoJson[0].quantidade) || 0) - quantidade;
          if (quantidade_restante < 0) {
            quantidade_restante = 0;
          }
          let campo_quantidade = document.getElementById("produto_quantidade");
          
          campo_quantidade.value = (quantidade_restante == 0?0:1);
          campo_quantidade.max = quantidade_restante;
		    }
	    }
    }
  ajax.send();
}