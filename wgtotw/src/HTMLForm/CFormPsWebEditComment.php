<?php
namespace Anax\HTMLForm;
/**
 * Anax base class for wrapping sessions.
 *
 */
class CFormPsWebEditComment extends \Anax\HTMLForm\CForm
{
    use \Anax\DI\TInjectionaware,
        \Anax\MVC\TRedirectHelpers;
    /**
     * Constructor
     *
     * @param array $comment with all details.
     */
     public function __construct($comment)
     {
       parent::__construct([], [
         'content' => [
             'type'        => 'text',
             'label'       => 'Kommentar:',
             'value'       => $comment->content,
             'required'    => true,
             'validation'  => ['not_empty'],
         ],

         'name' => [
             'type'        => 'text',
             'label'       => 'Namn:',
             'value'       => $comment->name,
             'required'    => true,
             'validation'  => ['not_empty'],
         ],

         'web' => [
             'type'        => 'text',
             'label'       => 'Hemsida:',
             'value'       => $comment->web,
             'required'    => true,
             'validation'  => ['not_empty'],
         ],

         'email' => [
             'type'        => 'text',
             'label'       => 'Epost-adress:',
             'value'       => $comment->email,
             'required'    => true,
            'validation'  => ['not_empty', 'email_adress'],
         ],

         'Uppdatera' => [
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
      $this->users = new \Anax\MVC\CCommentModel();
      $this->users->setDI($this->di);
      $now = gmdate('Y-m-d H:i:s');
       $this->users->saveToDB([
         'content' => $_POST['content'],
         'name' => $_POST['name'],
         'web' => $_POST['web'],
         'email' => $_POST['email'],
         'timestamp' => $now,
         'ip'        => '127.0.0.1',
         'page'       => $_GET['pageKey'],
         'id'       => $_GET['id'],
       ]);
       if($_GET['pageKey']==1) {
         $this->redirectTo('index.php/comment');
       }
       else{
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
