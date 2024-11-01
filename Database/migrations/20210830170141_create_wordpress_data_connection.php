<?php

class CreateWordpressDataConnection extends \Wpbi\Database\BaseMigration { // @codingStandardsIgnoreLine

  public function change() {
    $table = $this->table($this->tableName());

    if($this->hasTable($this->tableName())) {
      return;
    }

    $table
      ->addColumn('query_id', 'string', array('null' => false, 'limit' => 128))
      ->addColumn('name', 'string', array('null' => false, 'limit' => 1028))
      ->addColumn('library', 'string', array('null' => false, 'limit' => 64))
      ->addColumn('mappings', 'text', array('null' => true, 'limit' => \Phinx\Db\Adapter\MysqlAdapter::TEXT_LONG))
      ->addColumn('cname', 'text', array('null' => true, 'limit' => \Phinx\Db\Adapter\MysqlAdapter::TEXT_LONG))
      ->addColumn('caption', 'text', array('null' => true, 'limit' => \Phinx\Db\Adapter\MysqlAdapter::TEXT_LONG))
      ->addColumn('color_scheme', 'string', array('null' => true, 'limit' => 64))
      ->addColumn('in_dash', 'boolean', array('null' => true, 'default' => false))
      ->addColumn('chart_type', 'string', array('null' => false, 'limit' => 128))
      ->create();
  }

  private function tableName() {
    return $this->tablePrefix() . '_wordpress_data_connections';
  }

}
