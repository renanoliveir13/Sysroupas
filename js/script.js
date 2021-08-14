$(function () {

    $('#adicionar').on('click', function () {
        if ($('.cd_cliente').first().val() == '') {
            alert('Selecione um cliente');
        } else {
            let campos = $('.campos');
            let campos_clone = $(".campo_0").clone();
            campos_clone.removeClass('campo_0');
            campos_clone.find('input').each(function () {
                $(this).val('');
            });
            campos_clone.find('.cd_funcionario').val(campos.find('.cd_funcionario').val());
            campos_clone.find('.cd_cliente').val(campos.find('.cd_cliente').val());
            campos_clone.appendTo(campos);
            $('.cd_cliente').attr('readonly', 'readonly');
        }
    });

});
