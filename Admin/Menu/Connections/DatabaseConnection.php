<?php
namespace Wpbi\Admin\Menu\Connections;

use Wpbi\Admin\Menu\Main;
use League\Plates\Engine;
use Wpbi\Admin\Table\Action;
use Wpbi\Admin\Table\Actions;
use Wpbi\Admin\Table\DatabaseConnectionTable;
use Wpbi\Admin\Url\Connections\DatabaseConnection as DatabaseConnectionUrl;
use Wpbi\Models\DatabaseConnection as DatabaseConnectionModel;
use Wpbi\Settings;

// TODO: uncovered
class DatabaseConnection {

  public static function menuSlug() {
    return 'database-connection';
  }

  public static function addMenu() {
    $parentSlug = Main::menuSlug();
    $pageTitle = 'Connections';
    $menuTitle = 'Connections';
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
    DatabaseConnectionModel::destroy($id);
    wp_redirect(DatabaseConnectionUrl::showIndexUrl());
  }

  public static function create() {
    if (DatabaseConnectionModel::validateCreate($_REQUEST)) {
      DatabaseConnectionModel::create($_REQUEST);
      wp_redirect(DatabaseConnectionUrl::showIndexUrl());
    } else {
      wp_redirect(DatabaseConnectionUrl::showCreateUrl());
    }
  }

  public static function edit() {
    $id = (int) $_REQUEST['id'];
    $databaseConnection = DatabaseConnectionModel::find($id)->fill($_REQUEST);
    if (DatabaseConnectionModel::validateUpdate($databaseConnection)) {
      $databaseConnection->save();
    }
    wp_redirect(DatabaseConnectionUrl::showEditUrl($id));
  }

  public function showCreate() {
    echo (new Engine(Settings::platesDirectory()))
      ->render('admin/connections/DatabaseConnectionCreate', array('action' => DatabaseConnectionUrl::createUrl()));
  }

  public function showDelete() {
    $id = (int) $_REQUEST['id'];
    $url = DatabaseConnectionUrl::deleteUrl($id);
    echo (new Engine(Settings::platesDirectory()))->render('admin/connections/DatabaseConnectionDelete', array('action' => $url));
  }

  public function showEdit() {
    $id = (int) $_REQUEST['id'];
    $databaseConnection = DatabaseConnectionModel::find($id);
    echo (new Engine(Settings::platesDirectory()))
      ->render('admin/connections/DatabaseConnectionEdit',
               array('databaseConnection' => $databaseConnection,
                     'id' => $id,
                     'action' => DatabaseConnectionUrl::editUrl()));
  }

  public static function showIndex() {
    $dbConnectionsTable = new DatabaseConnectionTable();
    $rows = DatabaseConnectionModel::all(array_keys($dbConnectionsTable->getColumns()))->toArray();
    $adminTable = new \Wpbi\Admin\Table\AdminTable($rows, $dbConnectionsTable->getColumns());
    self::addActions($adminTable);
    $adminTable->prepare_items();
    echo (new Engine(Settings::platesDirectory()))
      ->render('admin/connections/DatabaseConnectionIndex',
               array('table' => $adminTable->getHtml(), 'showCreateUrl' => DatabaseConnectionUrl::showCreateUrl()));
  }

  private static function addActions($adminTable) {
    $actions = new Actions();
    $actions->addAction(new Action('showEdit', menu_page_url(self::menuSlug(), false), 'edit'));
    $actions->addAction(new Action('showDelete', menu_page_url(self::menuSlug(), false), 'delete'));
    $adminTable->actions = $actions;
  }

}
