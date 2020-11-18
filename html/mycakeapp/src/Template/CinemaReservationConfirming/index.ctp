<?php $this->Html->css('cinemaReservationConfirming.css', ['block' => true]) ?>

<div class="beingConfirmed">
    <p>映画タイトル</p>
    <p>00月00日(月)00:00~<span class="endTime">00:00</span></p>
    <p class="seat">座席：A-1</p>
</div>
<div class="innerWindow">
    <?= $this->Form->create($hoge) ?>
    <fieldset>
        <div class="inner-box">
            <p class="input-p">性別</p>
            <div class="input-radio">
                <?= $this->Form->radio('sex', ['男性', '女性'], ['required']); ?>
            </div>
        </div>
        <div class="inner-box">
            <p class="input-p">種類</p>
            <div class="input-select">
                <?= $this->Form->select('type', ['一般', '大学生', '高校生', '小中学生', '幼児（3歳以上）']); ?>
            </div>
        </div>
        <div class="inner-box">
            <p class="input-p">生年月日</p>
            <div class="input-text">
                <?= $this->Form->text('year', ['required']); ?>
                <p class="text-by">年</p>
                <?= $this->Form->text('month', ['required']); ?>
                <p class="text-by">月</p>
                <?= $this->Form->text('day', ['required']); ?>
                <p class="text-by">日</p>
            </div>
        </div>
    </fieldset>
    <div class="buttons">
        <?= $this->Form->button('キャンセル', ['class' => 'cancel', 'type' => 'button', 'onclick' => 'history.back()']); ?>
        <?= $this->Form->button('決定', ['class' => 'submit']) ?>
        <?= $this->Form->end() ?>
    </div>
</div>
