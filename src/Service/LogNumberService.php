<?php
namespace Drupal\elog\Service;

use Drupal\Core\Messenger\MessengerTrait;

class LogNumberService
{
    use MessengerTrait;

    /**
     * Uses a private table with an autoincrement column to generate a sequence of unique log numbers.
     * @return integer
     * @throws \Exception
     */
    public function nextLogNumber() {
        $connection = \Drupal::service('database');
        try {
            $logNumber = $connection->insert('elog_lognumber')
                ->fields([
                    'bundle' => 'logentry',
                ])
                ->execute();
            \Drupal::logger('elog')->error("LogNumberService assigned ".$logNumber());
            return $logNumber;
        } catch (\Exception $e){
            $this->messenger()->addError('Failed to obtain valid lognumber');
            \Drupal::logger('elog')->error("LogNumberService error ".$e->getMessage());
            // @todo throw a custom exception that will prevent node insertion
            // @todo display the custom exception nicely.
            //throw ($e);
        }

        return NULL;
    }
}