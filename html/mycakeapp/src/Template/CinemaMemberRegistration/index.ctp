<h2 class="innerHeading">会員登録</h2>
<div class="innerWindow">
    <fieldset>
        <?php
        echo $this->Form->control('mailaddress', ['placeholder' => 'メールアドレス', 'label' => false]);
        echo $this->Form->control('password', ['placeholder' => 'パスワード', 'label' => false]);
        echo $this->Form->control('passwordConfirming', ['placeholder' => 'パスワード（確認用）', 'label' => false]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('会員登録')) ?>
    <?= $this->Form->end() ?>
</div>
