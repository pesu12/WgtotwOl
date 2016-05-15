<?php
namespace Anax\HTMLForm;
/**
 * Anax base class for wrapping sessions.
 *
 */
class CFormPsWebAddUser extends \Anax\HTMLForm\CForm
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
         'addname' => [
             'type'        => 'text',
             'label'       => 'Användarnamn:',
             'required'    => true,
             'validation'  => ['not_empty'],
         ],

         'addemail' => [
             'type'        => 'text',
             'label'       => 'Email:',
             'required'    => true,
             'validation'  => ['not_empty', 'email_adress'],
         ],

         'addacronym' => [
             'type'        => 'text',
             'label'       => 'Akronym:',
             'required'    => true,
             'validation'  => ['not_empty'],
         ],

         'addpassword' => [
             'type'        => 'text',
             'label'       => 'Lösenord:',
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
      $this->users = new \Anax\User\User();
      $this->users->setDI($this->di);
      date_default_timezone_set('Europe/Berlin');
       $this->users->save([
         'Username' => $_POST['addname'],
         'Acronym' => $_POST['addacronym'],
         'Email' => $_POST['addemail'],
         'Userpassword' => password_hash($_POST['addpassword'], PASSWORD_DEFAULT),
       ]);
       $id=$this->users->lastInsertedId();
       //Set session that user is logged in
       $this->users->setLoggedIn($id);       
       $this->redirectTo('index.php/user/displayuser/'.$this->users->lastInsertedId());
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
