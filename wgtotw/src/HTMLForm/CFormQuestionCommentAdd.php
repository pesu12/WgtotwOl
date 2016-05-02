<?php
namespace Anax\HTMLForm;
/**
 * Anax base class for wrapping sessions.
 *
 */
class CFormQuestionCommentAdd extends \Anax\HTMLForm\CForm
{
  use \Anax\DI\TInjectionaware,
      \Anax\MVC\TRedirectHelpers;
  /**
   * Constructor
   *
   */
   public function __construct()
   {

     parent::__construct([], [
       'addquestion' => [
           'type'        => 'text',
           'label'       => 'Fråga:',
           'required'    => true,
           'validation'  => ['not_empty'],
       ],

       'addcomment' => [
           'type'        => 'text',
           'label'       => 'Kommentarstext:',
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
    $this->questions = new \Anax\Comment\Comment();
    $this->questions->setDI($this->di);
    $this->questions->create([
       'Commentname' => $this->filter->markdown($_POST['addcomment']),
       'QuestionResponseType' => 'question',
       'QuestionResponseId' => $_POST['addquestion']
     ]);

    // $this->redirectTo('index.php/user');
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
