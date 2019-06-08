<?php
/**
 * Created by PhpStorm.
 * User: theo
 * Date: 4/10/19
 * Time: 4:27 PM
 */

namespace Drupal\elog\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\Request;

/**
 * Defines HelloController class.
 */
class ElogController extends ControllerBase {

  /**
   * Display the markup.
   *
   * @return array
   *   Return markup array.
   */
  public function content() {
    return [
      '#type' => 'markup',
      '#markup' => $this->t('Hello, World!'),
    ];
  }

  public function entry($lognumber, Request $request) {
    var_dump($request->query);
    die;
    return [
      '#type' => 'markup',
      '#markup' => $this->t('Howdy ' . $this->currentUser()->getAccountName()),
    ];
  }


}