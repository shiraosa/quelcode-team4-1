<?php
    $this->Html->css('basicRateDiscountPage', ['block' => true]);
?>

<div class="main">
    <h2>基本料金</h2>
    <ul class="rate">
        <?php foreach($rateInfos as $rate) : ?>
            <li>
                <div class="type"><?= $rate->ticket_type ?></div>
                <div class="price"><?= number_format($rate->basic_rate) ?>円</div>
            </li>
        <?php endforeach; ?>
    </ul>

    <h2>お得な割引サービス</h2>
    <ul class="discount">
        <?php foreach ($discountInfos as $discount) : ?>
            <li>
                <div class="discountLeft">
                    <div class="type"><?= $discount->discount_type ?></div>
                    <div class="details"><?= $discount->discount_details?></div>
                </div>
                <?php if ($discount->discount_price > 0) : ?>
                    <div class="price"><?= number_format($discount->discount_price) ?>円</div>
                <?php else : ?>
                    <div class="price"><?= number_format(abs($discount->discount_price)) ?>円引き</div>
                <?php endif; ?>
            </li>
                <?php endforeach; ?>
    </ul>
</div>
