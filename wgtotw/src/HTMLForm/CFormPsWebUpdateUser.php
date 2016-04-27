<?php
namespace Anax\HTMLForm;
/**
 * Anax base class for wrapping sessions.
 *
 */
class CFormPsWebUpdateUser extends \Anax\HTMLForm\CForm
{
  use \Anax\DI\TInjectionaware,
	\Anax\MVC\TRedirectHelpers;

	public function __construct($user=null)
	{
    /**
     * Constructor
     *
     */
    $_POST['Id']=$user->Id;
		parent::__construct([], [
			'name' => [
				'type'        => 'text',
        'class'       => 'form-control',
				'label'       => 'Namn:',
        'autofocus'   => true,
				'required'    => true,
				'validation'  => ['not_empty'],
				'value'		  => isset($user) ? $user->Username : '',
			],

      'acronym' => [
				'type'        => 'text',
        'class'       => 'form-control',
				'label'       => 'Akronym:',
        'autofocus'   => true,
				'required'    => true,
				'validation'  => ['not_empty'],
				'value'		  => isset($user) ? $user->Acronym : '',
			],

      'email' => [
				'type'        => 'text',
        'class'       => 'form-control',
				'label'       => 'Email:',
        'autofocus'   => true,
				'required'    => true,
				'validation'  => ['not_empty','email_adress'],
				'value'		  => isset($user) ? $user->Email : '',
			],

			'uppdatera' => [
				'type'      => 'submit',
                'class'     => 'btn',
                'value'     => 'Uppdatera',
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
	public function callbackSubmit()
	{
    $this->users = new \Anax\User\User();
    $this->users->setDI($this->di);
     $this->users->saveToDB([
       'Id' => $_POST['Id'],
       'Username' => $_POST['name'],
       'Acronym' => $_POST['acronym'],
       'Email' => $_POST['email'],
       'Userpassword' => password_hash($_POST['acronym'], PASSWORD_DEFAULT),
     ]);
     $this->redirectTo('index.php/user');
		return true;
	}

  /**
   * Callback What to do if the form was submitted?
   *
   * @param $form.
   */
	public function callbackSuccess()
	{
    $this->users = new \Anax\User\User();
    $this->users->setDI($this->di);
     $this->redirectTo('index.php/user');
   }

     /**
      * Callback What to do when form could not be processed?
      *
      * @param $form.
      */
	public function callbackFail()
	{
    $this->users = new \Anax\User\User();
    $this->users->setDI($this->di);
    $this->redirectTo('index.php/user');
  }
}
