$('#cardDate').keyup(function () {

    var key = event.keyCode || event.charCode;
    if (key == 8 || key == 46) {
        return false;
    }

    var value = $(this).val();
    var length = value.length + 1;

    if ((length === 3)) {
        return $(this).val(value += "/");
    }

});
