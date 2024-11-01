<?php
namespace Wpbi\Admin\Menu\Connections;

use Wpbi\Admin\Menu\Main;
use League\Plates\Engine;
use Wpbi\Admin\Table\Action;
use Wpbi\Admin\Table\Actions;
use Wpbi\Admin\Table\WordpressDataConnectionTable;
use Wpbi\Admin\Url\Connections\WordpressDataConnection as WordpressDataConnectionUrl;
use Wpbi\Models\WordpressDataConnection as WordpressDataConnectionModel;
use Wpbi\Settings;

// TODO: uncovered
class WordpressDataConnection {

  public static function menuSlug() {
    return 'wordpress-data-connection';
  }

  protected static function checkboxFields() {
    return array('in_dash');
  }

  public static function addMenu() {
    $parentSlug = Main::menuSlug();
    $pageTitle = 'WordPress Data';
    $menuTitle = 'WordPress Data';
    $capability = Settings::capability();
    $menuSlug = self::menuSlug();
    $function = array(self::class, 'route');
    add_submenu_page($parentSlug, $pageTitle, $menuTitle, $capability, $menuSlug, $function);
  }

  /**
   * @SuppressWarnings(PHPMD.CyclomaticComplexity)
   */
  public static function route() {

    $action = (isset($_GET['action']) === true) ? $_GET['action'] : 'showIndex';
    switch ($action) {
      case 'showDelete':
        (new self)->showDelete();
        break;
      case 'showEdit':
        (new self)->showEdit();
        break;
      case 'showCreate':
        (new self)->showCreate();
        break;
      case 'showIndex':
      default:
        (new self)->showIndex();
        break;
    }
  }

  public static function delete() {
    $id = (int) $_REQUEST['id'];
    WordpressDataConnectionModel::destroy($id);
    wp_redirect(WordpressDataConnectionUrl::showIndexUrl());
  }

  public static function create() {
    if (WordpressDataConnectionModel::validateCreate($_REQUEST)) {
      self::setRequestCheckboxes();
      $databaseConnection = WordpressDataConnectionModel::create($_REQUEST);
      self::runWpDataQueries($databaseConnection);
      wp_redirect(WordpressDataConnectionUrl::showIndexUrl());
    } else {
      wp_redirect(WordpressDataConnectionUrl::showCreateUrl());
    }
  }

  public static function edit() {
    $id = (int) $_REQUEST['id'];
    self::setRequestCheckboxes();
    $databaseConnection = WordpressDataConnectionModel::find($id)->fill($_REQUEST);
    if (!empty($databaseConnection) && WordpressDataConnectionModel::validateUpdate($databaseConnection)) {
      $databaseConnection->save();
      self::runWpDataQueries($databaseConnection);
    }
    wp_redirect(WordpressDataConnectionUrl::showEditUrl($id));
  }

  public function showCreate() {
    echo (new Engine(Settings::platesDirectory()))
      ->render('admin/connections/WordpressDataConnectionCreate', array(
        'action' => WordpressDataConnectionUrl::createUrl(),
        'library' => Settings::chartLibrary(),
        'schemes' => Settings::britechartsColorScheme(),
        'chartTypes' => Settings::chartTypes(),
        'wpData' => Settings::wordpressDataDefaults()
      ));
  }

  public function showDelete() {
    $id = (int) $_REQUEST['id'];
    $url = WordpressDataConnectionUrl::deleteUrl($id);
    echo (new Engine(Settings::platesDirectory()))->render('admin/connections/WordpressDataConnectionDelete', array('action' => $url));
  }

  public function showEdit() {
    $id = (int) $_REQUEST['id'];
    $databaseConnection = WordpressDataConnectionModel::find($id);
    echo (new Engine(Settings::platesDirectory()))
      ->render('admin/connections/WordpressDataConnectionEdit',
               array('databaseConnection' => $databaseConnection,
                     'id' => $id,
                     'action' => WordpressDataConnectionUrl::editUrl(),
                     'wpDataHtml' => do_Shortcode('[wpbi_wp_data id="' . $id . '" /]'),
                     'library' => Settings::chartLibrary(),
                     'schemes' => Settings::britechartsColorScheme(),
                     'chartTypes' => Settings::chartTypes(),
                     'wpData' => Settings::wordpressDataDefaults()
                   ));
  }

  public static function showIndex() {
    $dbConnectionsTable = new WordpressDataConnectionTable();
    $rows = WordpressDataConnectionModel::all(array_keys($dbConnectionsTable->getColumns()))->toArray();
    $adminTable = new \Wpbi\Admin\Table\AdminTable($rows, $dbConnectionsTable->getColumns());
    $adminTable->prepare_items();
    self::addActions($adminTable);
    echo (new Engine(Settings::platesDirectory()))
      ->render('admin/connections/WordpressDataConnectionIndex',
               array(
                 'table' => $adminTable->getHtml(),
                 'showCreateUrl' => WordpressDataConnectionUrl::showCreateUrl(),
                 'library' => Settings::chartLibrary(),
                 'schemes' => Settings::britechartsColorScheme(),
                 'chartTypes' => Settings::chartTypes(),
                 'wpData' => Settings::wordpressDataDefaults()
             ));
  }

  private static function addActions($adminTable) {
    $actions = new Actions();
    $actions->addAction(new Action('showEdit', menu_page_url(self::menuSlug(), false), 'edit'));
    $actions->addAction(new Action('showDelete', menu_page_url(self::menuSlug(), false), 'delete'));
    $adminTable->actions = $actions;
  }

  private static function setRequestCheckboxes() {
    foreach (static::checkboxFields() as $checkboxField) {
      if (array_key_exists($checkboxField, $_REQUEST) !== true) {
        $_REQUEST[$checkboxField] = 0;
      }
    }
  }

  private static function runWpDataQueries($id) {
    WordpressDataConnectionModel::run($id);
  }
}
