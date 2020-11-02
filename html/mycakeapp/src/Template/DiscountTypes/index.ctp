<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\DiscountType[]|\Cake\Collection\CollectionInterface $discountTypes
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Discount Type'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Discount Logs'), ['controller' => 'DiscountLogs', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Discount Log'), ['controller' => 'DiscountLogs', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="discountTypes index large-9 medium-8 columns content">
    <h3><?= __('Discount Types') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('discount_type') ?></th>
                <th scope="col"><?= $this->Paginator->sort('discount_details') ?></th>
                <th scope="col"><?= $this->Paginator->sort('discount_price') ?></th>
                <th scope="col"><?= $this->Paginator->sort('start_date') ?></th>
                <th scope="col"><?= $this->Paginator->sort('banner_path') ?></th>
                <th scope="col"><?= $this->Paginator->sort('is_deleted') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($discountTypes as $discountType): ?>
            <tr>
                <td><?= $this->Number->format($discountType->id) ?></td>
                <td><?= h($discountType->discount_type) ?></td>
                <td><?= h($discountType->discount_details) ?></td>
                <td><?= $this->Number->format($discountType->discount_price) ?></td>
                <td><?= h($discountType->start_date) ?></td>
                <td><?= h($discountType->banner_path) ?></td>
                <td><?= h($discountType->is_deleted) ?></td>
                <td><?= h($discountType->created) ?></td>
                <td><?= h($discountType->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $discountType->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $discountType->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $discountType->id], ['confirm' => __('Are you sure you want to delete # {0}?', $discountType->id)]) ?>
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
