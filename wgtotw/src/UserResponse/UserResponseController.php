<?php

namespace Anax\UserResponses;

/**
 * A controller for User responses related events.
 *
 */
class UserResponsesController implements \Anax\DI\IInjectionAware
{
    use \Anax\DI\TInjectable;

    /**
     * Initialize the controller.
     *
     * @return void
     */
    public function initialize()
    {
        $this->userresponse = new \Anax\UserRsponse\UserResponse();
        $this->userresponse->setDI($this->di);
    }

}
