<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\DiscountType $discountType
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Discount Types'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Discount Logs'), ['controller' => 'DiscountLogs', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Discount Log'), ['controller' => 'DiscountLogs', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="discountTypes form large-9 medium-8 columns content">
    <?= $this->Form->create($discountType) ?>
    <fieldset>
        <legend><?= __('Add Discount Type') ?></legend>
        <?php
            echo $this->Form->control('discount_type');
            echo $this->Form->control('discount_details');
            echo $this->Form->control('discount_price');
            echo $this->Form->control('start_date');
            echo $this->Form->control('banner_path');
            echo $this->Form->control('is_deleted');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
