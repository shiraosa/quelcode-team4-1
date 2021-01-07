<?php $this->Html->css('cinema.css', ['block' => true]) ?>
<div class="innerWindow-done">
    <h2 class="innerHeading-done">会員登録完了</h2>
    <div class="innerParagraphs">
        <p class="innerParagraph">ご登録ありがとうございました。</p>
        <p class="innerParagraph">メールアドレスに登録完了メールを送信いたしました。</p>
    </div>
    <?= $this->Html->link(__('トップへ戻る'), ['controller' => 'QuelCinemas', 'action' => 'index']); ?>
</div>
