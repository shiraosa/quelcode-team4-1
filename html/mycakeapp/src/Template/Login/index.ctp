<div class="login">
    <h2 class="innerHeading">ログイン</h2>
    <div class="innerWindow">
        <fieldset>
            <?php
            echo $this->Form->control('mailaddress', ['placeholder' => 'メールアドレス', 'label' => false]);
            echo $this->Form->control('password', ['placeholder' => 'パスワード', 'label' => false]);
            ?>
        </fieldset>
        <?= $this->Form->button(__('ログイン')) ?>
        <?= $this->Form->end() ?>
        <div class="innerFlex">
            <a class="inlineBox" href="#">会員登録</a>
            <a class="inlineBox" href="#">パスワードを忘れた方はコチラ</a>
        </div>
    </div>
</div>
