<?php
namespace Wpbi\Database\Update;

use Wpbi\Settings;

class UpdateWordpressDataQueries extends \Wpbi\Database\BaseMigration { // @codingStandardsIgnoreLine

  public function update() {

    $table = $this->tableName();

    global $wpdb;

    $data = $this->data();
    foreach ($data as $row) {
      $name = $row['name'];
      $result = $wpdb->get_var(
        $wpdb->prepare(
          "SELECT DISTINCT(name) FROM {$table} WHERE name = %s", $name
        )
      );

      if (empty($result)) {
        $wpdb->insert($table, $row, array('%s', '%s'));
      } else {
        $wpdb->update($table, $row, ['name' => $name], ['%s', '%s'], ['%s']);
      }
    }

  }

  public function data() {

    $data = Settings::wordpressDataQueries();
    $rows = array();
    foreach($data as $key => $item) {
      $rows[] = [
                'name'  => $key,
                'wpsql'  => $item
                ];
    }

    return $rows;
  }

  private function tableName() {
    return $this->tablePrefix() . '_wp_data_queries';
  }

}
