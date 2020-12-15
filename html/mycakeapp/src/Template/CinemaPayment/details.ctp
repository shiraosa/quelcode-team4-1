<?php
$this->Html->css('paymentDetails', ['block' => true]);
?>

<div class="main">
    <h2 class="innerHeading">決済概要</h2>
    <div class="innerWindow">
        <div class="windowContent">
            <table class="details">
                <tr class="ticketFeeTr">
                    <th>チケット金額</th>
                    <td><?= '￥' . $basicRatePrice ?></td>
                </tr>
                <?php if (!($point['use'] === 0)) : ?>
                    <tr class="orange">
                        <th>ご利用ポイント</th>
                        <td><?= $point['use'] . 'pt' ?></td>
                    </tr>
                <?php endif; ?>
                <?php if (!empty($discount)) : ?>
                    <tr class="orange">
                        <th><?= $discount['type'] ?></th>
                        <td><?= '￥' . $discount['price'] ?></td>
                    </tr>
                <?php endif; ?>
                <tr class="totalPayment">
                    <th>合計</th>
                    <td><?= '￥' . $totalPayment ?></td>
                </tr>
            </table>
            <div class="oneLine">
                <a class="button delete" href="<?= $this->Url->build(['action' => 'cancelDetails']) ?>">戻る</a>
                <a class="button submit" href="<?= $this->Url->build(['action' => 'save']) ?>">決済</a>
            </div>
        </div>
    </div>
</div>
