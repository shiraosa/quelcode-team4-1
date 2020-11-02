<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Seat[]|\Cake\Collection\CollectionInterface $seats
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Seat'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Schedules'), ['controller' => 'Schedules', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Schedule'), ['controller' => 'Schedules', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Reservations'), ['controller' => 'Reservations', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Reservation'), ['controller' => 'Reservations', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="seats index large-9 medium-8 columns content">
    <h3><?= __('Seats') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('schedule_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('seat_number') ?></th>
                <th scope="col"><?= $this->Paginator->sort('is_deleted') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($seats as $seat): ?>
            <tr>
                <td><?= $this->Number->format($seat->id) ?></td>
                <td><?= $seat->has('schedule') ? $this->Html->link($seat->schedule->id, ['controller' => 'Schedules', 'action' => 'view', $seat->schedule->id]) : '' ?></td>
                <td><?= h($seat->seat_number) ?></td>
                <td><?= h($seat->is_deleted) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $seat->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $seat->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $seat->id], ['confirm' => __('Are you sure you want to delete # {0}?', $seat->id)]) ?>
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
