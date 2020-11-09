<?php
    $this->Html->css('paymentRegistration', ['block' => true]);
?>

<div class="main">
    <div class="innerWindow">
        <?= $this->Form->create($creditcard) ?>
        <fieldset>
            <?php
                echo $this->Form->input('');
                echo $this->Form->input('owner_name');
                echo $this->Form->input('expiration_date');
                echo $this->Form->input('');
                echo $this->Form->checkbox('agree');
            ?>
        </fieldset>
        <?= $this->Form->button(__('登録')) ?>
        <?= $this->Form->end() ?>
    </div>
</div>
