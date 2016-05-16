<?php

namespace Anax\Comment;

/**
* To attach question-comments to a page or a question
*
*/
class CommentController implements \Anax\DI\IInjectionAware
{
  use \Anax\DI\TInjectable;

  /**
  * Add a comment.
  *
  * @return void
  */
  public function addAction()
  {
    $this->di->session();
    if($_GET['type'] === "question") {

      $this->di->session();
      $this->di->views->add('comment/viewtitle', [
        'title' => "Lägg till kommentar till en fråga"
      ]);

      $form = new \Anax\HTMLForm\CFormQuestionCommentAdd($_GET['id'],$_GET['userid']);
      $form->setDI($this->di);
      $form->check();
      $this->di->theme->setTitle("");
      $this->di->views->add('default/page', [
        'title' => "",
        'content' => $form->getHTML()
      ]);
    }

    if($_GET['type'] === "response") {
      $this->di->session();
      $this->di->views->add('comment/viewtitle', [
        'title' => "Lägg till kommentar till ett svar"
      ]);
      $form = new \Anax\HTMLForm\CFormResponseCommentAdd($_GET['id'],$_GET['userid'],$_GET['questionid']);
      $form->setDI($this->di);
      $form->check();;
      $this->di->views->add('default/page', [
        'title' => "",
        'content' => $form->getHTML()
      ]);
    }
  }
}
