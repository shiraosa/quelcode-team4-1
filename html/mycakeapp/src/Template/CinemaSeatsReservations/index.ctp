<?php
$this->Html->css('cinemaSeatsReservations', ['block' => true]);
$this->Html->css('seatLayout', ['block' => true]);
$this->Html->script('jquery.js', ['block' => true]);
$this->Html->script('seatLayout/seatLayout.js', ['block' => true]);
$reservedSeatsJson = json_encode($reservedSeatsLayout);
?>

<div class="main">
    <h2 class="innerHeading">座席予約</h2>
    <div class="innerWindow">
        <div class="selectMove"></div>
        <script type="text/javascript">
            var seatData = JSON.parse('<?php echo $reservedSeatsJson; ?>'); //jsonをparseしてJavaScriptの変数に代入
        </script>
        <?= $this->Html->script('seatsReservations.js'); ?>
    </div>
</div>
