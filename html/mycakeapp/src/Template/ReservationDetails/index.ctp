<?php
$this->Html->css('reservationDetails', ['block' => true]);
?>

<div id="modalOverlay">
    <div id="modalContent" class="innerWindow">
        <p>本当にこの予約をキャンセルしますか？</p>
        <div class="oneLine">
            <button id="modalClose" class="button deleteCancel">戻る</button>
            <a class="button delete" href="<?= $this->Url->build(['action' => 'delete']) ?>">削除</a>
        </div>
    </div>
</div>

<div class="main">
    <h2 class="innerHeading">予約詳細</h2>
    <div class="innerWindow">
        <p>現在予約はありません</p>
        <div class="detail">
        </div>
        <a class="button bigBtn" href="<?= $this->Url->build(['controller' => 'Mypage']) ?>">マイページへ戻る</a>
    </div>

</div>
