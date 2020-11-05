<?php

$cakeDescription = 'CakePHP: the rapid development php framework';
?>
<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?= $cakeDescription ?>:
        <?= $this->fetch('title') ?>
    </title>

    <?= $this->Html->css('slick-theme.css') ?>
    <?= $this->Html->css('slick.css') ?>
    <?= $this->Html->css('toppage.css') ?>

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
</head>
<body>
    <?= $this->Flash->render() ?>
    <div class="container clearfix">
        <?= $this->fetch('content') ?>
    </div>
</body>
    <?= $this->Html->script('jquery-3.5.1.min.js') ?>
    <?= $this->Html->script('slick/slick.min.js') ?>
    <?= $this->Html->script('toppage.js') ?>
</html>
