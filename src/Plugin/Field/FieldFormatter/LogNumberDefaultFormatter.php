<?php

namespace Drupal\elog\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Field\FieldItemListInterface;

/**
 * Plugin implementation of the 'serial_default_formatter'.
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
            // Render output using serial_default theme.
            $source = [
                '#theme' => 'elog_default',
                '#serial_id' => $item->value,
            ];
            $elements[$delta] = [
                '#markup' => \Drupal::service('renderer')->render($source),
            ];
        }
        return $elements;
    }

}
