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
                    <td><?= '￥' . $ticketFee ?></td>
                </tr>
                <tr class="orange">
                    <th>ご利用ポイント</th>
                    <td><?= $point . 'pt' ?></td>
                </tr>
                <tr class="orange">
                    <th><?= $discountType ?></th>
                    <td><?= '￥' . $discountPrice ?></td>
                </tr>
                <tr class="totalPayment">
                    <th>小計</th>
                    <td><?= '￥' . $totalPayment ?></td>
                </tr>
            </table>
            <div class="oneLine">
                <a class="button delete" href="<?= $this->Url->build(['action' => 'cancel']) ?>">キャンセル</a>
                <a class="button submit" href="<?= $this->Url->build(['action' => 'save']) ?>">決済</a>
            </div>
        </div>
    </div>
</div>
