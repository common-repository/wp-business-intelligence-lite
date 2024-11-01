<?php
namespace Wpbi\Admin\Menu;

use League\Plates\Engine;
use Wpbi\Admin\Table\Action;
use Wpbi\Admin\Table\Actions;
use Wpbi\Admin\Table\ChartTable;
use Wpbi\Admin\Url\Chart as ChartUrl;
use Wpbi\Settings;

// TODO: uncovered
// TODO: address class complexity
/**
 * @SuppressWarnings(PHPMD.ExcessiveClassComplexity)
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class Chart {

  public static function menuSlug() {
    return 'chart';
  }

  public static function addMenu() {
    $parentSlug = Main::menuSlug();
    $pageTitle = 'Charts';
    $menuTitle = 'Charts';
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
      case 'showCreate':
        (new self)->showCreate();
        break;
      case 'showIndex':
      default:
        (new self)->showIndex();
        break;
    }
  }

  public static function showIndex() {
    $chart = new \Wpbi\Models\Chart();
    $charts = $chart->allChartsToArray();
    $chartTable = new ChartTable();
    $adminTable = new \Wpbi\Admin\Table\AdminTable($charts, $chartTable->getColumns());
    static::addActions($adminTable);
    $adminTable->prepare_items();
    echo (new Engine(Settings::platesDirectory()))
      ->render('admin/ChartIndex',
        array('table' => $adminTable->getHtml(),
          'showCreateUrl' => ChartUrl::showCreateUrl()));
  }

  public function showCreate() {
    echo (new Engine(Settings::platesDirectory()))
      ->render('admin/ChartCreate', array(
        'chartTypes' => \Wpbi\Models\Chart::$chartTypes,
        'chartTypesChartJs' => \Wpbi\Models\Chart::$chartTypesChartJs,
        'action' => ChartUrl::createUrl(),
        'chartLibrary' => Settings::chartLibrary()));
  }

  public static function showDelete() {
    $id = (int) $_REQUEST['id'];
    $chartSlug = $_REQUEST['chart_slug'];
    $url = ChartUrl::deleteUrl($id, $chartSlug);
    echo (new Engine(Settings::platesDirectory()))->render('admin/ChartDelete', array('action' => $url));
  }

  /**
   * @SuppressWarnings(PHPMD.CyclomaticComplexity)
   * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
   */
  public static function create() {

    if ($_POST['chart-lib'] == 'britechart') {
    switch ($_POST['chart-type-britechart']) {
      case 'bar-chart':
        wp_redirect(\Wpbi\Admin\Url\Britechart\BarChart::showCreateUrl(Settings::britechartSlug()));
        break;
      case 'pie-chart':
        wp_redirect(\Wpbi\Admin\Url\Britechart\PieChart::showCreateUrl(Settings::britechartSlug()));
        break;
      case 'grouped-bar-chart':
        wp_redirect(\Wpbi\Admin\Url\Britechart\GroupedBarChart::showCreateUrl(Settings::britechartSlug()));
        break;
      case 'line-chart':
        wp_redirect(\Wpbi\Admin\Url\Britechart\LineChart::showCreateUrl(Settings::britechartSlug()));
        break;
      case 'sparkline-chart':
        wp_redirect(\Wpbi\Admin\Url\Britechart\SparklineChart::showCreateUrl(Settings::britechartSlug()));
        break;
      case 'stacked-area-chart':
        wp_redirect(\Wpbi\Admin\Url\Britechart\StackedAreaChart::showCreateUrl(Settings::britechartSlug()));
        break;
      case 'stacked-bar-chart':
        wp_redirect(\Wpbi\Admin\Url\Britechart\StackedBarChart::showCreateUrl(Settings::britechartSlug()));
        break;
      case 'step-chart':
        wp_redirect(\Wpbi\Admin\Url\Britechart\StepChart::showCreateUrl(Settings::britechartSlug()));
        break;
      case 'step-chart':
        wp_redirect(\Wpbi\Admin\Url\Britechart\StepChart::showCreateUrl(Settings::britechartSlug()));
        break;
      case 'step-chart':
        wp_redirect(\Wpbi\Admin\Url\Britechart\StepChart::showCreateUrl(Settings::britechartSlug()));
        break;
    }
    } elseif ($_POST['chart-lib'] == 'chartjs') {

      switch ($_POST['chart-type-chartjs']) {
        case 'chartjs-line-chart':
          wp_redirect(\Wpbi\Admin\Url\Chartjs\ChartjsLineChart::showCreateUrl(Settings::chartjsSlug()));
          break;
        case 'chartjs-doughnut-chart':
          wp_redirect(\Wpbi\Admin\Url\Chartjs\ChartjsDoughnutChart::showCreateUrl(Settings::chartjsSlug()));
          break;
        case 'radar-chart':
          wp_redirect(\Wpbi\Admin\Url\Chartjs\RadarChart::showCreateUrl(Settings::chartjsSlug()));
          break;
        case 'vertical-bar-chart':
          wp_redirect(\Wpbi\Admin\Url\Chartjs\VerticalBarChart::showCreateUrl(Settings::chartjsSlug()));
          break;
      }
    }
  }

  /**
   * @SuppressWarnings(PHPMD.CyclomaticComplexity)
   * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
   */
  public static function redirectEdit() {
    $id = (int) $_REQUEST['id'];
    switch ($_REQUEST['chart_slug']) {
      case 'bar-chart':
        wp_redirect(\Wpbi\Admin\Url\Britechart\BarChart::showEditUrl($id, Settings::britechartSlug()));
        break;
      case 'pie-chart':
        wp_redirect(\Wpbi\Admin\Url\Britechart\PieChart::showEditUrl($id, Settings::britechartSlug()));
        break;
      case 'grouped-bar-chart':
        wp_redirect(\Wpbi\Admin\Url\Britechart\GroupedBarChart::showEditUrl($id, Settings::britechartSlug()));
        break;
      case 'line-chart':
        wp_redirect(\Wpbi\Admin\Url\Britechart\LineChart::showEditUrl($id, Settings::britechartSlug()));
        break;
      case 'sparkline-chart':
        wp_redirect(\Wpbi\Admin\Url\Britechart\SparklineChart::showEditUrl($id, Settings::britechartSlug()));
        break;
      case 'stacked-area-chart':
        wp_redirect(\Wpbi\Admin\Url\Britechart\StackedAreaChart::showEditUrl($id, Settings::britechartSlug()));
        break;
      case 'stacked-bar-chart':
        wp_redirect(\Wpbi\Admin\Url\Britechart\StackedBarChart::showEditUrl($id, Settings::britechartSlug()));
        break;
      case 'step-chart':
        wp_redirect(\Wpbi\Admin\Url\Britechart\StepChart::showEditUrl($id, Settings::britechartSlug()));
        break;

      case 'radar-chart':
        wp_redirect(\Wpbi\Admin\Url\Chartjs\RadarChart::showEditUrl($id, Settings::chartjsSlug()));
        break;
      case 'chartjs-doughnut-chart':
        wp_redirect(\Wpbi\Admin\Url\Chartjs\ChartjsDoughnutChart::showEditUrl($id, Settings::chartjsSlug()));
        break;
      case 'chartjs-line-chart':
        wp_redirect(\Wpbi\Admin\Url\Chartjs\ChartjsLineChart::showEditUrl($id, Settings::chartjsSlug()));
        break;
      case 'stepped-line-chart':
        wp_redirect(\Wpbi\Admin\Url\Chartjs\SteppedLineChart::showEditUrl($id, Settings::chartjsSlug()));
        break;
    }
  }

  /**
   * @SuppressWarnings(PHPMD.CyclomaticComplexity)
   * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
   */
  public static function delete() {
    $id = (int) $_REQUEST['id'];
    switch ($_REQUEST['chart-type']) {
      case 'bar-chart':
        \Wpbi\Models\Britechart\BarChart::destroy($id);
        break;
      case 'pie-chart':
        \Wpbi\Models\Britechart\PieChart::destroy($id);
        break;
      case 'grouped-bar-chart':
        \Wpbi\Models\Britechart\GroupedBarChart::destroy($id);
        break;
      case 'line-chart':
        \Wpbi\Models\Britechart\LineChart::destroy($id);
        break;
      case 'sparkline-chart':
        \Wpbi\Models\Britechart\SparklineChart::destroy($id);
        break;
      case 'stacked-area-chart':
        \Wpbi\Models\Britechart\StackedAreaChart::destroy($id);
        break;
      case 'stacked-bar-chart':
        \Wpbi\Models\Britechart\StackedBarChart::destroy($id);
        break;
      case 'step-chart':
        \Wpbi\Models\Britechart\StepChart::destroy($id);
        break;

      case 'radar-chart':
        \Wpbi\Models\Chartjs\RadarChart::destroy($id);
        break;
      case 'chartjs-line-chart':
        \Wpbi\Models\Chartjs\ChartjsLineChart::destroy($id);
        break;
      case 'chartjs-doughnut-chart':
        \Wpbi\Models\Chartjs\ChartjsDoughnutChart::destroy($id);
        break;
      case 'vertical-bar-chart':
        \Wpbi\Models\Chartjs\VerticalBarChart::destroy($id);
        break;
    }
    wp_redirect(ChartUrl::showIndexUrl());
  }

  private static function addActions($adminTable) {
    $actions = new Actions();
    $actions->addAction(new Action(Settings\WpActions::REDIRECT_EDIT_CHART, admin_url('admin-post.php'),
      'edit', array('id', 'chart_slug')));
    $actions->addAction(new Action('showDelete', menu_page_url(self::menuSlug(), false),
      'delete', array('id', 'chart_slug')));
    $adminTable->actions = $actions;
  }

}
