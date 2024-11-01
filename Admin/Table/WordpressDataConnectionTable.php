<?php
namespace Wpbi\Admin\Table;

// TODO: should actions go in here rather than where they are
class WordpressDataConnectionTable {

  private $columns = array(
    'id' => 'ID',
    'name' => 'Name',
    'color_scheme' => 'Color',
    'in_dash' => 'Is in Dash?'
  );

  public function getColumns() {
    return $this->columns;
  }

}
