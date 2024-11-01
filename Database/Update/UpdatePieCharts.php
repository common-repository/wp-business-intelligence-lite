<?php
namespace Wpbi\Database\Update;

class UpdatePieCharts extends \Wpbi\Database\BaseMigration { // @codingStandardsIgnoreLine

  public function update() {

    $table = $this->tableName();

    global $wpdb;

    $column = $wpdb->get_results( $wpdb->prepare(
    		"SELECT * FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = %s AND COLUMN_NAME = 'cname'",
    		$table
    ) );
    if ( empty( $column ) ) {
      $prepared_statement = "ALTER TABLE {$table} ADD COLUMN cname text";
      $values = $wpdb->query( $prepared_statement );
    }

    $column = $wpdb->get_results( $wpdb->prepare(
        "SELECT * FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = %s AND COLUMN_NAME = 'caption'",
        $table
    ) );
    if ( empty( $column ) ) {
      $prepared_statement = "ALTER TABLE {$table} ADD COLUMN caption text";
      $values = $wpdb->query( $prepared_statement );
    }

    $column = $wpdb->get_results( $wpdb->prepare(
    		"SELECT * FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = %s AND COLUMN_NAME = 'color_scheme'",
    		$table
    ) );
    if ( empty( $column ) ) {
      $prepared_statement = "ALTER TABLE {$table} ADD COLUMN color_scheme varchar(64)";
      $values = $wpdb->query( $prepared_statement );
    }

    $column = $wpdb->get_results( $wpdb->prepare(
    		"SELECT * FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = %s AND COLUMN_NAME = 'library'",
    		$table
    ) );
    if ( empty( $column ) ) {
      $prepared_statement = "ALTER TABLE {$table} ADD COLUMN library varchar(64) DEFAULT 'britechart' AFTER query_id";
      $values = $wpdb->query( $prepared_statement );
    }

    $column = $wpdb->get_results( $wpdb->prepare(
    		"SELECT * FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = %s AND COLUMN_NAME = 'in_dash'",
    		$table
    ) );
    if ( empty( $column ) ) {
      $prepared_statement = "ALTER TABLE {$table} ADD COLUMN in_dash TINYINT(1) DEFAULT 0 NOT NULL AFTER library";
      $values = $wpdb->query( $prepared_statement );
    }
  }

  private function tableName() {
    return $this->tablePrefix() . '_pie_charts';
  }

}
