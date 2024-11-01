<?php
namespace Wpbi\Database\Update;

class UpdateDatabaseConnection extends \Wpbi\Database\BaseMigration { // @codingStandardsIgnoreLine

  public function update() {

    $table = $this->tableName();

    global $wpdb;

    $column = $wpdb->get_results( $wpdb->prepare(
    		"SELECT * FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = %s AND COLUMN_NAME = 'charset'",
    		$table
    ) );
    if ( empty( $column ) ) {
      $prepared_statement = "ALTER TABLE {$table} ADD COLUMN charset text";
      $values = $wpdb->query( $prepared_statement );
    }

    $column = $wpdb->get_results( $wpdb->prepare(
        "SELECT * FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = %s AND COLUMN_NAME = 'role'",
        $table
    ) );
    if ( empty( $column ) ) {
      $prepared_statement = "ALTER TABLE {$table} ADD COLUMN role text";
      $values = $wpdb->query( $prepared_statement );
    }

    $column = $wpdb->get_results( $wpdb->prepare(
    		"SELECT * FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = %s AND COLUMN_NAME = 'dialect'",
    		$table
    ) );
    if ( empty( $column ) ) {
      $prepared_statement = "ALTER TABLE {$table} ADD COLUMN dialect varchar(64)";
      $values = $wpdb->query( $prepared_statement );
    }
  }

  private function tableName() {
    return $this->tablePrefix() . '_database_connections';
  }

}
