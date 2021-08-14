var produto = $("#produto");
var produto_qtd = $("#produto_quantidade");
var produto_valor = $("#produto_valor");
var produto_total = $("#produto_total");    
var pct_revenda = $("#porcentagem_revenda");
$(function () {
    var error=[];   
     
    $('#adicionar').on('click', function () {
        if ($('.cd_cliente').first().val() == '') {
            alert('Selecione um cliente');
        } else {
            if (produto_qtd.val() == 0){
                error.push('Quantidade não pode ser 0');
            }
            if (pct_revenda.val() == 0 ){
                error.push('Informe a porcentagem');
            }
            if (produto_valor.val() == 0 ){
                error.push('Informe o valor unitário');
            }

            if (error.length > 0){
                alert(error.join('\n'));
                error=[];
                return false;
            }
            console.log(parseFloat(produto_valor.val()))
            let prodnome = $("#produto option:selected").text();
            let item = view_item(produto.val(),prodnome,produto_qtd.val(), produto_valor.val(), pct_revenda.val(), produto_total.val());
            $(item).appendTo($("#table_itens"));

            limparCampos();
            calcularTotalentrada();
        }
    });

    $("#produto_quantidade, #produto_valor, #porcentagem_revenda").on('keyup change', function () {
        calcularValores();
    });
    

   
    
    function view_item(id, produto, qtd, valorund, pct_revenda, valortotal) {
        let uniq = uniqId();
        var item = `<tr class="item_registrado" id="item_${uniq}">
                        <input type="hidden" name="cd_produto_entrada[]" value="0">     
                                         
                        <td>${produto}  <input type="hidden" class="cd_produto" name="cd_produto[]" value="${id}"></td>
                        <td>${qtd}x R$${parseFloat(valorund).toFixed(2)} <input type="hidden" class="quantidade" name="quantidade[]" value="${qtd}"> 
                        <input type="hidden" name="valor_item[]" value="${valorund}"></td>
                        <td>${pct_revenda}% <input type="hidden" name="pct_revenda[]" value="${pct_revenda}">  </td>
                        <td>R$<span class="item_total">${valortotal}</span></td>
                        <td><a class="dropdown-item" style="border-radius: 20px;" href="#" onClick="excluirItem('${uniq}');">Excluir</a></td>
                    </tr>`;
        return item;
    }

    function limparCampos(){
        produto.val('');
        produto_qtd.val('');
        produto_valor.val('');
        produto_total.val('');
        pct_revenda.val(0);
        produto.focus();
        error=[];   
    }
    
    
});
function calcularValores(){
    pct_revenda = $("#porcentagem_revenda");
    let qtd = produto_qtd.val();    
    var vlFinal  = parseFloat(qtd)*parseFloat(produto_valor.val());
    vlFinal = vlFinal + (vlFinal * pct_revenda.val()/100);
    produto_total.val(vlFinal.toFixed(2));  
}
function excluirItem(id){
    $("#item_"+id).remove();
    calcularTotalentrada();
}

function calcularTotalentrada(){
    console.log('calculando total')
    var vlf = 0;
    $(".item_total").each(function( index ) {        
        vlf = vlf + parseFloat($(this).text());
    });
    $("#total_entrada").text(vlf.toFixed(2));
}


function uniqId(prefix) {
    if (window.performance) {
        var s = performance.timing.navigationStart;
        var n = performance.now();
        var base = Math.floor((s + Math.floor(n))/1000);
    } else {
        var n = new Date().getTime();
        var base = Math.floor(n/1000);
    }   
    var ext = Math.floor(n%1000*1000);
    var now = ("00000000"+base.toString(16)).slice(-8)+("000000"+ext.toString(16)).slice(-5);
    if (now <= window.my_las_uid) {
        now = (parseInt(window.my_las_uid?window.my_las_uid:now, 16)+1).toString(16);
    }
    window.my_las_uid = now;
    return (prefix?prefix:'')+now;
}