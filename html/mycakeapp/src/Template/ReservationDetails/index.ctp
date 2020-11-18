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
        <? if (empty($reservations)) : ?>
            <p>現在予約はありません</p>
        <? else : ?>
            <div class="detail">
            <? foreach ($reservations as $reservation) : ?>
                <div class="oneTicket">
                    <?= $this->Html->image($reservation['Movies.thumbnail_path']) ?>
                    <?= $reservation['Movies.title'] ?>
                    <?= $this->Form->button('キャンセル',['class' => 'cancel', 'type' => 'button']) ?>
                </div>
            <? endforeach; ?>
            </div>
        <? endif; ?>
        <a class="button bigBtn" href="<?= $this->Url->build(['controller' => 'Mypage']) ?>">マイページへ戻る</a>
    </div>

</div>
