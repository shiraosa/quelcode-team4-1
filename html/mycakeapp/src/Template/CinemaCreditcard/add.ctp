<?php
    $this->Html->css('cinemaCreditcard', ['block' => true]);
?>

<div class="main">
    <h2 class="innerHeading">決済情報</h2>
    <div class="innerWindow">
        <?= $this->Form->create($creditcard) ?>
        <fieldset>
            <div class="oneLine">
                <div class="box">
                    <?= $this->Form->input('creditcard_number', ['type' => 'integer', 'class' => 'cardNum', 'placeholder' => 'クレジットカード番号', 'label' => false, 'error' => false]); ?>
                    <?= ($this->Form->isFieldError('creditcard_number')) ? $this->Form->error('creditcard_number') : '' ?>
                </div>
                <!-- クレジットカードアイコン -->
                <i class="fab fa-cc-visa fa-2x cardIcon"></i><i class="fab fa-cc-mastercard fa-2x cardIcon"></i>
            </div>
            <div class="oneLine">
                <!-- クレジットカード名義人名 -->
                <div class="box">
                    <?= $this->Form->input('owner_name', ['class' => 'name', 'placeholder' => 'クレジットカード名義', 'label' => false, 'error' => false]); ?>
                    <?= ($this->Form->isFieldError('owner_name')) ? $this->Form->error('owner_name') : '' ?>
                </div>
            </div>
            <div class="oneLine">
                <!-- 有効期限 -->
                <div class="box">
                    <?= $this->Form->input('expiration_date', ['class' => 'limit', 'type' => 'text', 'placeholder' => '有効期限', 'label' => false, 'error' => false]); ?>
                    <?= ($this->Form->isFieldError('expiration_date')) ? $this->Form->error('expiration_date') : '' ?>
                </div>
                <!-- セキュリティコード -->
                <div class="box">
                    <?= $this->Form->input('code', ['class' => 'code', 'type' => 'password', 'placeholder' => 'セキュリティコード', 'label' => false, 'error' => false, 'required' => 'required']); ?>
                    <?= ($this->Form->isFieldError('code')) ? $this->Form->error('code') : '' ?>
                </div>
            </div>
            <!-- 同意チェックボックス -->
            <?= $this->Form->input('agree', ['class' => 'checkBox', 'type' => 'checkbox', 'label' => '利用規約・プライバシーポリシーに同意の上、ご確認ください。', 'required' => 'required']); ?>
        </fieldset>
        <?= $this->Form->button(__('登録'), ['class' => 'button bigBtn', 'type' => 'submit']) ?>
        <?= $this->Form->end() ?>
    </div>
</div>
<script src="https://kit.fontawesome.com/2ec4549c57.js" crossorigin="anonymous"></script>
