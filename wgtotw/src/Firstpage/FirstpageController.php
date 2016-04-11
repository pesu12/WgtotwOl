<?php

namespace Anax\Firstpage;

/**
* A controller for Firstpage related events.
*
*/
class FirstpageController implements \Anax\DI\IInjectionAware
{
  use \Anax\DI\TInjectable;

  /**
  * Initialize the controller.
  *
  * @return void
  */
  public function initialize()
  {
    $this->firstpage = new \Anax\Firstpage\Firstpage();
    $this->firstpage->setDI($this->di);

    $this->users = new \Anax\User\User();
    $this->users->setDI($this->di);

    $this->questions = new \Anax\Question\Question();
    $this->questions->setDI($this->di);

    $this->tags = new \Anax\Tag\Tag();
    $this->tags->setDI($this->di);
  }

  /**
  * Index action.
  *
  */
  public function indexAction()
  {

    $activeusers = $this->users->findMostActiveUsers();
    $this->theme->setTitle("Mest aktiva användare");
    $this->views->add('users/listactiveusers', [
      'users' => $activeusers,
      'title' => "Mest aktiva användare",
    ]);

    $latestquestions = $this->questions->findLatestQuestions();
    $this->theme->setTitle("Senaste frågan");
    $this->views->add('questions/viewlatestquestion', [
      'questions' => $latestquestions,
      'title' => "Senaste frågan",
    ]);

    $all = $this->tags->findMostPopularTag();
    $this->theme->setTitle("Mest populära tag");
    $this->views->add('tags/mostpopulartag', [
      'tags' => $all,
      'title' => "Mest populära tag",
    ]);

  }
}
