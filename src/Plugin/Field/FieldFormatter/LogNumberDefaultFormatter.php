<?php

namespace Drupal\elog\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Component\Utility\Html;

/**
 * Plugin implementation of the 'lognumber_default_formatter'.
 *
 * Outputs the lognumber field as plain text.
 *
 * @FieldFormatter(
 *   id = "lognumber_default_formatter",
 *   label = @Translation("Log Number default"),
 *   field_types = {
 *     "lognumber",
 *   },
 * )
 */
class LogNumberDefaultFormatter extends FormatterBase {

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $elements = [];
    foreach ($items as $delta => $item) {
      // Render output using an inline template
      $elements[$delta] = [
        '#type' => 'inline_template',
        '#template' => '<span class="lognumber">{{ lognumber }}</span>',
        '#context' => [
          'lognumber' => Html::escape($item->getValue()['value']),
        ],
      ];
    }
    return $elements;
  }

}
