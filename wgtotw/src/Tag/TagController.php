<?php

namespace Anax\Tag;

/**
* A controller for users and admin related events.
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

    $this->tags->setDI($this->di);
    $allQuestions = $this->tags->findAllQuestions($id);
    $this->theme->setTitle("Frågor till tag");
    $this->views->add('tags/viewquestions', [
      'id' => $id,
      'questions' => $allQuestions,
      'title' => "Frågor till tag",
    ]);
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
