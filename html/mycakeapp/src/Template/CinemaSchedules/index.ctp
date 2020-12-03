<?= $this->Html->css('cinema_schedules.css', ['block' => true]) ?>
<?= $this->Flash->render() ?>
<?= $this->Html->meta(['link' => 'https://unpkg.com/swiper/swiper-bundle.min.css', 'rel' => 'stylesheet', 'block' => true]) ?>
<?= $this->Html->script('https://unpkg.com/swiper/swiper-bundle.min.js', ['block' => true]) ?>
<h2 class="innerHeading">上映スケジュール</h2>
<div class="swiper-container">
    <div class="swiper-wrapper">
        <div class="swiper-slide">Slide 1</div>
        <div class="swiper-slide">Slide 2</div>
        <div class="swiper-slide">Slide 3</div>
    </div>
    <div class="swiper-button-prev"></div>
    <div class="swiper-button-next"></div>
</div>
<h2 class="innerHeading">上映スケジュール</h2>
<ul class="days">
    <?php foreach ($days as $date => $schedule) : ?>
        <?php foreach ($schedule as $dateJp => $discount) : ?>
            <?= $this->Html->link(
                "<li>$dateJp<br>$discount</li>",
                ['controller' => 'CinemaSchedules', 'action' => 'index', '?' => ['date' => $date]],
                [
                    'escape' => false,
                    'class' => ($date === $nowYmd) ? 'isSelected' : ''
                ]
            ); ?>
        <?php endforeach; ?>
    <?php endforeach; ?>
</ul>
<h2 class="innerHeading-date">
    <?= array_key_first($days[$nowYmd] ?? array_values($days)[0]) ?>
</h2>
<p class="no-schedules"><?= empty($movies) ? 'スケジュールがありません' : '' ?></p>
<?php foreach ($movies as $value) : ?>
    <ul class="schedules">
        <li class="schedules-list">
            <h3 class="schedules-list-title">
                <?= $value['movie']['title'] ?>
                <span class="running-time"><?= $value['movie']['running_time'] ?></span>
                <span class="end-date"><?= $value['movie']['end_date'] ?></span>
            </h3>
            <ul class="schedules-list-detail">
                <li class="">
                    <?= $this->Html->image('thumbnail/' . $value['movie']['thumbnail_path'], ['class' => 'schedules-list-thumbnail']) ?>
                </li>
                <?php foreach ($value['movie']['scheduleSet'] as $id => $startAndEnd) : ?>
                    <?php foreach ($startAndEnd as $start => $end) : ?>
                        <li class="schedules-list-time">
                            <p>
                                <?= $start . '〜' . '<span class="end-time">' . $end . '</span>' ?>
                            </p>
                            <?= $this->Html->link('予約購入', ['controller' => 'CinemaSeatsReservations', 'action' => 'index', $id]); ?>
                        </li>
                    <?php endforeach; ?>
                <?php endforeach; ?>
            </ul>
        </li>
    </ul>
<?php endforeach; ?>
</div>
<?= $this->Html->script('scheduleSwipe') ?>
