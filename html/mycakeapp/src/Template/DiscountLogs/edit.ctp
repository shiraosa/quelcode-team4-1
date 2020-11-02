<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\DiscountLog $discountLog
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $discountLog->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $discountLog->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Discount Logs'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Discount Types'), ['controller' => 'DiscountTypes', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Discount Type'), ['controller' => 'DiscountTypes', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Reservations'), ['controller' => 'Reservations', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Reservation'), ['controller' => 'Reservations', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="discountLogs form large-9 medium-8 columns content">
    <?= $this->Form->create($discountLog) ?>
    <fieldset>
        <legend><?= __('Edit Discount Log') ?></legend>
        <?php
            echo $this->Form->control('discount_type_id', ['options' => $discountTypes]);
            echo $this->Form->control('reservation_id', ['options' => $reservations]);
            echo $this->Form->control('is_deleted');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
