<?php
namespace Wpbi\Admin\Table;

// TODO: should actions go in here rather than where they are
class DatabaseConnectionTable {

  private $columns = array(
    'id' => 'ID',
    'name' => 'Name',
    'username' => 'Username',
    'database_name' => 'Database Name',
    'host' => 'Host',
    'port' => 'Port',
    'socket' => 'Socket',
    'type' => 'Type'
  );

  public function getColumns() {
    return $this->columns;
  }

}
