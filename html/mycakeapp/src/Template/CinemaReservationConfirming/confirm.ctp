<?php $this->Html->css('cinemaReservationConfirming.css', ['block' => true]) ?>

<div class="main">
    <h2 class="innerHeading">予約詳細</h2>
    <div class="innerWindow-confirm">
        <?= $this->Form->create() ?>
        <div class="beingConfirmed-confirm">
            <p class="title"><?= $schedule['movie']['title'] ?></p>
            <p class="date"><?= $schedule['start'] ?>〜<span class="endTime"><?= $schedule['end'] ?></span></p>
            <p class="seat">座席：<?= $schedule['seatNo'] ?></p>
            <p class="price"><?= $price ?></p>
            <p class="discount"><?= $discountType ?></p>
        </div>
        <div class="buttons">
            <?= $this->Html->link('戻る', ['controller' => $this->request->getParam('controller'), 'action' => 'index'], ['class' => 'cancel']); ?>
            <?= $this->Form->button('決定', ['class' => 'submit']) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
