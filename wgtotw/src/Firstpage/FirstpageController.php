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

    $this->questiontags = new \Anax\Questiontag\Questiontag();
    $this->questiontags->setDI($this->di);

    $this->userquestion = new \Anax\UserQuestion\UserQuestion();
    $this->userquestion->setDI($this->di);

    $this->userresponse = new \Anax\UserResponse\UserResponse();
    $this->userresponse->setDI($this->di);

    $this->comment = new \Anax\Comment\Comment();
    $this->comment->setDI($this->di);
  }

  /**
  * Index action.
  *
  * @return void
  */
  public function indexAction()
  {
    $popularuser = array();
    //For Most active users
    //Get UserId for all UserQuestions and add them to $popularuser list.
    $alluserquestions=$this->userquestion->findAll();
    foreach ($alluserquestions as $popularuserquestion) :
      array_push($popularuser,$popularuserquestion->Userid);
    endforeach;
    //Get UserId for all UserResponses and add them to $popularuser list.
    $alluserresponses=$this->userresponse->findAll();
    foreach ($alluserresponses as $popularuserresponse) :
      array_push($popularuser,$popularuserresponse->Userid);
    endforeach;

    //Get userId for all comments and add them to $popularuser list.
    $allcomments=$this->comment->findAll();
    foreach ($allcomments as $popularusercomments) :
      array_push($popularuser,$popularuserresponse->Userid);
    endforeach;

    //Buid a list with the keys and the values
    $popularuserlist=(array_count_values($popularuser));

    //Sort the list
    arsort($popularuserlist);

    //Extract the keys
    $k = array_keys($popularuserlist);

    //Display the first two keys as userId and UserNames
    $this->di->views->add('firstpage/viewtitle', [
      'title' => "Mest aktiva användare"
    ]);

    for ($i=0;$i<2;$i++) {
      $activeusers = $this->users->find($k[$i]);
      $this->views->add('firstpage/listactiveusers', [
        'userid' => $activeusers->Id,
        'username' => $activeusers->Username,
        'title' => "",
      ]);
    }


    //For the 2 latest questions
    $latestquestions = $this->questions->findLatestQuestions();
    $this->di->views->add('firstpage/viewtitlelatestquestions', [
      'title' => "Senaste frågorna"
    ]);

    foreach ($latestquestions as $question) :
      $Userid = $this->userquestion->findUserToQuestion($question->Id);
      $user = $this->users->find($Userid->Userid);
      $this->views->add('firstpage/viewwithouttitle', [
        'question' => $question,
        'userid' => $user->Id,
        'username' => $user->Username,
      ]);
    endforeach;

    //Display 2 most popular tags
    $this->di->views->add('firstpage/viewtitle', [
      'title' => "Mest populära taggarna"
    ]);

    $questiontags = $this->questiontags->findMostPopularTag();
    foreach ($questiontags as $questiontag) :
      $tag = $this->tags->find($questiontag->Tagid);
      $this->views->add('firstpage/mostpopulartag', [
        'tagid' => $questiontag->Tagid,
        'tagname' => $tag->Tagname,
      ]);
    endforeach;
  }
}
