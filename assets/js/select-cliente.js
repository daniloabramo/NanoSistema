$(document).ready(function(){
    
    var select = $('#lista_cliente');
    var ajaxUrl = select.data('url'); 

    $.ajax({
        url: ajaxUrl, 
        type: 'POST',
        dataType: 'json',
        success: function(data) {
            $.each(data, function(index, item) {
                select.append($('<option>', {
                    value: item.id,
                    text: item.nome_completo
                }));
            });
        }
    });

    select.on('change', function() {
        var clienteId = $(this).val();
        var container = $('#hidden_container');
        
        container.empty();
        
        if (clienteId && clienteId !== '0') {
            var hiddenInput = $('<input>', {
                type: 'hidden',
                name: 'cliente_id',
                value: clienteId
            });
            container.append(hiddenInput);
        }
    });

});