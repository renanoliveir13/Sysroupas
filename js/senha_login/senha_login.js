// JS para revelar e ocultar os caracteres do campo da senha
function mostrarSenha() {
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