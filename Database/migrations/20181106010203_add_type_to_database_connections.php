<?php

class AddTypeToDatabaseConnections extends \Wpbi\Database\BaseMigration { // @codingStandardsIgnoreLine

  public function change() {
    $table = $this->table($this->tableName());
    $table
      ->addColumn('type', 'string', array('null' => false, 'default' => 'mysql'))
      ->save();
  }

  private function tableName() {
    return $this->tablePrefix() . '_database_connections';
  }

}
