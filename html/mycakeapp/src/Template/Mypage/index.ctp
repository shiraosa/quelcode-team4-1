<?php
$this->Html->css('mypage', ['block' => true]);
?>

<div id="modalOverlay">
    <div id="modalContent" class="innerWindow">
        <p>本当にこのアカウントを削除しますか？</p>
        <div class="oneLine">
            <button id="modalClose" class="button deleteCancel">戻る</button>
            <a class="button delete" href="<?= $this->Url->build(['action' => 'delete']) ?>">削除</a>
        </div>
    </div>
</div>

<div class="main">
    <h2 class="innerHeading">マイページ</h2>
    <div class="innerWindow">
        <table class="mypageTable">
            <tr>
                <th class="tableFont">ポイント</th>
                <td class="tableFont"><?= $point . 'pt' ?></td>
            </tr>
            <tr>
                <th class="tableFont">予約確認</th>
                <td><a href="<?= $this->Url->build(['controller' => 'ReservationDetails']) ?>" class="reservationCheckBtn button">詳細</a></td>
            </tr>
            <?php if (0 === $cardNumLast4) : ?>
                <tr>
                    <th class="tableFont">決済情報</th>
                    <td><a href="<?= $this->Url->build(['controller' => 'CinemaCreditcard', 'action' => 'add']) ?>" class="cardInputBtn button">登録する</a></td>
                </tr>
            <?php else : ?>
                <tr>
                    <th class="tableFont">決済情報</th>
                    <td><span class="tableFont cardNumLast4"><?= $cardNumLast4 ?></span><a href="<?= $this->Url->build(['controller' => 'CinemaCreditcard', 'action' => 'index']) ?>" class="cardChangeBtn button">変更</a></td>
                </tr>
            <?php endif; ?>
        </table>
    </div>
    
    <a href="#" id="modalOpen" class="modalOpen deleteLink">アカウントを削除</a>
</div>

<?= $this->Html->script('jquery-3.5.1.min.js') ?>
<?= $this->Html->script('modal.js') ?>
