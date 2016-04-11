<?php

namespace Anax\User;

/**
* A controller for users and admin related events.
*
*/
class UserController implements \Anax\DI\IInjectionAware
{
  use \Anax\DI\TInjectable;

  /**
  * Initialize the controller.
  *
  * @return void
  */
  public function initialize()
  {
    $this->users = new \Anax\User\User();
    $this->users->setDI($this->di);
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
    $form = new \Anax\HTMLForm\CFormPsWebAddUser();
    $form->setDI($this->di);
    $form->check();
    $this->di->theme->setTitle("Users Add Menu");
    $this->di->views->add('default/page', [
      'title' => "Users Add Menu",
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
  * List user with id, questions and responses.
  *
  * @param int $id of user to display
  *
  * @return void
  */
  public function idAction($id = null)
  {
    $this->users->setDI($this->di);
    $this->users->theme->addStylesheet('css/anax-grid/style.php');
    $user = $this->users->find($id);
    $this->theme->setTitle("Användare");
    $this->views->add('users/viewuser', [
      'id' => $id,
      'user' => $user,
      'title' => "Användare",
    ]);

    $this->users->setDI($this->di);
    $all = $this->users->findQuestionsForUser($id);
    $this->theme->setTitle("Mina Ställda Frågor");
    $this->views->add('users/viewuserquestions', [
      'questions' => $all,
      'title' => "Frågor",
    ]);

    $this->users->setDI($this->di);
    $allresponses = $this->users->findResponsesForUser($id);
    $this->theme->setTitle("Mina svar");
    $this->views->add('users/viewuserresponses', [
      'responses' => $allresponses,
      'title' => "Svar",
    ]);
  }
  /**
  * Index action.
  *
  */
  public function indexAction()
  {
    $all = $this->users->findAll();

    $this->theme->setTitle("Visa alla användare");
    $this->views->add('users/list-all', [
      'users' => $all,
      'title' => "Visa alla användare",
    ]);
  }
}
