<?php

class CreateRadarCharts extends \Wpbi\Database\BaseMigration { // @codingStandardsIgnoreLine

  public function change() {
    $table = $this->table($this->tableName());
    $fkTableName = $this->tablePrefix() . '_queries3';

    if($this->hasTable($this->tableName())) {
      return;
    }

    $table
      ->addColumn('query_id', 'integer', array('null' => false))
      ->addForeignKey('query_id', $fkTableName)
      ->addColumn('library', 'uuid', array('null' => false, 'limit' => 64))
      ->addColumn('mappings', 'text', array('null' => true, 'limit' => \Phinx\Db\Adapter\MysqlAdapter::TEXT_LONG))
      ->addColumn('cname', 'text', array('null' => true, 'limit' => \Phinx\Db\Adapter\MysqlAdapter::TEXT_LONG))
      ->addColumn('caption', 'text', array('null' => true, 'limit' => \Phinx\Db\Adapter\MysqlAdapter::TEXT_LONG))
      ->addColumn('color_scheme', 'uuid', array('null' => true, 'limit' => 64))
      ->addColumn('in_dash', 'boolean', array('default' => 0))
      ->create();
  }

  private function tableName() {
    return $this->tablePrefix() . '_radar_charts';
  }

}
