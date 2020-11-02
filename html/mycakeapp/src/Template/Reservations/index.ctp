<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Reservation[]|\Cake\Collection\CollectionInterface $reservations
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Reservation'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Seats'), ['controller' => 'Seats', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Seat'), ['controller' => 'Seats', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Schedules'), ['controller' => 'Schedules', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Schedule'), ['controller' => 'Schedules', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Movies'), ['controller' => 'Movies', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Movie'), ['controller' => 'Movies', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Payments'), ['controller' => 'Payments', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Payment'), ['controller' => 'Payments', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Basic Rates'), ['controller' => 'BasicRates', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Basic Rate'), ['controller' => 'BasicRates', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Discount Logs'), ['controller' => 'DiscountLogs', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Discount Log'), ['controller' => 'DiscountLogs', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="reservations index large-9 medium-8 columns content">
    <h3><?= __('Reservations') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('user_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('seat_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('schedule_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('movie_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('payment_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('basic_rate_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('is_deleted') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($reservations as $reservation): ?>
            <tr>
                <td><?= $this->Number->format($reservation->id) ?></td>
                <td><?= $reservation->has('user') ? $this->Html->link($reservation->user->id, ['controller' => 'Users', 'action' => 'view', $reservation->user->id]) : '' ?></td>
                <td><?= $reservation->has('seat') ? $this->Html->link($reservation->seat->id, ['controller' => 'Seats', 'action' => 'view', $reservation->seat->id]) : '' ?></td>
                <td><?= $reservation->has('schedule') ? $this->Html->link($reservation->schedule->id, ['controller' => 'Schedules', 'action' => 'view', $reservation->schedule->id]) : '' ?></td>
                <td><?= $reservation->has('movie') ? $this->Html->link($reservation->movie->title, ['controller' => 'Movies', 'action' => 'view', $reservation->movie->id]) : '' ?></td>
                <td><?= $reservation->has('payment') ? $this->Html->link($reservation->payment->id, ['controller' => 'Payments', 'action' => 'view', $reservation->payment->id]) : '' ?></td>
                <td><?= $reservation->has('basic_rate') ? $this->Html->link($reservation->basic_rate->id, ['controller' => 'BasicRates', 'action' => 'view', $reservation->basic_rate->id]) : '' ?></td>
                <td><?= h($reservation->is_deleted) ?></td>
                <td><?= h($reservation->created) ?></td>
                <td><?= h($reservation->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $reservation->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $reservation->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $reservation->id], ['confirm' => __('Are you sure you want to delete # {0}?', $reservation->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></p>
    </div>
</div>
