<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\DiscountType $discountType
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Discount Type'), ['action' => 'edit', $discountType->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Discount Type'), ['action' => 'delete', $discountType->id], ['confirm' => __('Are you sure you want to delete # {0}?', $discountType->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Discount Types'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Discount Type'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Discount Logs'), ['controller' => 'DiscountLogs', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Discount Log'), ['controller' => 'DiscountLogs', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="discountTypes view large-9 medium-8 columns content">
    <h3><?= h($discountType->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Discount Type') ?></th>
            <td><?= h($discountType->discount_type) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Discount Details') ?></th>
            <td><?= h($discountType->discount_details) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Banner Path') ?></th>
            <td><?= h($discountType->banner_path) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($discountType->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Discount Price') ?></th>
            <td><?= $this->Number->format($discountType->discount_price) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Start Date') ?></th>
            <td><?= h($discountType->start_date) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($discountType->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($discountType->modified) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Is Deleted') ?></th>
            <td><?= $discountType->is_deleted ? __('Yes') : __('No'); ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Discount Logs') ?></h4>
        <?php if (!empty($discountType->discount_logs)): ?>
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
            <?php foreach ($discountType->discount_logs as $discountLogs): ?>
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
