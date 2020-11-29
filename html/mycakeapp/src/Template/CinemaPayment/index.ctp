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
            <p class="error-message"><?= isset($errors['usePoint']) ? array_pop($errors['usePoint']) : '' ?></p>
            <?= $this->Form->create() ?>
            <div class="point oneLine">
                <?php if ($point['have'] === 0) : ?>
                    <?= $this->Form->select('useTypes', ['利用しない'], ['id' => 'useTypes', 'onChange' => 'checkUseInput()', 'required']) ?>
                <?php else : ?>
                    <?= $this->Form->select('useTypes', ['利用しない', '一部使う', '全部使う'], ['empty' => '選択してください', 'id' => 'useTypes', 'required', 'onChange' => 'checkUseInput()']) ?>
                    <?= $this->Form->input('usePoint', [
                        'class' => 'usePoint', 'type' => 'integer', 'label' => false, 'value' => 0,
                        'oninput' => "value = value.replace(/[０-９]/g,s => String.fromCharCode(s.charCodeAt(0) - 65248)).replace(/\D/g,'');"
                    ]) ?><div class="pt"><span>pt</span></div>
                <?php endif; ?>
            </div>
            <div class="oneLine">
                <a class="button delete" href="<?= $this->Url->build(['action' => 'cancel']) ?>">キャンセル</a>
                <?= $this->Form->button('決定', ['class' => 'submit button']) ?>
            </div>
        </div>
    </div>
</div>
<?= $this->Html->script('jquery-3.5.1.min.js') ?>
<?= $this->Html->script('checkUseInput.js') ?>
