<?php

namespace Anax\UserQuestion;

/**
* A controller for userquestion and related events.
*
*/
class UserQuestionController implements \Anax\DI\IInjectionAware
{
  use \Anax\DI\TInjectable;

  /**
  * Initialize the controller.
  *
  * @return void
  */
  public function initialize()
  {
    $this->userquestions = new \Anax\UserQuestion\UserQuestions();
    $this->userquestions->setDI($this->di);
  }

  /**
  * Add new user.
  *
  * @param string $acronym of user to add.
  *
  * @return void
  */
  public function addAction()
  {
    $this->di->session();
    $form = new \Anax\HTMLForm\CFormQuestionAdd();
    $form->setDI($this->di);
    $form->check();
    $this->di->theme->setTitle("Lägg till fråga");
    $this->di->views->add('default/page', [
      'title' => "Lägg till fråga",
      'content' => $form->getHTML()
    ]);
  }


  /**
  * List question with id and responses that belongs to the question.
  *
  * @param int $id of question to display
  *
  * @return void
  */
  public function idAction($id = null)
  {

    $this->questions->setDI($this->di);
    $allTags = $this->questions->findAllTags($id);
    $this->theme->setTitle("Taggar till frågan");
    $this->views->add('questions/viewtags', [
      'id' => $id,
      'tags' => $allTags,
      'title' => "Taggar till frågan",
    ]);

    $this->questions->setDI($this->di);
    $question = $this->questions->find($id);
    $this->theme->setTitle("Fråga");
    $this->views->add('questions/view', [
      'id' => $id,
      'question' => $question,
      'title' => "Fråga",
    ]);

    $this->questions->setDI($this->di);
    $allResponses = $this->questions->findAllResponses($id);
    $this->theme->setTitle("Svar till frågan");
    $this->views->add('questions/viewresponses', [
      'id' => $id,
      'responses' => $allResponses,
      'title' => "Svar till frågan",
    ]);
  }

  /**
   * Delete user question.
   *
   * @param integer $id of user question to delete.
   *
   * @return void
   */
  public function deleteAction($id = null)
  {
      if (!isset($id)) {
          die("Missing id");
      }
      $res = $this->questions->delete($id);
  }

  /**
  * Index action.
  *
  */
  public function indexAction()
  {

    $all = $this->questions->findAll();

    $this->theme->setTitle("Visa alla frågor");
    $this->views->add('questions/list-all', [
      'questions' => $all,
      'title' => "Visa alla frågor",
    ]);
  }
}
