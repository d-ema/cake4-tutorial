<?php
namespace App\controller;

use App\Model\Entity\Article;

/**
 * Articles用のコントローラーのファイル
 *
 * @property \App\Model\Table\ArticlesTable $Articles
 */
class ArticlesController extends AppController
{

  public function initialize(): void
  {
    parent::initialize();

    $this->loadComponent('Paginator');
    $this->loadComponent('Flash');
  }

  public function index()
  {
    $this->loadComponent('Paginator');
    $articles = $this->Paginator->paginate($this->Articles->find());
    $this->set(compact('articles'));
  }

  public function view($slug = null)
  {
    $article = $this->Articles->findBySlug($slug)->firstOrFail();
    $this->set(compact('article'));
  }

  public function add()
  {
    $article = $this->Articles->newEmptyEntity();

    if($this->request->is('post')) {
      $article = $this->Articles->patchEntity($article, $this->request->getData());
      $article->user_id = 1;

      if ($this->Articles->save($article)) {
        $this->Flash->success(__('Your article has been saved.'));
        return $this->redirect(['action' => 'index']);
      }
      $this->Flash->error(__('Unable to add your article.'));
    }
    $tags = $this->Articles->Tags->find('list')->all();

    $this->set('tags', $tags);
    $this->set('article', $article);
  }

  public function edit($slug)
  {
    // TODO: SQLがどうなっているのか調べる
    $article = $this->Articles
        ->findBySlug($slug)
        ->contain('Tags')
        ->firstOrFail();

    if ($this->request->is(['post', 'put'])) {
      $this->Articles->patchEntity($article, $this->request->getData());
      if ($this->Articles->save($article)) {
        // TODO: __の意味を調べる
        $this->Flash->success(__('Your article has been updated.'));
        return $this->redirect(['action' => 'index']);
      }
      $this->Flash->error(__('Unable to update article.'));
    }
    $tags = $this->Articles->Tags->find('list')->all();

    // TODO: memo：コントローラーのセットは複数可能
    $this->set('tags', $tags);
    $this->set('article', $article);
  }

  public function delete($slug)
  {
    $this->request->allowMethod(['post', 'delete']);

    $article = $this->Articles->findBySlug($slug)->firstOrFail();
    if ($this->Articles->delete($article)) {
      echo $this->Flash->success(__('The {0} article has been delete.', $article->title));
      return $this->redirect(['action' => 'index']);
    }
  }

  public function tags()
  {
    // 'pass'キーはCakePHPによって提供され、リクエストに渡された全てのURLパスセグメントを含みます。
    $tags = $this->request->getParam('pass');

    // ArticleTableを使用してタグ付きの記事を検索します。
    $articles = $this->Articles->find('tagged', ['tags' => $tags])->all();

    // 変数をビューテンプレートのコンテキストに渡します。
    $this->set([
      'articles' => $articles,
      'tags' => $tags
    ]);
    
  }

}

