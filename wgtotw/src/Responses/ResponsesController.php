<?php

namespace Anax\Responses;

/**
 * A controller for responses related events.
 *
 */
class ResponsesController implements \Anax\DI\IInjectionAware
{
    use \Anax\DI\TInjectable;

    /**
     * Initialize the controller.
     *
     * @return void
     */
    public function initialize()
    {
        $this->responses = new \Anax\Responses\Responses();
        $this->responses->setDI($this->di);
    }

    /**
     * Add new response.
     *
     * @return void
     */
    public function addAction()
    {
       $id = $this->request->getGet('id');
       $userid = $this->request->getGet('userid');

       $this->di->session();
       $this->di->views->add('questionresponses/viewtitle', [
         'title' => "Svara på fråga"
       ]);

       $this->di->session();
       $form = new \Anax\HTMLForm\CFormResponseAdd($id,$userid);
       $form->setDI($this->di);
       $form->check();
       $this->di->views->add('default/page', [
         'title' => "",
         'content' => $form->getHTML()
       ]);
    }

    /**
     * List response.
     *
     * @param int $id of response to display
     *
     * @return void
     */
    public function idAction($id = null)
    {
       $this->questions->setDI($this->di);
       $question = $this->questions->find($id);
       $this->theme->setTitle("Fråga");
       $this->views->add('questions/view', [
         'id' => $id,
         'question' => $question,
         'title' => "Fråga",
       ]);

       $this->questions->setDI($this->di);
       $allResponses = $this->questions->findAllResponses($id);
       $this->theme->setTitle("Svar till frågan");
       $this->views->add('questions/viewresponses', [
         'id' => $id,
         'responses' => $allResponses,
         'title' => "Svar till frågan",
       ]);

    }
}
