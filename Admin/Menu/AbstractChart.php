<?php

namespace Wpbi\Admin\Menu;

use League\Plates\Engine;
use Wpbi\Settings;
use Stringy\Stringy;

/**
 * TODO: remove suppression
 * @SuppressWarnings(PHPMD.ExcessiveClassComplexity)
 */
abstract class AbstractChart {

  public static function menuSlug() {
    return strval(Stringy::create(static::modelName())->dasherize());
  }

  protected static function urlClass() {
    $library = $_REQUEST['library'];
    return "\\Wpbi\\Admin\\Url\\" . ucwords($library) . "\\" . static::modelName();
  }

  protected static function modelClass() {
    $library = $_REQUEST['library'];
    return "\\Wpbi\\Models\\" . ucwords($library) . "\\" . static::modelName();
  }

  public static function modelName() {
    return (new \ReflectionClass(static::class))->getShortName();
  }

  public static function title() {
    return strval(Stringy::create(static::modelName())->delimit(' ')->titleize());
  }

  public static function addMenu() {
    $parentSlug = Main::menuSlug();
    $pageTitle = static::title();
    $menuTitle = static::title();
    $capability = Settings::capability();
    $menuSlug = static::menuSlug();
    $function = array(static::class, 'route');
    add_submenu_page($parentSlug, $pageTitle, $menuTitle, $capability, $menuSlug, $function);
  }

  public static function route() {
    $action = (isset($_GET['action']) === true) ? $_GET['action'] : 'showCreate';
    $klass = get_called_class(); // TODO: constructor
    switch ($action) {
      case 'showEdit':
        (new $klass)->showEdit();
        break;
      case 'showCreate':
        (new $klass)->showCreate();
        break;
    }
  }

  public function showCreate() {
    $library = $_REQUEST['library'];
    $urlClass = static::urlClass();
    $createUrl = $urlClass::createUrl($library); 
    $templateName = "admin/{$library}/{$this->modelName()}Create";
    $queries = \Wpbi\Models\Query::all();
    
    $colors = Settings::britechartsColorScheme();
    if ($library != 'britecharts') {
      #unset($colors[0]);
    }
    
    echo (new Engine(Settings::platesDirectory()))
      ->render($templateName,
        array('action' => $createUrl,
          'queries' => $queries,
          'library' => $library,
          'schemes' => $colors
        ));
  }

  public function showEdit() {
    $id = (int) $_REQUEST['id'];
    $modelClass = static::modelClass();
    $chart = $modelClass::find($id);
    $exception = false;
    $chartHtml = '';
    $columnNames = array();

    try {
      $chartData = $chart->queryStatement->results();
      $columnNames = $this->columnNames($chartData);
      $chartHtml = $chart->getHtml($caption = 'on');
    } catch (\PDOException $e) {
      $exception = $e;
    }

    echo $this->templateHtml($chart, $columnNames, $chartHtml, $exception);
  }

  /**
   * @SuppressWarnings(PHPMD.ExcessiveParameterList)
   */
  private function templateHtml($chart, $columnNames, $chartHtml, $exception) {
    $library = $_REQUEST['library'];
    $editTemplate = "admin/{$library}/{$this->modelName()}Edit";
    $urlClass = static::urlClass();
    $editUrl = $urlClass::editUrl($library);
    $queries = \Wpbi\Models\Query::all();
    
    $colors = Settings::britechartsColorScheme();
    if ($library != 'britecharts') {
      #unset($colors[0]);
    }
    
    return (new Engine(Settings::platesDirectory()))
      ->render($editTemplate,
        array('chart' => $chart,
          'columnNames' => $columnNames,
          'chartHtml' => $chartHtml,
          'exception' => $exception,
          'queries' => $queries,
          'action' => $editUrl,
          'library' => $library,
          'schemes' => $colors));
  }

  public static function create() {
    $library = $_REQUEST['library'];
    self::setRequestCheckboxes();
    $modelClass = static::modelClass();
    if ($modelClass::validateCreate($_REQUEST)) {
      $chart = $modelClass::create($_REQUEST);
      $urlClass = static::urlClass();
      $showEditUrl = $urlClass::showEditUrl($chart->id, $library); 
      wp_redirect($showEditUrl);
    }
  }

  public static function edit() {
    $library = $_REQUEST['library'];
    self::setRequestCheckboxes();
    $id = (int) $_REQUEST['id'];
    $modelClass = static::modelClass();
    $chart = $modelClass::find($id)->fill($_REQUEST);
    if ($modelClass::validateUpdate($chart)) {
      $chart->save();
    }
    $urlClass = static::urlClass();
    $showEditUrl = $urlClass::showEditUrl($chart->id, $library);
    wp_redirect($showEditUrl);
  }

  private function columnNames($chartData) {
    if (array_key_exists(0, $chartData) && ! empty($chartData[0])) {
      return array_keys($chartData[0]);
    } else {
      return array();
    }
  }

  private static function setRequestCheckboxes() {
    foreach (static::checkboxFields() as $checkboxField) {
      if (array_key_exists($checkboxField, $_REQUEST) !== true) {
        $_REQUEST[$checkboxField] = false;
      }
    }
  }

  protected static function checkboxFields() {
    return array();
  }

}
