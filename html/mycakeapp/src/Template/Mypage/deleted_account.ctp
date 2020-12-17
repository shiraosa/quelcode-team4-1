<?php
$this->Html->css('completed', ['block' => true])
?>

<div class="main">
    <h2 class="innerHeading">マイページ</h2>
    <div class="innerWindow">
        <div class="windowContent">
            <p class="completed">アカウントを削除しました。</p>
            <a class="button bigBtn" href="<?= $this->Url->build(['controller' => 'QuelCinemas']) ?>">トップに戻る</a>
        </div>
    </div>
</div>
