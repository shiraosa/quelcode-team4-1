<?php
$this->Html->css('reservationDetails', ['block' => true])
?>

<div class="main">
    <h2 class="innerHeading">予約詳細</h2>
    <div class="innerWindow">
        <p class="completed">予約をキャンセルしました。</p>
        <a class="button bigBtn" href="<?= $this->Url->build(['action' => 'index']) ?>">マイページへ戻る</a>
    </div>
</div>
