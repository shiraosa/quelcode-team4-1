<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Reservation $reservation
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Reservation'), ['action' => 'edit', $reservation->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Reservation'), ['action' => 'delete', $reservation->id], ['confirm' => __('Are you sure you want to delete # {0}?', $reservation->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Reservations'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Reservation'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Seats'), ['controller' => 'Seats', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Seat'), ['controller' => 'Seats', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Schedules'), ['controller' => 'Schedules', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Schedule'), ['controller' => 'Schedules', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Movies'), ['controller' => 'Movies', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Movie'), ['controller' => 'Movies', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Payments'), ['controller' => 'Payments', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Payment'), ['controller' => 'Payments', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Basic Rates'), ['controller' => 'BasicRates', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Basic Rate'), ['controller' => 'BasicRates', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Discount Logs'), ['controller' => 'DiscountLogs', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Discount Log'), ['controller' => 'DiscountLogs', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="reservations view large-9 medium-8 columns content">
    <h3><?= h($reservation->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('User') ?></th>
            <td><?= $reservation->has('user') ? $this->Html->link($reservation->user->id, ['controller' => 'Users', 'action' => 'view', $reservation->user->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Seat') ?></th>
            <td><?= $reservation->has('seat') ? $this->Html->link($reservation->seat->id, ['controller' => 'Seats', 'action' => 'view', $reservation->seat->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Schedule') ?></th>
            <td><?= $reservation->has('schedule') ? $this->Html->link($reservation->schedule->id, ['controller' => 'Schedules', 'action' => 'view', $reservation->schedule->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Movie') ?></th>
            <td><?= $reservation->has('movie') ? $this->Html->link($reservation->movie->title, ['controller' => 'Movies', 'action' => 'view', $reservation->movie->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Payment') ?></th>
            <td><?= $reservation->has('payment') ? $this->Html->link($reservation->payment->id, ['controller' => 'Payments', 'action' => 'view', $reservation->payment->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Basic Rate') ?></th>
            <td><?= $reservation->has('basic_rate') ? $this->Html->link($reservation->basic_rate->id, ['controller' => 'BasicRates', 'action' => 'view', $reservation->basic_rate->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($reservation->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($reservation->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($reservation->modified) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Is Deleted') ?></th>
            <td><?= $reservation->is_deleted ? __('Yes') : __('No'); ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Discount Logs') ?></h4>
        <?php if (!empty($reservation->discount_logs)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Discount Type Id') ?></th>
                <th scope="col"><?= __('Reservation Id') ?></th>
                <th scope="col"><?= __('Is Deleted') ?></th>
                <th scope="col"><?= __('Created') ?></th>
                <th scope="col"><?= __('Modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($reservation->discount_logs as $discountLogs): ?>
            <tr>
                <td><?= h($discountLogs->id) ?></td>
                <td><?= h($discountLogs->discount_type_id) ?></td>
                <td><?= h($discountLogs->reservation_id) ?></td>
                <td><?= h($discountLogs->is_deleted) ?></td>
                <td><?= h($discountLogs->created) ?></td>
                <td><?= h($discountLogs->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'DiscountLogs', 'action' => 'view', $discountLogs->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'DiscountLogs', 'action' => 'edit', $discountLogs->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'DiscountLogs', 'action' => 'delete', $discountLogs->id], ['confirm' => __('Are you sure you want to delete # {0}?', $discountLogs->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
