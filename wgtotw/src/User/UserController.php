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
    $this->users->theme->addStylesheet('css/anax-grid/style.php');
    $form = new \Anax\HTMLForm\CFormPsWebAddUser();
    $form->setDI($this->di);
    $form->check();
    $this->di->theme->setTitle("Lägg till ny användare");
    $this->di->views->add('default/page', [
      'title' => "Lägg till ny användare",
      'content' => $form->getHTML()
    ]);
  }

  /**
   *login with user.
   *
   * @param string $acronym of user to add.
   *
   * @return void
   */
  public function loginAction()
  {
     $this->di->session();
     $this->users->theme->addStylesheet('css/anax-grid/style.php');
     $form = new \Anax\HTMLForm\CFormAdminLoginUser();
     $form->setDI($this->di);
     $form->check();
     $this->di->theme->setTitle("Logga in");
     $this->di->views->add('default/page', [
       'title' => "Logga in",
       'content' => $form->getHTML()
     ]);

     $this->di->views->add('users/viewaddnewuserlink', [
       'title' => ""
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
      $this->views->add('users/viewuserupdatelink', [
        'id' => $id,
        'title' => "",
      ]);
/*
    $this->users->setDI($this->di);
    $all = $this->users->findQuestionsForUser($id);
    $this->theme->setTitle("Ställda frågor av användare");
    $this->views->add('users/viewuserquestions', [
      'questions' => $all,
      'title' => "Ställda frågor av användaren",
    ]);
*/
    $this->users->setDI($this->di);
    $this->views->add('users/viewaddquestionlink', [
      'id' => $id,
      'title' => "",
    ]);
/*
    $this->users->setDI($this->di);
    $allresponses = $this->users->findResponsesForUser($id);
    $this->theme->setTitle("Mina svar");
    foreach ($allresponses as $response) :
       $questionId = $this->users->findRequestForResponse($response->Id);
       $this->views->add('users/viewuserresponses', [
         'response' => $response,
         'questionid' => $questionId->Questionid,
         'title' => "",
       ]);
    endforeach;
*/
    $this->users->setDI($this->di);
    $this->views->add('users/viewaddresponselink', [
      'id' => $id,
      'title' => "",
    ]);

    $this->users->setDI($this->di);
    $this->views->add('users/viewaddquestioncommentlink', [
      'title' => "",
    ]);

    $this->users->setDI($this->di);
    $this->views->add('users/viewaddresponsecommentlink', [
      'title' => "",
    ]);

    $this->di->views->add('users/viewlogoutlink', [
      'title' => ""
    ]);
  }

  /**
  * Add new question for user.
  *
  * @param string $id of user to add.
  *
  * @return void
  */
  public function addQuestionAction($id = null)
  {
    $this->di->session();
    $this->users->theme->addStylesheet('css/anax-grid/style.php');
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
  * Get ussr to update.
  *
  * @return void
  */
  public function updateAction()
  {
    $this->users->theme->addStylesheet('css/anax-grid/style.php');
    $users = new \Anax\MVC\CUserModel();
    $users->setDI($this->di);
    $user = $this->users->find($_GET['id']);
    $form = new \Anax\HTMLForm\CFormPsWebUpdateUser($user);
    $form->setDI($this->di);
    $form->check();

    $this->di->views->add('default/page', [
        'title' => "Uppdatera användare",
        'content' => $form->getHTML()
    ]);

    $this->di->views->add('users/notupdatepassword', [
      'title' => ""
    ]);
  }

  /**
* Save an editid user.
*
* @param $id with user id number.
*
* @return void
*/
public function saveEditAction($id)
{
  $isPosted = $this->request->getPost('doSaveEdit');

  if (!$isPosted) {
    $this->response->redirect($this->request->getPost('redirect'));
  }

  $users = new \Anax\MVC\CUserModel();
  $users->setDI($this->di);

  $editedUser = [
    'Id' => $id,
    'Username'      => $this->request->getPost('Username'),
    'Acronym'       => $this->request->getPost('Acronym'),
    'Email'      => $this->request->getPost('Email'),
    'Userpassword'      => 'test',
  ];

  $users->update($editedUser);

//  $this->response->redirect($this->request->getPost('redirect'));
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
    foreach ($allresponses as $response) :
       $questionId = $this->users->findRequestForResponse($response->Id);
       $this->views->add('users/viewuserresponses', [
         'response' => $response,
         'questionid' => $questionId->Questionid,
         'title' => "",
       ]);
    endforeach;
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
