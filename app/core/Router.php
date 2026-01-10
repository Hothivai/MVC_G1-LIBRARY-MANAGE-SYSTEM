<?php
/**
 * Router Class
 * Handles URL routing and controller dispatch
 */

class Router
{
  protected $controller = 'BookController';  // Default controller
  protected $method = 'index';                // Default method
  protected $params = [];

  /**
   * Parse URL and route to appropriate controller
   */
  public function __construct()
  {
    $url = $this->getUrl();

    // Look for controller
    if (isset($url[0]) && file_exists('../app/controllers/' . ucfirst($url[0]) . 'Controller.php')) {
      $this->controller = ucfirst($url[0]) . 'Controller';
      unset($url[0]);
    }

    // Require controller file
    require_once '../app/controllers/' . $this->controller . '.php';

    // Instantiate controller
    $this->controller = new $this->controller;

    // Look for method
    if (isset($url[1]) && method_exists($this->controller, $url[1])) {
      $this->method = $url[1];
      unset($url[1]);
    }

    // Get params
    $this->params = $url ? array_values($url) : [];

    // Call controller method with params
    call_user_func_array([$this->controller, $this->method], $this->params);
  }

  /**
   * Get and parse URL from request
   * @return array - URL segments
   */
  protected function getUrl()
  {
    if (isset($_GET['url'])) {
      $url = rtrim($_GET['url'], '/');
      $url = filter_var($url, FILTER_SANITIZE_URL);
      $url = explode('/', $url);
      return $url;
    }
    return [];
  }
}
