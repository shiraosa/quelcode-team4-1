<?php
    // ポイント機能は任意のため、仮定0pt
    $this->Html->css('mypage',['block' => true]);
?>

<div class="main">
    <h2 class="innerHeading">マイページ</h2>
    <div class="innerWindow">
        <table class="mypageTable">
            <tr><th class="tableFont">ポイント</th><td class="tableFont"><?= $point . 'pt' ?></td></tr>
            <tr><th class="tableFont">予約確認</th><td><button onclick="" class="reservationCheckBtn button">詳細</button></td></tr>
            <?php if (empty($cardNumLast4)): ?>
                <tr><th class="tableFont">決済情報</th><td><button onclick="" class="cardInputBtn button">登録する</button></td></tr>
            <?php else: ?>
                <tr><th class="tableFont">決済情報</th><td><span class="tableFont cardNumLast4"><?= $cardNumLast4 ?></span> <button onclick="" class="cardChangeBtn button">変更</button></td></tr>
            <?php endif; ?>
        </table>
    </div>
    <!-- 仕様によりアカウント削除ページなしのためリンクなし -->
    <a href="#" class="deleteLink">アカウントを削除</a>
</div>
