<?php
$this->Html->css('paymentDetails', ['block' => true]);
?>

<div class="main">
    <h2 class="innerHeading">決済</h2>
    <div class="innerWindow">
        <div class="windowContent">
            <p class="completed">決済が完了しました。</p>
            <a class="button bigBtn" href="<?= $this->Url->build(['controller' => 'Mypage']) ?>">マイページに戻る</a>
        </div>
    </div>
</div>
