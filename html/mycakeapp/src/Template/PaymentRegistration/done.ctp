<?php
    $this->Html->css('paymentRegistration', ['block' => true])
?>

<div class="main">
        <h2 class="innerHeading">決済情報</h2>
    <div class="innerWindow">
        <p class="completed">決済情報の登録が完了しました。</p>
        <a class="button bigBtn" href="<?= $this->Url->build(['controller' => 'Mypage', '_full' => true]) ?>">マイページに戻る</a>
    </div>
</div>
