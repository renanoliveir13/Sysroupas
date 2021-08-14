function mostrarSenha() {
	// JS do Font awesome para campo de Senha atual
	var tipo = document.getElementById('senha')
	document.getElementById('pass').addEventListener('click', () => {
		if (tipo.value) {
			tipo.type == 'password' ? tipo.type = 'text' : tipo.type = 'password';
			tipo.focus()
			document.getElementById('pass').style.display = 'none';
			document.getElementById('text').style.display = 'inline-block';
		}
	})

	document.getElementById('text').addEventListener('click', () => {
		if (tipo.value) {
			tipo.type == 'text' ? tipo.type = 'password' : tipo.type = 'text';
			tipo.focus()
			document.getElementById('text').style.display = 'none';
			document.getElementById('pass').style.display = 'inline-block';
		}
	})
}
	
function mostrarNovaSenha() {
	// JS do Font awesome para campo de Nova senha
	var tipo2 = document.getElementById('senha_nova')
	document.getElementById('pass1').addEventListener('click', () => {
		if (tipo2.value) {
			tipo2.type == 'password' ? tipo2.type = 'text1' : tipo2.type = 'password';
			tipo2.focus()
			document.getElementById('pass1').style.display = 'none';
			document.getElementById('text1').style.display = 'inline-block';
		}
	})

	 document.getElementById('text1').addEventListener('click', () => {
		if (tipo2.value) {
		    tipo2.type == 'text1' ? tipo2.type = 'password' : tipo2.type = 'text1';
		    tipo2.focus()
		    document.getElementById('text1').style.display = 'none';
		    document.getElementById('pass1').style.display = 'inline-block';
		}
	})
}
	
function mostrarConfirmarSenha() {
	// JS do Font awesome para campo de Redigite a nova senha
	var tipo3 = document.getElementById('confirmar_senha_nova')
	document.getElementById('pass2').addEventListener('click', () => {
		if (tipo3.value) {
		    tipo3.type == 'password' ? tipo3.type = 'text2' : tipo3.type = 'password';
		    tipo3.focus()
		    document.getElementById('pass2').style.display = 'none';
		    document.getElementById('text2').style.display = 'inline-block';
		}
	})

	document.getElementById('text2').addEventListener('click', () => {
		if (tipo3.value) {
		    tipo3.type == 'text2' ? tipo3.type = 'password' : tipo3.type = 'text2';
		    tipo3.focus()
		    document.getElementById('text2').style.display = 'none';
		    document.getElementById('pass2').style.display = 'inline-block';
		}
	})
}