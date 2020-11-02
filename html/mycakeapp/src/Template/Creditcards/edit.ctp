<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Creditcard $creditcard
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $creditcard->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $creditcard->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Creditcards'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Payments'), ['controller' => 'Payments', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Payment'), ['controller' => 'Payments', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="creditcards form large-9 medium-8 columns content">
    <?= $this->Form->create($creditcard) ?>
    <fieldset>
        <legend><?= __('Edit Creditcard') ?></legend>
        <?php
            echo $this->Form->control('user_id', ['options' => $users]);
            echo $this->Form->control('owner_name');
            echo $this->Form->control('creditcard_number');
            echo $this->Form->control('expiration_date');
            echo $this->Form->control('is_deleted');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
