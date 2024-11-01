<?php
namespace Wpbi\Models;

use League\Plates\Engine;
use Wpbi\Settings;
use Wpbi\Models\AbstractChart;
use Wpbi\Models\WpDataQueries;

// TODO: uncovered
class WordpressDataConnection extends AbstractChart {

  protected $chartSlug = 'wordpress-data-connection';

  protected $mappedAttributes = array();

  protected $fillable = array(
    'name',
    'query_id',
    'cname',
    'caption',
    'library',
    'color_scheme',
    'chart_type',
    'in_dash'
  );

  protected $casts = array(
    'in_dash'      => 'boolean',
    'cname'        => 'string',
    'caption'      => 'string',
    'color_scheme' => 'string',
    'library'      => 'string'
  );

  protected static $validCreateRules = array(
    'name'         => 'required',
    'query_id'     => 'required',
    'library'      => 'required',
    'color_scheme' => 'required',
    'chart_type'   => 'required'
  );

  protected static $validUpdateRules = array();

  public function setInDashAttribute($value) {
    $this->attributes['in_dash'] = (boolean) $value;
  }

  public function setColorSchemeAttribute($value) {
    $this->attributes['color_scheme'] = $value;
  }

  public function setLibraryAttribute($value) {
    $this->attributes['library'] = $value;
  }

  public function setCnameAttribute($value) {
    $this->attributes['cname'] = (string) $value;
  }

  public function setCaptionAttribute($value) {
    $this->attributes['caption'] = (string) $value;
  }

  public function queries() {
    return $this->hasMany(\Wpbi\Models\Query::class);
  }

  public static function run($databaseConnection) {
    $item = $databaseConnection->getAttributes();
    $id = $item['id'];
    $query_id = $item['query_id'];
    $query = (new WpDataQueries)->getSql($query_id);

    if (!empty($query)) {
      $data = (new WpDataQueries)->getData($query_id, $query);
      (new WpDataQueries)->saveData($id, $data);
    }
  }
}
