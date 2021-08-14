// JS para formatar as mascaras nos campos
$(document).ready(function() {
	$("#valor_item").mask("00000.00", {reverse: true})
	$("#quantidade").mask("0000")
})