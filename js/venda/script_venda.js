$(function () {
    var indexP = 0;
    const produto = $("#produto");
    const produto_qtd = $("#produto_quantidade");
    const produto_valor = $("#produto_valor");
    const produto_total = $("#produto_total");    

    $('#adicionar').on('click', function () {
        if (produto_qtd.val() == 0){
            alert('Quantidade não pode ser 0');
            return false;
        }
        if ($('.cd_cliente').first().val() == '') {
            alert('Selecione um cliente');
        } else {
            let prodnome = $("#produto option:selected").text();
            let item = view_item(produto.val(),prodnome,produto_qtd.val(), produto_valor.val(), produto_total.val());
            $(item).appendTo($("#table_itens"));

            limparCampos();
            calcularTotalVenda();
        }
    });

    $("#produto_quantidade").on('keyup change', function () {
        calcularValores();
    });

    function calcularValores(){
        let qtd = produto_qtd.val();    
        let vlFinal  = parseFloat(qtd)*parseFloat(produto_valor.val());
        produto_total.val(vlFinal.toFixed(2));  
    }
    
    function view_item(id, produto, qtd, valorund, valortotal) {
        let uniq = uniqId();
        var item = `<tr class="item_registrado" id="item_${uniq}">
                        <input type="hidden" name="cd_produto_venda[]" value="0">
                        <input type="hidden" name="produto[]" value="${produto}">
                        <td>${produto}  <input type="hidden" class="cd_produto" name="cd_produto[]" value="${id}"></td>
                        <td>${qtd}x R$${valorund} <input type="hidden" class="quantidade" name="quantidade[]" value="${qtd}"> </td>
                        <input type="hidden" name="valor_item[]" value="${valorund}">
                        <td>R$ <span class="item_total">${valortotal}</span></td>
                        <input type="hidden" name="valor_total[]" value="${valortotal}">
                        <td><a class="dropdown-item" style="border-radius: 20px;" href="#" onClick="excluirItem('${uniq}');">Excluir</a></td>
                    </tr>`;
        return item;
    }

    function limparCampos(){
        produto.val('');
        produto_qtd.val('');
        produto_valor.val('');
        produto_total.val('');
        produto.focus();
    }
    
    
});

function excluirItem(id){
    $("#item_"+id).remove();
    calcularTotalVenda();
}

function calcularTotalVenda(){
    console.log('calculando total')
    var vlf = 0;
    $(".item_total").each(function( index ) {        
        vlf = vlf + parseFloat($(this).text());
    });
    $("#total_venda").text(vlf.toFixed(2));
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

function populateForm(frm, data) {
    console.log(data);

    $.each(data, function(key, value) {
        var ctrl = $("[name=" + key + "]", frm);
        switch (ctrl.prop("type")) {
            case "radio":
                if (
                    ctrl.parent().hasClass("icheck-primary") ||
                    ctrl.parent().hasClass("icheck-danger") ||
                    ctrl.parent().hasClass("icheck-success")
                ) {
                    // raido kutularında aynı isimden birden fazla denetçi olduğu için bunları döngüyle almak lazım
                    // multiple radio boxes has same name and has different id. for this we must look to each html element
                    $.each(ctrl, function(ctrlKey, radioElem) {
                        radioElem = $(radioElem);
                        console.log(radioElem);
                        console.log(radioElem.attr("value"));

                        if (radioElem.attr("value") == value) {
                            radioElem.iCheck("check");
                        } else {
                            radioElem.iCheck("uncheck");
                        }
                    });
                } else {
                    $.each(ctrl, function(ctrlKey, radioElem) {
                        radioElem = $(radioElem);
                        console.log(radioElem);
                        console.log(radioElem.attr("value"));

                        if (radioElem.attr("value") == value) {
                            radioElem.attr("checked", value);
                        } else {
                            radioElem.attr("checked", value);
                        }
                    });
                }
                break;

            case "checkbox":
                if (
                    ctrl.parent().hasClass("icheck-primary") ||
                    ctrl.parent().hasClass("icheck-danger") ||
                    ctrl.parent().hasClass("icheck-success")
                ) {
                    if (ctrl.attr("value") == value) {
                        ctrl.iCheck("check");
                    } else {
                        ctrl.iCheck("uncheck");
                    }
                } else {
                    ctrl.removeAttr("checked");
                    ctrl.each(function() {
                        if (value === null) value = "";
                        if ($(this).attr("value") == value) {
                            $(this).attr("checked", value);
                        }
                    });
                }
                break;
            default:
                ctrl.val(value);
        }
    });
}