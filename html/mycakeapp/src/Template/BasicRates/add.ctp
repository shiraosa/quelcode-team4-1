<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\BasicRate $basicRate
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Basic Rates'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Reservations'), ['controller' => 'Reservations', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Reservation'), ['controller' => 'Reservations', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="basicRates form large-9 medium-8 columns content">
    <?= $this->Form->create($basicRate) ?>
    <fieldset>
        <legend><?= __('Add Basic Rate') ?></legend>
        <?php
            echo $this->Form->control('ticket_type');
            echo $this->Form->control('basic_rate');
            echo $this->Form->control('start_date');
            echo $this->Form->control('is_deleted');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
