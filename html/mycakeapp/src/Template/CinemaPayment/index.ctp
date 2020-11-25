<?php
$this->Html->css('paymentDetails', ['block' => true]);
?>

<div class="main">
    <h2 class="innerHeading">決済方法</h2>
    <div class="innerWindow">
        <div class="windowContent">
            <p>ご登録のクレジットカード</p>
            <div class="creditcard">
                <div class="dot"><?= $this->Html->image('dot.png') ?></div>
                <div class="column">
                    <p class="cardOwner"><?= $cardOwner ?></p>
                    <p class="cardDetails"><?= $cardBrand . ' ' . $cardNumLast4 . ' ' . '有効期限' . $cardDate ?></p>
                </div>
            </div>
            <p>ご利用ポイント</p>
            <?= $this->Form->create(null, ['url' => ['action' => 'index']]) ?>
            <div class="point oneLine">
            <?php if ($havePoint === 0) : ?>
                <?= $this->Form->select('useTypes', ['利用しない'], ['id' => 'useTypes', 'onChange' => 'checkUseInput()', 'required' => true]) ?>
            <?php else : ?>
                <?= $this->Form->select('useTypes', ['利用しない', '一部使う', '全部使う'], ['empty' => '選択してください', 'id' => 'useTypes', 'onChange' => 'checkUseInput()']) ?>
            <?php endif; ?>
                <?= $this->Form->input('usePoint', ['class' => 'usePoint', 'maxlength' => '5', 'type' => 'tel', 'label' => false]) ?><div class="pt"><span>pt</span></div>
            </div>
            <div class="oneLine">
                <a class="button delete" href="<?= $this->Url->build(['action' => 'cancel']) ?>">キャンセル</a>
                <button type="submit" class="button submit" href="<?= $this->Url->build(['action' => 'index']) ?>">決定</a>
            </div>
        </div>
    </div>
</div>
<?= $this->Html->script('jquery-3.5.1.min.js') ?>
<?= $this->Html->script('checkUseInput.js') ?>
