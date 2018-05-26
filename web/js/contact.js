$(function(){

   // Order callBack
    $('#callBack-form').on('beforeSubmit', function(){
        var form = $(this);
        var message = 'Дякуємо. Дзвінок замовлено';
        sendOrder(form, message);
        return false;
    });

    // Send message
    $('#writeToUs-form').on('beforeSubmit', function(){
        var form = $(this);
        var message = 'Дякуємо. Ваше повідомлення відправлено';
        sendOrder(form, message);
        return false;
    });


});

function sendOrder(form,message) {

    $.ajax({
        url: '/ajax/order',
        type: 'POST',
        method: "POST",
        'cache':false,
        data: form.serialize(),
        success: function (res) {
            $('#callBack, #writeToUs').modal('hide');
            $('.bs-example-modal-sm').modal('show');
            $('.bs-example-modal-sm .modal-body').html(message);
            $('#callBack-form')[0].reset();
            $('#writeToUs-form')[0].reset();
        },
        error: function (res) {
            alert('Помилка відправки.');
            console.log(res);
        }
    });
}

$('#order_callBack').on('click',function() {
    $('#callBack-form').submit();
});

$('#order_writeToUs').on('click',function() {
    $('#writeToUs-form').submit();
});







