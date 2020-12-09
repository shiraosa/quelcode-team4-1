<?php
$this->Html->css('mypage', ['block' => true])
?>

<div class="main">
    <h2 class="innerHeading">マイページ</h2>
    <div class="innerWindow">
        <p class="completed">アカウントを削除しました。</p>
        <a class="button bigBtn" href="<?= $this->Url->build(['controller' => 'Toppage']) ?>">トップに戻る</a>
    </div>
</div>
