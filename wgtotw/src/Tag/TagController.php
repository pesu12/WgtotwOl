<?php

namespace Anax\Tag;

/**
* A controller for Tag related events.
*
*/
class TagController implements \Anax\DI\IInjectionAware
{
  use \Anax\DI\TInjectable;

  /**
  * Initialize the controller.
  *
  * @return void
  */
  public function initialize()
  {
    $this->tags = new \Anax\Tag\Tag();
    $this->tags->setDI($this->di);

    //User is needed to display name for specific question or response
    $this->users = new \Anax\User\User();
    $this->users->setDI($this->di);

    //UserQuestion is needed to display name for specific question
    $this->userquestion = new \Anax\UserQuestion\UserQuestion();
    $this->userquestion->setDI($this->di);
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
  * List tag with id.
  *
  * @param int $id of tag to display
  *
  * @return void
  */
  public function idAction($id = null)
  {

    $this->tags->theme->addStylesheet('css/anax-grid/style.php');
    $tag = $this->tags->find($id);
    $this->theme->setTitle("Tag");
    $this->views->add('tags/view', [
      'id' => $id,
      'tag' => $tag,
      'title' => "Tag",
    ]);

    $latestquestions = $this->tags->findAllQuestions($id);

    $this->di->views->add('questions/viewtitle', [
      'title' => "Frågor till tag"
    ]);

    foreach ($latestquestions as $question) :
      $Userid = $this->userquestion->findUserToQuestion($question->Id);
      $user = $this->users->find($Userid->Userid);
      $this->views->add('questions/viewwithouttitle', [
        'question' => $question,
        'user' => $user
      ]);
    endforeach;


  }

  /**
  * Index action.
  *
  */
  public function indexAction()
  {

    $all = $this->tags->findAll();

    $this->theme->setTitle("Visa alla taggar");
    $this->views->add('tags/list-all', [
      'tags' => $all,
      'title' => "Visa alla taggar",
    ]);
  }
}
