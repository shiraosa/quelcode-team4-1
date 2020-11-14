$('#cardNumber').keyup(function () {

    var key = event.keyCode || event.cahrCode;
    if (key == 8 || key == 46) {
        return false;
    }

    var cardValue = $(this).val();
    var cardLength = cardValue.length + 1;


    if ((0 === cardLength % 5) && (cardLength < 16)) {
        return $(this).val(cardValue += " ");
    }

});
