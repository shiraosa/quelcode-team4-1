<?php
$this->Html->css('point', ['block' => true])
?>

<div class="main">
    <h2 class="innerHeading">ポイント獲得履歴</h2>
    <div class="innerWindow">
        <div class="innerContent">
            <p class="havePoint"><span class="left">ポイント残高</span><span class="right"><?= $point['havePoint'] ?>pt</span></p>

            <?php if (empty($point['info'])) : ?>
                <p class="month">一ヶ月以内に獲得したポイントはありません。</p>
            <?php else : ?>

                <p class="explanation"><span class="getDay">獲得日</span><span>獲得pt</span><span>使用可能pt</span></p>
                <?php foreach ($point['info'] as $info) : ?>
                    <p class="getPoint">
                        <span class="left"><?= date("Y/m/d", strtotime($info->created)) ?></span>
                        <span class="right"><?= $info->get_point ?>pt</span>
                        <?php if ($info->get_point === $info->use_point) : ?>
                            <span class="usePoint red">0pt</span>
                        <?php else : ?>
                            <span class="usePoint"><?= $info->get_point - $info->use_point ?>pt</span>
                        <?php endif; ?>
                    </p>
                <?php endforeach; ?>

                <p class="month">過去１ヶ月に獲得した<br>ポイントを表示しています。</p>

            <?php endif; ?>
            <a class="button bigBtn" href="<?= $this->Url->build(['action' => 'index']) ?>">戻る</a>
        </div>
    </div>
</div>
