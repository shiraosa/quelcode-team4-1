<?php $this->Html->css('cinemaReservationConfirming.css', ['block' => true]) ?>

<div class="innerWindow-confirm">
    <div class="beingConfirmed-confirm">
        <p class="title"><?= $schedule['movie']['title'] ?></p>
        <p class="date"><?= $schedule['start'] ?>~<span class="endTime"><?= $schedule['end'] ?></span></p>
        <p class="seat">座席：<?= $schedule['seatNo'] ?></p>
        <p class="price">&yen;1,111</p>
        <p class="discount"><?= true ? 'レディースデー割引' : '' ?></p>
    </div>
    <div class="buttons">
        <?= $this->Html->link('キャンセル', ['controller' => $this->request->getParam('controller'), 'action' => 'index'], ['class' => 'cancel']); ?>
        <?= $this->Form->button('決定', ['class' => 'submit']) ?>
    </div>
</div>
