<?php
$this->Html->css('reservationDetails', ['block' => true]);
?>

<div id="modalOverlay">
    <div id="modalContent" class="innerWindow">
        <p>本当にこの予約をキャンセルしますか？</p>
        <div class="oneLine">
            <button id="modalClose" class="button deleteCancel">戻る</button>
            <a class="button delete" href="<?= $this->Url->build(['action' => 'delete']) ?>">削除</a>
        </div>
    </div>
</div>

<div class="main">
    <h2 class="innerHeading">予約詳細</h2>
    <div class="innerWindow">
        <? if (empty($tickets)) : ?>
        <p>現在予約はありません</p>
        <? else : ?>
        <div class="detail">
            <? $i = -1; ?>
            <? foreach ($tickets as $ticket) : ?>
            <? if (($i === -1) || (($tickets[$i]['title'] === $ticket['title']) && ($tickets[$i]['start_date'] === $ticket['start_date']) && ($tickets[$i]['start_time'] === $ticket['start_time']))) : ?>
            <div class="oneTicket">
                <? else : ?>
                <div class="oneTicket anotherMovie">
                    <? endif; ?>
                    <?= $this->Html->image('thumbnail/' . $ticket['thumbnail_path']) ?>
                    <div class="center">
                        <div class="title"><?= $ticket['title'] ?></div>
                        <div class="dateAndSeat">
                            <?= $ticket['start_date'] ?><?= $ticket['start_time'] ?><span>〜</span><?= $ticket['end_time'] ?><?= '　' . $ticket['seat'] ?>
                        </div>
                        <div class="feeAndDiscount">
                            <div class="fee"><?= '￥' . number_format($ticket['fee']) ?></div>
                            <? if (!empty($ticket['discount_type'])) : ?>
                            <div class="discount"><?= $ticket['discount_type'] ?></div>
                            <? endif; ?>
                        </div>
                    </div>
                    <div class="cancel">
                        <?= $this->Form->button('キャンセル', ['class' => 'modalOpen cancel-btn takeId', 'data-id' => $ticket['id'], 'type' => 'button']) ?>
                    </div>
                </div>
                <? $i ++ ; ?>
                <? endforeach; ?>
            </div>
            <? endif; ?>
            <a class="button bigBtn" href="<?= $this->Url->build(['controller' => 'Mypage']) ?>">マイページへ戻る</a>
        </div>

    </div>
    <?= $this->Html->script('jquery-3.5.1.min.js') ?>
    <?= $this->Html->script('modal.js') ?>

<script type="text/javascript">
    $('.takeId').on('click', function() {
        var click = $(this).data('id');
        // console.log(click);
    })
</script>
