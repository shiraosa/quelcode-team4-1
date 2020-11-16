$('#cardDate').keyup(function () {

    var key = event.keyCode || event.charCode;
    if (key == 8 || key == 46) {
        return false;
    }

    var cardValue = $(this).val();
    var cardLength = cardValue.length + 1;

    if ((cardLength === 3)) {
        return $(this).val(cardValue += "/");
    }

});
