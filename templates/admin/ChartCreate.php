<?php $this->layout('admin/baseLayout', array('title' => 'Create Chart')) ?>
<form id='create-chart' action='<?=$this->e($action)?>' method='post'>
  <table class="form-table">
    <tbody>
      <tr>
        <th scope="row"><label for='chart-lib'>Library</label></th>
        <td>
          <select name="chart-lib">
            <?php foreach ($chartLibrary as $lib): ?>
              <option value="<?=$lib?>"><?=ucwords($lib)?></option>
            <?php endforeach; ?>
          </select>
        </td>
      </tr>
      <tr id="chart-type-britechart">
        <th scope="row"><label for='chart-type-britechart'>Chart Type</label></th>
        <td>
          <select name="chart-type-britechart">
            <?php foreach ($chartTypes as $chartType): ?>
              <option value="<?=$chartType['slug']?>"><?=$chartType['name']?></option>
            <?php endforeach; ?>
          </select>
        </td>
      </tr>
      <tr id="chart-type-chartjs">
        <th scope="row"><label for='chart-type-chartjs'>Chart Type</label></th>
        <td>
          <select name="chart-type-chartjs">
            <?php foreach ($chartTypesChartJs as $chartType): ?>
              <option value="<?=$chartType['slug']?>"><?=$chartType['name']?></option>
            <?php endforeach; ?>
          </select>
        </td>
      </tr>
      <tr id="chart-type-googlechart">
        <th scope="row"><label for='chart-type-googlechart'>Chart Type</label></th>
        <td>
          <select name="chart-type-googlechart">
            <?php foreach ($chartTypesGooglechart as $chartType): ?>
              <option value="<?=$chartType['slug']?>"><?=$chartType['name']?></option>
            <?php endforeach; ?>
          </select>
        </td>
      </tr>
      <tr id="chart-type-counterchart">
        <th scope="row"><label for='chart-type-counterchart'>Chart Type</label></th>
        <td>
          <select name="chart-type-counterchart">
            <?php foreach ($chartTypesCounterchart as $chartType): ?>
              <option value="<?=$chartType['slug']?>"><?=$chartType['name']?></option>
            <?php endforeach; ?>
          </select>
        </td>
      </tr>

    </tbody>
  </table>
  <p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary" value="Create"></p>
</form>
<script type="text/javascript">
    jQuery(document).ready(function($) {
      $('#chart-type-britechart').show();
      $('#chart-type-chartjs, #chart-type-googlechart, #chart-type-counterchart').hide();
      $('select[name="chart-lib"]').val('britechart');
      $('select[name="chart-lib"]').on('change', function() {
        var option = $('option:selected', this).val();
        if (option == 'britechart') {
          $('#chart-type-britechart').show();
          $('#chart-type-chartjs, #chart-type-googlechart, #chart-type-counterchart').hide();
        } else if (option == 'chartjs') {
          $('#chart-type-britechart, #chart-type-googlechart, #chart-type-counterchart').hide();
          $('#chart-type-chartjs').show();
        } else if (option == 'googlechart') {
          $('#chart-type-britechart, #chart-type-chartjs, #chart-type-counterchart').hide();
          $('#chart-type-googlechart').show();
        } else if (option == 'counter') {
          $('#chart-type-britechart, #chart-type-chartjs, #chart-type-googlechart').hide();
          $('#chart-type-counterchart').show();
        }
      });
    });
</script>
