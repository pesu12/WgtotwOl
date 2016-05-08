<?php
namespace Anax\HTMLForm;
/**
* Anax base class for wrapping sessions.
*
*/
class CFormQuestionAdd extends \Anax\HTMLForm\CForm
{
  use \Anax\DI\TInjectionaware,
  \Anax\MVC\TRedirectHelpers;
  /**
  * Constructor
  *
  */
  public function __construct($id)
  {

    $_POST['addid']=$id;

    parent::__construct([], [
      'addheader' => [
        'type'        => 'text',
        'label'       => 'Titel för fråga:',
        'required'    => true,
        'validation'  => ['not_empty'],
      ],

      'addquestion' => [
        'type'        => 'text',
        'label'       => 'Fråga:',
        'required'    => true,
        'validation'  => ['not_empty'],
      ],

      'addtag' => [
        'type'        => 'text',
        'label'       => 'Tag:',
        'required'    => true,
        'validation'  => ['not_empty'],
      ],

      'submit' => [
        'type'      => 'submit',
        'callback'  => [$this, 'callbackSubmit'],
      ],
    ]);
  }

  /**
  * Customise the check() method.
  *
  * @param callable $callIfSuccess handler to call if function returns true.
  * @param callable $callIfFail    handler to call if function returns true.
  */
  public function check($callIfSuccess = null, $callIfFail = null)
  {
    return parent::check([$this, 'callbackSuccess'], [$this, 'callbackFail']);
  }

  /**
  * Callback for submit-button.
  *
  * @param $form.
  */
  public function callbackSubmit($form)
  {
    $form->AddOutput("<p><i>DoSubmit(): Form was submitted</i></p>");
    $form->saveInSession = true;
    return true;
  }

  /**
  * Callback for submit-button.
  *
  * @param $form.
  */
  public function callbackSubmitFail($form)
  {
    $form->AddOutput("<p><i>DoSubmitFail(): Form was submitted but I failed to process/save/validate it</i></p>");
    return false;
  }

  /**
  * Callback What to do if the form was submitted?
  *
  * @param $form.
  */
  public function callbackSuccess($form)
  {
    $this->filter = new \Anax\Content\CTextFilter();
    $this->questions = new \Anax\Question\Question();
    $this->questions->setDI($this->di);
    $this->questions->save([
      'Questionheader' => $this->filter->markdown($_POST['addheader']),
      'Questionname' => $this->filter->markdown($_POST['addquestion']),
    ]);

    $latestquestion=$this->questions->lastInsertedId();

    $this->userquestion = new \Anax\UserQuestion\UserQuestion();
    $this->userquestion->setDI($this->di);
    $this->userquestion->save([
      'Userid' => $_POST['addid'],
      'Questionid' => $latestquestion,
    ]);

    $this->tags = new \Anax\Tag\Tag();
    $this->tags->setDI($this->di);

    $this->questiontag = new \Anax\Questiontag\Questiontag();
    $this->questiontag->setDI($this->di);

    //If only one tag is specified
    $containkommas = strpos($_POST['addtag'], ",");
    if ($containkommas == false) {
      $tagId=$this->tags->findIdForTag($_POST['addtag']);
      $this->questiontag->save([
        'Questionid' => $latestquestion,
        'Tagid' => $tagId->Id,
      ]);
      //If several tags were specified with kommas in between
    } else {
      $tags = explode( ',', $_POST['addtag'] );
      foreach ($tags as $tag) :
        $tagId=$this->tags->findIdForTag($tag);
        $this->questiontag->create([
          'Questionid' => $latestquestion,
          'Tagid' => $tagId->Id,
        ]);
      endforeach;
    }

    $this->redirectTo('index.php/Question');
  }

  /**
  * Callback What to do when form could not be processed?
  *
  * @param $form.
  */
  public function callbackFail($form)
  {
    $form->AddOutput("<p><i>Incorrect type of input in a field, see detailed info under the field that was incorrect.</i></p>");
    $this->redirectTo();
  }

  /**
  * Redirect to current or another route.
  *
  * @param string $route the route to redirect to,
  * null to redirect to current route, "" to redirect to baseurl.
  *
  * @return void
  */
  public function redirectTo($route = null)
  {
    if (is_null($route)) {
      $url = $this->di->request->getCurrentUrl();
    } else {
      $url = $this->di->url->create($route);
    }
    $this->di->response->redirect($url);
  }
}
