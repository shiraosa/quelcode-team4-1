<?php
$this->Html->css('cinemaSeatsReservations', ['block' => true]);
$this->Html->css('seatLayout', ['block' => true]);
$this->Html->script('jquery.js', ['block' => true]);
$this->Html->script('seatLayout/seatLayout.js', ['block' => true]);
$reservedSeatsJson = json_encode($reservedSeatsLayout);
?>

<div class="main">
    <h2 class="innerHeading">座席予約</h2>
    <div class="schedule">
        <p><?= $schedule['movie']['title'] ?></p>
        <p><?= $schedule['start'] ?>~<span class="endTime"><?= $schedule['end'] ?></span></p>
    </div>
    <div class="innerWindow">
        <p class="screen">SCREEN</p>
        <form method="POST">
            <div class="selectMove"></div>
            <script type="text/javascript">
                var scheduleId = '<?php echo $scheduleId ?>';
                var seatData = JSON.parse('<?php echo $reservedSeatsJson; ?>'); //jsonをparseしてJavaScriptの変数に代入
            </script>
            <input type="hidden" name="_csrfToken" value="<?= $this->request->getParam('_csrfToken') ?>">
            <?= $this->Html->script('seatsReservations.js'); ?>
        </form>
    </div>
</div>
