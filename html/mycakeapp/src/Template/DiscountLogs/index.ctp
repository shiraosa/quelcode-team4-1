<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\DiscountLog[]|\Cake\Collection\CollectionInterface $discountLogs
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Discount Log'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Discount Types'), ['controller' => 'DiscountTypes', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Discount Type'), ['controller' => 'DiscountTypes', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Reservations'), ['controller' => 'Reservations', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Reservation'), ['controller' => 'Reservations', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="discountLogs index large-9 medium-8 columns content">
    <h3><?= __('Discount Logs') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('discount_type_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('reservation_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('is_deleted') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($discountLogs as $discountLog): ?>
            <tr>
                <td><?= $this->Number->format($discountLog->id) ?></td>
                <td><?= $discountLog->has('discount_type') ? $this->Html->link($discountLog->discount_type->id, ['controller' => 'DiscountTypes', 'action' => 'view', $discountLog->discount_type->id]) : '' ?></td>
                <td><?= $discountLog->has('reservation') ? $this->Html->link($discountLog->reservation->id, ['controller' => 'Reservations', 'action' => 'view', $discountLog->reservation->id]) : '' ?></td>
                <td><?= h($discountLog->is_deleted) ?></td>
                <td><?= h($discountLog->created) ?></td>
                <td><?= h($discountLog->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $discountLog->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $discountLog->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $discountLog->id], ['confirm' => __('Are you sure you want to delete # {0}?', $discountLog->id)]) ?>
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
