<?php

class CreateWordpressDataQueries extends \Wpbi\Database\BaseMigration { // @codingStandardsIgnoreLine

  public function change() {
    $table = $this->table($this->tableName());

    if($this->hasTable($this->tableName())) {
      return;
    }

    $table
      ->addColumn('name', 'string', array('null' => false, 'limit' => 64))
      ->addIndex('name', array('unique' => true))
      ->addColumn('wpsql', 'string', array('null' => false, 'limit' => 2096))
      ->create();
  }

  private function tableName() {
    return $this->tablePrefix() . '_wp_data_queries';
  }

}
