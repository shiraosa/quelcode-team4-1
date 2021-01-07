<?php
$this->Html->css('cinemaCreditcard', ['block' => true]);
?>

<div id="modalOverlay">
    <div id="modalContent" class="innerWindow">
        <p>本当にこの決済情報を削除しますか？</p>
        <div class="oneLine">
            <button id="modalClose" class="button deleteCancel">戻る</button>
            <a class="button delete" href="<?= $this->Url->build(['action' => 'delete']) ?>">削除</a>
        </div>
    </div>
</div>
<div class="main">
    <h2 class="innerHeading">決済情報</h2>
    <div class="innerWindow">
        <p class="completed"><?= $creditcard->owner_name ?></p>
        <p class="completed"><?= $cardBrand . '　************' . $cardNumLast4 ?></p>
        <div class="oneLine">
            <button class="modalOpen button delete">削除</button>
            <a class="button edit" href="<?= $this->Url->build(['action' => 'edit']) ?>">編集</a>
        </div>
        <a class="button return" href="<?= $this->Url->build(['controller' => 'Mypage']) ?>">戻る</a>
    </div>
</div>
<?= $this->Html->script('jquery-3.5.1.min.js') ?>
<?= $this->Html->script('modal.js') ?>
