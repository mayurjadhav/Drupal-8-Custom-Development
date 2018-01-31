<?php

namespace Drupal\d8_training\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Database\Database;
use Drupal\Core\Access\AccessResult;

class EmployeeDetails extends ControllerBase {

  /**
   *
   * Stores DB Connection
   */
  public $connection;

  /**
   * Constructor for Setting database connection
   *
   */
  public function __construct() {
    $this->connection = Database::getConnection();
  }

  /**
   * Checks access for this controller.
   */
  public function access() {
    return AccessResult::allowed();
  }
  /**
   * @param $details
   */
  function StoreEmployeeDetails($details) {
    $this->connection->insert('employee')->fields(
      [
        'name' => $details['name'],
        'employee_id' => $details['employee_id'],
        'email' => $details['email'],
        'address' => $details['address'],
        'gender' => $details['gender'],
        'date_of_birth' => strtotime($details['date_of_birth']),
      ]
    )->execute();
  }
}