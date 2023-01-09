<h1>記事の編集</h1>
<?php 
  echo $this->Form->create($article);
  echo $this->Form->control('user_id', ['type' => 'hidden']);
  echo $this->Form->control('title');
  // オプションは通常のHTMLの属性やStyleを付与することができる。
  // 現在のチュートリアルでは、ベースのCSSの影響で高さの設定ができなかったため、Styleを一旦無効化したうえで再設定。
  echo $this->Form->control('body', ['rows' => '10', 'style' => 'height:auto;']);
  echo $this->Form->control('tags._ids', ['options' => $tags, 'size' => 5, 'style' => 'height:auto;']);
  echo $this->Form->button(__('Save Article'));
  echo $this->Form->end();
?>