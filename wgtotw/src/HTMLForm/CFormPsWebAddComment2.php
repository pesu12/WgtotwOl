<?php
namespace Anax\HTMLForm;
/**
 * Anax base class for wrapping sessions.
 *
 */
class CFormPsWebAddComment2 extends \Anax\HTMLForm\CForm
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
         'content' => [
             'type'        => 'text',
             'label'       => 'Kommentar:',
             'value'       => '<Kommentar>',
             'required'    => true,
             'validation'  => ['not_empty'],
         ],

         'name' => [
             'type'        => 'text',
             'label'       => 'Namn:',
             'value'       => '<Namn>',
             'required'    => true,
             'validation'  => ['not_empty'],
         ],

         'web' => [
             'type'        => 'text',
             'label'       => 'Hemsida:',
             'value'       => '<www>',
             'required'    => true,
             'validation'  => ['not_empty'],
         ],

         'email' => [
             'type'        => 'text',
             'label'       => 'Epost-adress:',
             'value'       => '<xxx@email.com>',
             'required'    => true,
            'validation'  => ['not_empty', 'email_adress'],
         ],

         'Ny_Kommentar' => [
             'type'      => 'submit',
               'callback'  => [$this, 'callbackSubmit'],
         ],

         'Rensa_Form' => [
             'type'      => 'reset',
               'callback'  => [$this, 'clearform'],
         ],

         'Ta_bort_alla_kommentarer' => [
             'type'      => 'submit',
               'callback'  => [$this, 'clearallcomments'],
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
     *
     */
    public function callbackSubmit($form)
    {
        $form->AddOutput("<p><i>DoSubmit(): Form was submitted</i></p>");

        return true;
    }

    /**
     * Callback for clearform button.
     *
     * @param $form.
     */
    public function clearform($form)
    {
       $this->redirectTo('index.php/comment2');
    }

    /**
     * Callback for clear all comments button.
     *
     * @param $form.
     */
    public function clearallcomments($form)
    {
      $this->comment = new \Anax\MVC\CCommentModel();
      $this->comment->setDI($this->di);
      $this->comment->clearDb(2);
      $this->redirectTo('index.php/comment2');
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
      $this->users = new \Anax\MVC\CCommentModel();
      $this->users->setDI($this->di);
      if(($_POST['content']=='<Kommentar>')or
      ($_POST['name']=='<Namn>')or
      ($_POST['web']=='<www>')or
      ($_POST['email']=='<xxx@email.com>')) {
        $this->callbackFail($form);
      }
      else{
        $now = gmdate('Y-m-d H:i:s');
        $this->users->saveToDB([
           'content' => $_POST['content'],
           'name' => $_POST['name'],
           'web' => $_POST['web'],
           'email' => $_POST['email'],
           'timestamp' => $now,
           'ip'        => '127.0.0.1',
           'page'       => 2,
       ]);
       $this->redirectTo('index.php/comment2');
      }
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
