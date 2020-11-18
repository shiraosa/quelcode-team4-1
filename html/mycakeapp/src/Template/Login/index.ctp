<?php $this->Html->css('login.css', ['block' => true]) ?>
<div class="login">
    <h2 class="innerHeading">ログイン</h2>
    <div class="innerWindow">
        <?= $this->Form->create() ?>
        <fieldset>
            <?php
            echo $this->Form->control('mailaddress', ['placeholder' => 'メールアドレス', 'label' => false, 'required' => 'required']);
            ?>
            <span class="error-message">
                <?php
                if ($errorMailaddress) {
                    echo $errorMailaddress;
                } ?>
            </span>
            <?php
            echo $this->Form->control('password', ['placeholder' => 'パスワード', 'label' => false, 'required' => 'required']);
            ?>
            <span class="error-message">
                <?php
                if ($errorPassword) {
                    echo $errorPassword;
                }
                ?>
            </span>
        </fieldset>
        <?= $this->Form->button(__('ログイン', array('type' => 'submit'))) ?>
        <?= $this->Form->end() ?>
        <div class="innerFlex">
            <a class="inlineBox" href="cinema-member-registration">会員登録</a>
            <a class="inlineBox" href="#">パスワードを忘れた方はコチラ</a>
        </div>
    </div>
</div>
