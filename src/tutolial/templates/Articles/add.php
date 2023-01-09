<h1>記事の追加</h1>
<?php
  echo $this->Form->create($article);
  echo $this->Form->control('user_id', ['type' => 'hidden', 'value' => 1]);
  echo $this->Form->control('title');
  // echo $this->Form->control('body', ['row' => '3']);
  // echo $this->Form->control('tags._ids', ['options' => $tags]);
  echo $this->Form->control('body', ['rows' => '10', 'style' => 'height:auto;']);
  echo $this->Form->control('tags._ids', ['options' => $tags, 'size' => 5, 'style' => 'height:auto;']);

  echo $this->Form->button(__('Save Article'));
  echo $this->Form->end();
?>