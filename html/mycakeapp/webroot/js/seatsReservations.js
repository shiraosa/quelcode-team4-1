$(document).ready(function () {

    function loadGrid() {

        $('.selectMove').seatLayout({
            data: seatData,
            showActionButtons: true,
            classes: {
                doneBtn: '',
                cancelBtn: '',
                row: '',
                area: '',
                screen: '',
                seat: ''
            },
            numberOfSeat: 1,//複数予約を可能にする場合はここを変更する
            callOnSeatRender: function (Obj) {
                //modify seat object if require and return it;
                return Obj;
            },
            callOnSeatSelect: function (_event, _data, _selected, _element) {
                console.log(_event);
                console.log(_data);
                console.log(_selected);
            },
            selectionDone: function (_array) {
                var csrf = $('input[name=_csrfToken]').val();
                $.ajax({
                    url: "/cinema-seats-reservations/done/" + scheduleId,
                    type: 'POST',
                    beforeSend: function (xhr) {
                        xhr.setRequestHeader('X-CSRF-Token', csrf);
                    },
                    data: _array,
                    dataType: 'json'
                })
                console.log(_array);
            },
            cancel: function () {
                return false;
            }
        });
    }
    loadGrid();

});
