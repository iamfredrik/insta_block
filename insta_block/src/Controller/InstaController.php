<?php
namespace Drupal\insta_block\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\Response;
/**
 * Provides route responses for the Example module.
 */
class InstaController extends ControllerBase {

  /**
   * Returns a simple page.
   *
   * @return array
   *   A simple renderable array.
   */
  public function instaMedia() {
    //Get instagram user name
    $user_name = \Drupal::request()->query->get('user_name');

    $json_url = "https://www.instagram.com/" . $user_name . "/media";

    $json = file_get_contents($json_url);;
    
    return new Response($json);
  }

}