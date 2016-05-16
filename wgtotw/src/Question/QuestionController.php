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

    //UserQuestion is needed to display name for specific question
    $this->userquestion = new \Anax\UserQuestion\UserQuestion();
    $this->userquestion->setDI($this->di);


    //UserResponse is needed to display name for specific response
    $this->userresponse = new \Anax\MVC\CUserResponseModel();
    $this->userresponse->setDI($this->di);

    //User is needed to display name for specific question or response
    $this->users = new \Anax\User\User();
    $this->users->setDI($this->di);

    //Display tags for question
    $this->tags = new \Anax\Tag\Tag();
    $this->tags->setDI($this->di);
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
    $this->questions->theme->addStylesheet('css/anax-grid/style.php');

    $this->di->session();
    $this->di->views->add('questions/viewtitle', [
      'title' => "Lägg till fråga"
    ]);

    //Add text on how to add tags
    $this->di->views->add('questions/viewtagtext', [
    ]);

    //Display all available tags.
    $taglist=$this->tags->findAll();
    $this->di->views->add('questions/viewtaglist', [
      'tags' => $taglist,
    ]);

    //Create form Question add
    $id = $this->request->getGet('id');
    $form = new \Anax\HTMLForm\CFormQuestionAdd($id);
    $form->setDI($this->di);
    $form->check();
    $this->di->views->add('default/page', [
      'title' => "",
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
      'userid' => $user->Id,
      'username' => $user->Username,
    ]);

    //Display comment to question
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

    //Add comment to question
    //The comment can only be added when the user is logged in.
    $users=$this->users->findAll();
    foreach ($users as $user) :
       $loggedIn=$this->users->checkIfLoggedIn($user->Id);
       if ($loggedIn) {
          $this->di->views->add('questions/viewaddquestioncommentlink', [
            'id' => $id,
            'userid' => $user->Id,
          ]);
       }
    endforeach;

    //Display response to question
    $this->di->views->add('questions/viewtitle', [
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
        'userid' => $Userid->Userid,
        'username' => $user->Username,
      ]);
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
      //Add comment to response
      //The comment can only be added when the user is logged in.
      $users=$this->users->findAll();
      foreach ($users as $user) :
         $loggedIn=$this->users->checkIfLoggedIn($user->Id);
         if ($loggedIn) {
              $this->di->views->add('questions/viewaddresponsecommentlink', [
              'responseid' => $response->Id,
              'userid' => $user->Id,
              'questionId' => $id,
          ]);
         }
      endforeach;
    endforeach;

    //Add response to question
    //The response can only be added when the user is logged in.
    $users=$this->users->findAll();
    foreach ($users as $user) :
       $loggedIn=$this->users->checkIfLoggedIn($user->Id);
       if ($loggedIn) {
          $this->di->views->add('questions/viewaddresponselink', [
            'id' => $id,
            'userid' => $user->Id,
          ]);
       }
    endforeach;
  }

  /**
   * Delete question.
   *
   * @param integer $id of question to delete.
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
  * @return void
  */
  public function indexAction()
  {

    $this->di->views->add('questions/viewtitle', [
      'title' => "Visa alla frågor"
    ]);

    $allquestions = $this->questions->findAll();

    foreach ($allquestions as $question) :
      $Userid = $this->userquestion->findUserToQuestion($question->Id);
      $user = $this->users->find($Userid->Userid);
      $this->views->add('questions/viewwithouttitle', [
        'question' => $question,
        'username' => $user->Username,
        'userid' => $user->Id,
      ]);
    endforeach;

    //The question can only be added when the user is logged in.
    $users=$this->users->findAll();
    $inlogged=false;
    foreach ($users as $user) :
      $loggedIn=$this->users->checkIfLoggedIn($user->Id);
      if ($loggedIn) {
        $inlogged=true;
      }
    endforeach;
    if ($inlogged) {
        $this->di->views->add('questions/viewaddquestionlink', [
          'id' => $user->Id,
        ]);
    }
  }
}
