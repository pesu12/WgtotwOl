<?php

namespace Anax\Question;

/**
* A controller for users and admin related events.
*
*/
class QuestiontagController implements \Anax\DI\IInjectionAware
{
  use \Anax\DI\TInjectable;

  /**
  * Initialize the controller.
  *
  * @return void
  */
  public function initialize()
  {
    $this->questiontags = new \Anax\Question\Questiontags();
    $this->questiontags->setDI($this->di);
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
  * Display user details.
  *
  * @param integer $id of user to display delete for.
  *
  * @return void
  */

  public function displayuserAction($id = null)
  {
    $this->di->session();
    $form = new \Anax\HTMLForm\CFormPsWebDisplayUser();
    $form->setDI($this->di);
    $form->check();

    $this->di->theme->setTitle("Users Display details Menu");

    $this->di->views->add('default/page', [
      'title' => "Users Display Details Menu",
      'content' => $form->getHTML()
    ]);
  }

  /**
  * Get ussr to update(soft delete).
  *
  * @return void
  */
  public function updateAction()
  {
    $this->di->session();
    $form = new \Anax\HTMLForm\CFormPsWebUpdateUser();
    $form->setDI($this->di);
    $form->check();

    $this->di->theme->setTitle("Users Delete Menu");

    $this->di->views->add('default/page', [
      'title' => "Users Soft Delete (update) Menu",
      'content' => $form->getHTML()
    ]);
  }

  /**
  * List all users.
  *
  * @param string $id user id.
  *
  * @return void
  */
  public function listAction($id=null)
  {
    if($id==null) {
      $all = $this->users->findAll();
      $this->theme->setTitle("List Activated users");
      $this->views->add('users/list-all', [
        'users' => $all,
        'title' => "Users List Menu",
      ]);
    }
    else{
      $user = $this->users->find($id);
      $this->theme->setTitle("List Details for a user");
      $this->views->add('users/view', [
        'user' => $user,
        'title' => "Users List Menu",
      ]);
    }
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
