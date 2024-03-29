<?php

namespace Drupal\elog\Plugin\Field\FieldWidget;


use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\WidgetBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Plugin implementation of the 'lognumber_default' widget.
 *
 * @FieldWidget(
 *   id = "lognumber_default_widget",
 *   label = @Translation("Hidden (Automatic)"),
 *   field_types = {
 *     "lognumber"
 *   }
 * )
 */
class LogNumberDefaultWidget extends WidgetBase {

  /**
   * {@inheritdoc}
   */
  public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state) {
    $element['value'] = [
      // Understand number (integer)
      '#type' => 'hidden',
      // Default value cannot be NULL,
      // throws 'This value should be of the correct primitive type'.
      // @see https://www.drupal.org/node/2220381
      // so the serial is defaulted to a positive int.
      '#default_value' => isset($items[$delta]->value) ? $items[$delta]->value : 0,
    ];
    return $element;
  }


}