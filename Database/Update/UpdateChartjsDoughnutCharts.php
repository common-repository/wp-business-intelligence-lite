<?php
namespace Wpbi\Database\Update;

class UpdateChartjsDoughnutCharts extends \Wpbi\Database\BaseMigration { // @codingStandardsIgnoreLine

  public function update() {

    $table = $this->tableName();

    global $wpdb;

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
    return $this->tablePrefix() . '_chartjs_doughnut_charts';
  }

}
