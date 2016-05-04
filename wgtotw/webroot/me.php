<?php
/**
* This is a Anax pagecontroller.
*
*/

// Get environment & autoloader.
require __DIR__.'/config_with_app.php';

$app->theme->configure(ANAX_APP_PATH . 'config/theme-grid.php');

$app->navbar->configure(ANAX_APP_PATH . 'config/navbar_me.php');

$app->url->setUrlType(\Anax\Url\CUrl::URL_CLEAN);

$di->set('form', '\Anax\HTMLForm\CForm');

$di->set('FormController', function () use ($di) {
  $controller = new \Anax\HTMLForm\FormController();
  $controller->setDI($di);
  return $controller;
});

$di->set('FirstpageController', function () use ($di) {
  $controller = new \Anax\Firstpage\FirstpageController();
  $controller->setDI($di);
  return $controller;
});

$di->set('UserController', function () use ($di) {
  $controller = new \Anax\User\UserController();
  $controller->setDI($di);
  return $controller;
});

$di->set('QuestionController', function () use ($di) {
  $controller = new \Anax\Question\QuestionController();
  $controller->setDI($di);
  return $controller;
});

$di->set('ResponsesController', function () use ($di) {
  $controller = new \Anax\Responses\ResponsesController();
  $controller->setDI($di);
  return $controller;
});

$di->set('TagController', function () use ($di) {
  $controller = new \Anax\Tag\TagController();
  $controller->setDI($di);
  return $controller;
});

$di->set('CommentController', function () use ($di) {
  $controller = new \Anax\Comment\CommentController();
  $controller->setDI($di);
  return $controller;
});

$di->setShared('db', function() use ($di) {
  $db = new \Anax\Database\CDatabaseBasic();
  $db->setOptions(require ANAX_APP_PATH . 'config/config_mysql.php');
  $db->connect();
  return $db;
});

//For the first page
$app->router->add('', function() use ($app) {

  $app->theme->addStylesheet('css/anax-grid/style.php');
  $app->dispatcher->forward([
    'controller'    => 'Firstpage',
    'action'         => 'index',
    'params'        => [],
  ]);

});

//For the tag page
$app->router->add('Tag', function() use ($app) {

  $app->theme->addStylesheet('css/anax-grid/style.php');
  $app->dispatcher->forward([
    'controller'    => 'Tag',
    'action'         => 'index',
    'params'        => [],
  ]);
});

//For the user page
$app->router->add('User', function() use ($app) {
  $app->theme->addStylesheet('css/anax-grid/style.php');
  $app->dispatcher->forward([
    'controller'    => 'User',
    'action'         => 'index',
    'params'        => [],
  ]);

});

//For the question page
$app->router->add('Question', function() use ($app) {

  $app->theme->addStylesheet('css/anax-grid/style.php');
  $app->dispatcher->forward([
    'controller'    => 'Question',
    'action'         => 'index',
    'params'        => [],
  ]);
});

//For the About page
$app->router->add('About', function() use ($app) {

  $app->theme->addStylesheet('css/anax-grid/style.php');

  $content = $app->fileContent->get('About.md');
  $content = $app->textFilter->doFilter($content, 'shortcode, markdown');

  $byline = $app->fileContent->get('byline.md');
  $byline = $app->textFilter->doFilter($byline, 'shortcode, markdown');

  $app->views->add('me/page', [
    'content' => $content,
    'byline' => $byline,
  ]);

});

//For the User Login
$app->router->add('Login', function() use ($app) {
  $app->theme->addStylesheet('css/anax-grid/style.php');
  $app->dispatcher->forward([
    'controller'    => 'User',
    'action'         => 'login',
    'params'        => [],
  ]);

});

$app->router->handle();
$app->theme->render();
