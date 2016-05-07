<?php

namespace Anax\Question;

/**
* A controller for question related events.
*
*/
class QuestionController implements \Anax\DI\IInjectionAware
{
  use \Anax\DI\TInjectable;

  /**
  * Initialize the controller.
  *
  * @return void
  */
  public function initialize()
  {
    $this->questions = new \Anax\Question\Question();
    $this->questions->setDI($this->di);
  }

  /**
  * Add new question.
  *
  * @param string $acronym of user to add.
  *
  * @return void
  */
  public function addAction()
  {
    $id = $this->request->getGet('id');
    $this->di->session();
    $form = new \Anax\HTMLForm\CFormQuestionAdd($id);
    $form->setDI($this->di);
    $form->check();
    $this->di->theme->setTitle("Lägg till fråga");
    $this->di->views->add('default/page', [
      'title' => "Lägg till fråga",
      'content' => $form->getHTML()
    ]);
  }


  /**
  * Display question details.
  *
  * @param integer $id of user to display delete for.
  *
  * @return void
  */

  public function displayuserAction()
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
  * List all questions.
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
    //UserQuestion is needed to display name for specific question
    $this->userquestion = new \Anax\UserQuestion\UserQuestion();
    $this->userquestion->setDI($this->di);

    //UserResponse is needed to display name for specific response
    $this->userresponse = new \Anax\MVC\CUserResponseModel();
    $this->userresponse->setDI($this->di);

    //UserQuestion is needed to display name for specific question or response
    $this->users = new \Anax\User\User();
    $this->users->setDI($this->di);

    //Display tag
    $this->questions->theme->addStylesheet('css/anax-grid/style.php');
    $this->questions->setDI($this->di);
    $allTags = $this->questions->findAllTags($id);
    $this->theme->setTitle("Taggar till frågan");
    $this->views->add('questions/viewtags', [
      'id' => $id,
      'tags' => $allTags,
      'title' => "Taggar till frågan",
    ]);

    //Display question
    $question = $this->questions->find($id);
    $Userid = $this->userquestion->findUserToQuestion($question->Id);
    $user = $this->users->find($Userid->Userid);

    $this->theme->setTitle("Fråga");
    $this->views->add('questions/view', [
      'id' => $id,
      'question' => $question,
      'title' => "Fråga",
      'user' => $user,
    ]);

    //Display comment to question
    $this->di->views->add('questions/displayheader', [
      'title' => "Kommentar till fråga"
    ]);
    $this->questions->setDI($this->di);
    $comments = $this->questions->findallquestioncomments($id);
    foreach ($comments as $comment) :
       $user=$this->users->find($comment->UserId);
       $this->views->add('questions/viewcomments', [
         'id' => $id,
         'comment' => $comment,
         'userid' => $user->Id,
         'username' => $user->Username,
       ]);
    endforeach;

    //Display response to question
    $this->di->views->add('questions/displayheader', [
      'title' => "Svar till frågan"
    ]);
    $this->questions->setDI($this->di);
    $responses = $this->questions->findAllResponses($id);
    foreach ($responses as $response) :
      $Userid = $this->userresponse->findUserToResponse($response->Id);
      $user = $this->users->find($Userid->Userid);
      $this->views->add('questions/viewresponses', [
        'id' => $id,
        'response' => $response,
        'userid' => $user->Id,
        'username' => $user->Username,
      ]);
    endforeach;


    //Display comment to response
    $this->di->views->add('questions/displayheader', [
      'title' => "Kommentar till svar"
    ]);
    $this->questions->setDI($this->di);
    $allResponses = $this->questions->findAllResponses($id);
    foreach ($allResponses as $response) :
      $comments = $this->questions->findallResponsecomments($response->Id);
      foreach ($comments as $comment) :
         $user=$this->users->find($comment->UserId);
         $this->views->add('questions/viewcomments', [
           'id' => $id,
           'comment' => $comment,
           'userid' => $user->Id,
           'username' => $user->Username,    
         ]);
      endforeach;
    endforeach;

  }

  /**
  * Index action.
  *
  */
  public function indexAction()
  {

    $this->di->views->add('questions/displayheader', [
      'title' => "Visa alla frågor"
    ]);

    $allquestions = $this->questions->findAll();

    $this->userquestion = new \Anax\UserQuestion\UserQuestion();
    $this->userquestion->setDI($this->di);
    $this->users = new \Anax\User\User();
    $this->users->setDI($this->di);

    foreach ($allquestions as $question) :
      $Userid = $this->userquestion->findUserToQuestion($question->Id);
      $user = $this->users->find($Userid->Userid);
      $this->views->add('questions/viewwithouttitle', [
        'question' => $question,
        'user' => $user
      ]);
    endforeach;
  }
}
