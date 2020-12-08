<?php $this->Html->css('cinemaReservationConfirming.css', ['block' => true]) ?>

<div class="beingConfirmed">
    <p><?= $schedule['movie']['title'] ?></p>
    <p><?= $schedule['start'] ?>〜<span class="endTime"><?= $schedule['end'] ?></span></p>
    <p class="seat">座席：<?= $schedule['seatNo'] ?></p>
</div>
<div class="innerWindow">
    <?= $this->Form->create('', ['name' => 'form']) ?>
    <fieldset>
        <div class="inner-box">
            <p class="input-p">性別</p>
            <div class="input-radio">
                <?= $this->Form->radio('sex', ['male' => '男性', 'female' => '女性'], ['required']); ?>
            </div>
            <p class="error-message"><?= isset($errors['sex']) ? array_pop($errors['sex']) : '' ?></p>
        </div>
        <div class="inner-box">
            <p class="input-p">種類</p>
            <div class="input-select">
                <?= $this->Form->select('type', $type); ?>
            </div>
            <p class="error-message"><?= isset($errors['type']) ? array_pop($errors['type']) : '' ?></p>
        </div>
        <div class="inner-box">
            <p class="input-p">生年月日</p>
            <div class="input-text">
                <?= $this->Form->text('year', [
                    'required', 'maxlength' => 4, 'onkeyup' => 'setNextFocus(this)',
                    'oninput' => "value = value.replace(/[０-９]/g,s => String.fromCharCode(s.charCodeAt(0) - 65248)).replace(/\D/g,'');"
                ]); ?>
                <p class="text-by">年</p>
                <?= $this->Form->text('month', [
                    'required', 'maxlength' => 2, 'onkeyup' => 'setNextFocus(this)',
                    'oninput' => "value = value.replace(/[０-９]/g,s => String.fromCharCode(s.charCodeAt(0) - 65248)).replace(/\D/g,'');"
                ]); ?>
                <p class="text-by">月</p>
                <?= $this->Form->text('day', [
                    'required', 'maxlength' => 2,
                    'oninput' => "value = value.replace(/[０-９]/g,s => String.fromCharCode(s.charCodeAt(0) - 65248)).replace(/\D/g,'');"
                ]); ?>
                <p class="text-by">日</p>
            </div>
            <p class="error-message"><?= isset($errors['year']) ? array_pop($errors['year']) : '' ?></p>
            <p class="error-message"><?= isset($errors['month']) ? array_pop($errors['month']) : '' ?></p>
            <p class="error-message"><?= isset($errors['day']) ? array_pop($errors['day']) : '' ?></p>
        </div>
    </fieldset>
    <div class="buttons">
<<<<<<< HEAD
        <?= $this->Html->link('戻る', ['controller' => $this->request->getParam('controller'), 'action' => 'cancel'], ['class' => 'cancel']); ?>
=======
        <!-- コンフリクト用 -->
        <?= $this->Html->link('もどる', ['controller' => $this->request->getParam('controller'), 'action' => 'cancel'], ['class' => 'cancel']); ?>
>>>>>>> 9bc3af90d09a998f4e3ca16f1468904bfe4d0770
        <?= $this->Form->button('決定', ['class' => 'submit']) ?>
        <?= $this->Form->end() ?>
    </div>
</div>
<?= $this->Html->script('nextFocus.js') ?>
