<?php

namespace Anax\Comment;

/**
 * To attach comments-flow to a page or some content.
 *
 */
class CommentController implements \Anax\DI\IInjectionAware
{
    use \Anax\DI\TInjectable;

    /**
    * View all comments.
    *
    * @param $key with comment page.
    *
    * @return void
    */
    public function viewAction($key = null)
    {
        $comments = new CommentsInSession();
        $comments->setDI($this->di);

        $all = $comments->findAll($key);

        $this->views->add('comment/comments', [
            'comments' => $all,
            'key' => $key,
        ]);
    }



    /**
    * Add a comment.
    *
    * @return void
    */
    public function addAction()
    {
        $isPosted = $this->request->getPost('doCreate');

        if (!$isPosted) {
            $this->response->redirect($this->request->getPost('redirect'));
        }

        $comment = [
            'content'   => $this->request->getPost('content'),
            'name'      => $this->request->getPost('name'),
            'web'       => $this->request->getPost('web'),
            'mail'      => $this->request->getPost('mail'),
            'timestamp' => time(),
            'ip'        => $this->request->getServer('REMOTE_ADDR'),
            'key'       => $this->request->getPost('pageKey'),
        ];

        $comments = new CommentsInSession();
        $comments->setDI($this->di);

        $key = $this->request->getPost('pageKey');
        $comments->add($comment,$key);

        $this->response->redirect($this->request->getPost('redirect'));
    }

    /**
    * Edit a comment.
    *
    * @return void
    */
    public function editAction()
    {

      $comments = new CommentsInSession();
      $comments->setDI($this->di);

      $id = $this->request->getGet('id');
      $key = $this->request->getGet('pageKey');
      //Find comment for the id
      $comment=$comments->find($id,$key);

      $this->theme->setTitle("Edit");

      $this->views->add('comment/edit', [
          'content'   => $comment['content'],
          'name'      => $comment['name'],
          'web'       => $comment['web'],
          'mail'      => $comment['mail'],
          'timestamp' => time(),
          'ip'        => $this->request->getServer('REMOTE_ADDR'),
          'id'        => $id,
          'key'       => $this->request->getGet('pageKey'),
      ]);

      //To Display byline
      $byline = $this->fileContent->get('byline.md');
      $byline = $this->textFilter->doFilter($byline, 'shortcode, markdown');
      $this->views->add('me/pagebyline', [
          'byline' => $byline,
      ]);
  }

    /**
    * Save an editid comment.
    *
    * @param $id with comment id number.
    *
    * @return void
    */
    public function saveEditAction($id)
    {
      $isPosted = $this->request->getPost('doSaveEdit');

      if (!$isPosted) {
        $this->response->redirect($this->request->getPost('redirect'));
      }

      $comments = new CommentsInSession();
      $comments->setDI($this->di);

      $editedComment = [
        'content'   => $this->request->getPost('content'),
        'name'      => $this->request->getPost('name'),
        'web'       => $this->request->getPost('web'),
        'mail'      => $this->request->getPost('mail'),
        'timestamp' => time(),
        'key'       => $this->request->getPost('pageKey'),
      ];

      $key = $this->request->getPost('pageKey');

      $comments->saveEdit($editedComment, $id,$key);

      $this->response->redirect($this->request->getPost('redirect'));
    }

    /**
    * Remove a comment.
    *
    * @return void
    */
    public function removeAction()
    {
      $comments = new CommentsInSession();
      $comments->setDI($this->di);

      $key = $this->request->getGet('pageKey');
      $id = $this->request->getGet('id');
      $comments->delete($id,$key);
      $this->response->redirect($this->request->getGet('redirect'));
    }


    /**
    * Remove all comments.
    *
    * @return void
    */
    public function removeAllAction()
    {
        $isPosted = $this->request->getPost('doRemoveAll');

        if (!$isPosted) {
            $this->response->redirect($this->request->getPost('redirect'));
        }

        $comments = new CommentsInSession();
        $comments->setDI($this->di);

        $key = $this->request->getPost('pageKey');
        $comments->deleteAll($key);

        $this->response->redirect($this->request->getPost('redirect'));
    }
}
