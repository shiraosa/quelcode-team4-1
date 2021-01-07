<?php
// 割引を追加したときに表示されるように配列の後ろから(新しい順に)バナーを4つ選択
for ($i = 4; $i >= 1; $i--) {
    $discountsBanner[$i] = array_pop($banners);
}
?>
<?php $this->Html->css('toppage.css', ['block' => true]) ?>
<div class="main">
    <div class="container">
        <ul class="slideshow">
            <li class="slide-item">
                <?php echo $this->Html->image('slideshow/' . $slideshows[0]); ?>
            </li>
            <li class="slide-item">
                <?php echo $this->Html->image('slideshow/' . $slideshows[1]); ?>
            </li>
            <li class="slide-item">
                <?php echo $this->Html->image('slideshow/' . $slideshows[2]); ?>
            </li>
        </ul>
    </div>

    <h2>上映映画一覧</h2>
    <ul class="screening-images">
        <li><?php echo $this->Html->image('screening/' . $screenings[0]); ?></li>
        <li><?php echo $this->Html->image('screening/' . $screenings[1]); ?></li>
        <li><?php echo $this->Html->image('screening/' . $screenings[2]); ?></li>
    </ul>
    <button onclick="location.href = 'CinemaSchedules'" class="btn-sea-details">詳しく見る</button>

    <h2>お得な割引</h2>
    <ul class="discount-banners">
        <li><?php echo $this->Html->image('banner/' . $discountsBanner[1]); ?></li>
        <li><?php echo $this->Html->image('banner/' . $discountsBanner[2]); ?></li>
        <li><?php echo $this->Html->image('banner/' . $discountsBanner[3]); ?></li>
        <li><?php echo $this->Html->image('banner/' . $discountsBanner[4]); ?></li>
    </ul>
    <button onclick="location.href = 'QuelCinemas/price'" class="btn-sea-details">詳しく見る</button>
</div>
