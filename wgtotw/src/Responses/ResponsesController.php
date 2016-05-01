<?php

namespace Anax\Responses;

/**
 * A controller for responses related events.
 *
 */
class ResponsesController implements \Anax\DI\IInjectionAware
{
    use \Anax\DI\TInjectable;

    /**
     * Initialize the controller.
     *
     * @return void
     */
    public function initialize()
    {
        $this->responses = new \Anax\Responses\Responses();
        $this->responses->setDI($this->di);
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
       $id = $this->request->getGet('id');
       $this->di->session();
       $form = new \Anax\HTMLForm\CFormResponseAdd($id);
       $form->setDI($this->di);
       $form->check();
       $this->di->theme->setTitle("Svara på fråga");
       $this->di->views->add('default/page', [
         'title' => "Svara på fråga",
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
/*
       $this->questions->setDI($this->di);
       $this->theme->setTitle("Lägg till nytt svar");
       $this->views->add('questionresponses/viewaddresponselink', [
         'id' => $id,
         'title' => "Lägg till nytt svar",
       ]);
*/
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
