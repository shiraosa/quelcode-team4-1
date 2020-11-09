<?php $this->Html->css('cinema.css', ['block' => true]) ?>
<h2 class="innerHeading">会員登録</h2>
<div class="innerWindow">
    <?= $this->Form->create($user) ?>
    <fieldset>
        <?php
        echo $this->Form->control('mailaddress', ['placeholder' => 'メールアドレス', 'label' => false, 'error' => false]);
        echo ($this->Form->isFieldError('mailaddress')) ? $this->Form->error('mailaddress') : '';
        echo $this->Form->control('password', ['placeholder' => 'パスワード（半角英数字のみ可）', 'label' => false, 'error' => false]);
        echo ($this->Form->isFieldError('password')) ? $this->Form->error('password') : '';
        echo $this->Form->control('passwordConfirming', ['placeholder' => 'パスワード（確認用）', 'label' => false, 'type' => 'password', 'error' => false]);
        echo ($this->Form->isFieldError('passwordConfirming')) ? $this->Form->error('passwordConfirming') : '';
        ?>
    </fieldset>
    <?= $this->Form->button(__('会員登録')) ?>
    <?= $this->Form->end() ?>
</div>
