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
                // console.log(_event);
                // console.log(_data);
                // console.log(_selected);
            },
            selectionDone: function (_array) {
                $('button').addClass('loading');
                var csrf = $('input[name=_csrfToken]').val();
                $('.layout-btn-done').prop('disabled', true);
                $.ajax({
                    url: "/cinema-seats-reservations/done/" + scheduleId,
                    type: 'POST',
                    beforeSend: function (xhr) {
                        xhr.setRequestHeader('X-CSRF-Token', csrf);
                    },
                    async: false,
                    data: _array,
                    dataType: 'json'
                }).then(
                    // 1つめは通信成功時のコールバック
                    window.location.href = '/CinemaReservationConfirming/index'
                    ,
                    // 2つめは通信失敗時のコールバック
                    function () {
                        window.location.href = '/CinemaReservationConfirming/index'
                    });
                // console.log(_array);
            },
            cancel: function () {
                return false;
            }
        });
    }
    loadGrid();

});
