<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\DiscountLog $discountLog
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Discount Log'), ['action' => 'edit', $discountLog->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Discount Log'), ['action' => 'delete', $discountLog->id], ['confirm' => __('Are you sure you want to delete # {0}?', $discountLog->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Discount Logs'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Discount Log'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Discount Types'), ['controller' => 'DiscountTypes', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Discount Type'), ['controller' => 'DiscountTypes', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Reservations'), ['controller' => 'Reservations', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Reservation'), ['controller' => 'Reservations', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="discountLogs view large-9 medium-8 columns content">
    <h3><?= h($discountLog->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Discount Type') ?></th>
            <td><?= $discountLog->has('discount_type') ? $this->Html->link($discountLog->discount_type->id, ['controller' => 'DiscountTypes', 'action' => 'view', $discountLog->discount_type->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Reservation') ?></th>
            <td><?= $discountLog->has('reservation') ? $this->Html->link($discountLog->reservation->id, ['controller' => 'Reservations', 'action' => 'view', $discountLog->reservation->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($discountLog->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($discountLog->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($discountLog->modified) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Is Deleted') ?></th>
            <td><?= $discountLog->is_deleted ? __('Yes') : __('No'); ?></td>
        </tr>
    </table>
</div>
