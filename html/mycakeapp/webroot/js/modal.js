// モーダルウィンドウが開くときの処理
$(".modalOpen").on('click', function () {
    $('#modalContent,#modalOverlay').fadeIn("slow");

    $("#modalOverlay,#modalClose").click(function () {
        $("#modalContent,#modalOverlay").fadeOut("slow")
    })
})

