function checkUseInput() {
    var selectedValue = $('#useTypes').val();
    if (selectedValue === '1') {
        $('.usePoint').css({ 'display': 'initial' });
        $('.pt').css({ 'display': 'initial' });
    } else {
        $('.usePoint').css({ 'display': 'none' });
        $('.pt').css({ 'display': 'none' });
    }
}
