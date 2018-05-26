$(function(){

    $('#sub_send').click(function (){

        $.ajax({
            url: '/ajax/sendemail',
            type: 'POST',
            'cache':false,
            data: {id:1},
            beforeSend: function() {
                $('#sub_send').attr('disabled','disabled').text('Чикаємо...');
                $('#load').show();

            },
            success: function(res){

                $('#sub_send').html('Завершено <span class="glyphicon glyphicon-ok"></span>');
                $('#load').hide();

            },
            error: function(res){
                $('#sub_send').addClass('btn-danger').text('Помилка обробки');
                //console.log(res);
            }
        });

    });

});

