<?php

namespace Drupal\elog\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Field\FieldItemListInterface;

/**
 * Plugin implementation of the 'lognumber_link_formatter'.
 *
 * Outputs the lognumber field as a link to its parent entity.
 *
 * @FieldFormatter(
 *   id = "lognumber_link_formatter",
 *   label = @Translation("Log Number link"),
 *   field_types = {
 *     "lognumber",
 *   },
 * )
 */
class LogNumberLinkFormatter extends FormatterBase {

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $elements = [];
    $entity = $items->getEntity();
    foreach ($items as $delta => $item) {
      // Render output using an inline template
      $elements[$delta] = [
        '#type' => 'inline_template',
        '#template' => '<a href="{{ url }}" target="_blank"><span class="lognumber">{{ lognumber }}<span class="lognumber"></a>',
        '#context' => [
          'url' => $entity->toUrl(),
          'lognumber' => $item->getValue()['value'],
        ],
      ];
    }
    return $elements;
  }

}
