<?php

namespace Anax\Comment;

/**
 * To attach comments-flow to a page or some content.
 *
 */
class CommentsInSession implements \Anax\DI\IInjectionAware
{
    use \Anax\DI\TInjectable;

    /**
    * Add a new comment.
    *
    * @param array $comment with all details.
    * @param $key with comment page.
    *
    * @return void
    */
    public function add($comment, $key = null)
    {
        $comments = $this->session->get('comments', []);
        $comments[$key][] = $comment;
        $this->session->set('comments', $comments);
    }


    /**
    * Find and return all comments.
    *
    * @param $key with comment page.
    *
    * @return array with all comments.
    */
    public function findAll($key = null)
    {
        $comments = $this->session->get('comments', []);
        return isset($key) ? (isset($comments[$key]) ? $comments[$key] : null) : $comments;
    }

    /**
    * Find a comment.
    *
    * @param $id with comment id number.
    * @param $key with comment page.
    *
    * @return string with the comment.
    */
    public function find($id,$key = null)
    {
        $comments= $this->session->get('comments', []);

        return $comments[$key][$id];
    }

    /**
    * edit a comment.
    *
    * @param array $comment with all details.
    * @param $id with comment id number.
    * @param $key with comment page.
    *
    * @return void
    */
    public function edit($comment,$id,$key = null)
    {
      $comments = $this->session->get('comments', []);
      $editedComment[$key][$id] = $comment;
      return $comment[$key][$id];
    }


    /**
    * edit a comment.
    *
    * @param array $comment with all details.
    * @param $id with comment id number.
    * @param $key with comment page.
    *
    * @return void
    */
    public function saveEdit($comment, $id,$key = null)
    {
      $comments = $this->session->get('comments', []);
      $comments[$key][$id] = $comment;
      $this->session->set('comments', $comments);
    }


    /**
    * delete a comment.
    *
    * @param $id with comment id number.
    * @param $key with comment page.
    *
    * @return void
    */
    public function delete($id,$key = null)
    {
      $comments = $this->session->get('comments', []);

      unset($comments[$key][$id]);
      $this->session->set('comments', $comments);
    }

    /**
    * Delete all comments.
    *
    * @param $key with comment page.
    *
    * @return void
    */
    public function deleteAll($key = null)
    {
      $comments = $this->findAll();
      unset($comments[$key]);
      $this->session->set('comments', $comments);
    }
}
