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
      $form = new \Anax\HTMLForm\CFormQuestionCommentAdd($_GET['id'],$_GET['userid']);
      $form->setDI($this->di);
      $form->check();
      $this->di->theme->setTitle("Lägg till kommentar till en fråga");
      $this->di->views->add('default/page', [
        'title' => "Lägg till kommentar till en fråga",
        'content' => $form->getHTML()
      ]);
    }

    if($_GET['type'] === "response") {
      $form = new \Anax\HTMLForm\CFormResponseCommentAdd($_GET['id'],$_GET['userid']);
      $form->setDI($this->di);
      $form->check();
      $this->di->theme->setTitle("Lägg till kommentar till ett svar");
      $this->di->views->add('default/page', [
        'title' => "Lägg till kommentar till ett svar",
        'content' => $form->getHTML()
      ]);
    }
  }
}
