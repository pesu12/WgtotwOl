<?php
namespace Anax\HTMLForm;
/**
 * Anax base class for wrapping sessions.
 *
 */
class CFormPsWebIndex extends \Anax\HTMLForm\CForm
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
         'usersadd' => [
           'type'        => 'checkbox',
           'label'       => 'Add Users',
           'checked'     => false,
         ],

         'usersactivelist' => [
           'type'        => 'checkbox',
           'label'       => 'List Active users',
           'checked'     => false,
         ],

         'usersid' => [
           'type'        => 'checkbox',
           'label'       => 'Display a users details',
           'checked'     => false,
         ],

         'usersoftdelete' => [
           'type'        => 'checkbox',
           'label'       => 'Soft Delete (update) user',
           'checked'     => false,
         ],

         'usersnotactivelist' => [
           'type'        => 'checkbox',
           'label'       => 'List Not Active users(Trash can)',
           'checked'     => false,
         ],

         'usersdelete' => [
           'type'        => 'checkbox',
           'label'       => 'Delete user',
           'checked'     => false,
         ],

         'usersundosoftdelete' => [
           'type'        => 'checkbox',
           'label'       => 'Undo Soft Delete (update) user',
           'checked'     => false,
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
     */
    public function callbackSubmitFail($form)
    {
        $form->AddOutput("<p><i>DoSubmitFail(): Form was submitted but I failed to process/save/validate it</i></p>");
        return false;
    }

    /**
     * Callback What to do if the form was submitted?
     *
     */
    public function callbackSuccess($form)
    {
                if(isset($_POST['usersactivelist'])) {
                  $this->redirectTo('index.php/users/active/activateusers');
                }
                if(isset($_POST['usersnotactivelist'])) {
                  $this->redirectTo('index.php/users/active/notactiveusers');
                }
                if(isset($_POST['usersetup'])) {
                  $this->redirectTo('index.php/users/setup');
                }
                if(isset($_POST['usersadd'])) {
                  $this->redirectTo('index.php/users/add');
                }
                if(isset($_POST['usersdelete'])) {
                  $this->redirectTo('index.php/users/delete');
                }
                if(isset($_POST['usersupdate'])) {
                  $this->redirectTo('index.php/users/update');
                }
                if(isset($_POST['usersoftdelete'])) {
                  $this->redirectTo('index.php/users/update');
                }
                if(isset($_POST['usersundosoftdelete'])) {
                  $this->redirectTo('index.php/users/undoupdate');
                }
                if(isset($_POST['usersid'])) {
                  $this->redirectTo('index.php/users/displayuser');
                }
    }

    /**
     * Callback What to do when form could not be processed?
     *
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
