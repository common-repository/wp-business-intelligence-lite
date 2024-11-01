<?php $this->layout('admin/baseLayout', array('title' => 'Create Line Chart')) ?>
<form id='create-line-chart' action='<?=$this->e($action)?>' method='post'>

  <table class="form-table">
    <tbody>

      <?php $this->insert('admin/partials/QuerySelector', array('queries' => $queries)) ?>

      <tr>
        <th scope="row"><label for='cname'>Name</label></th>
        <td>
          <input id='cname' name='cname' type='text' class="regular-text" value="" />
        </td>
      </tr>

      <tr>
        <th scope="row"><label for='caption'>Caption</label></th>
        <td>
          <input id='caption' name='caption' type='text' class="regular-text" value="" />
        </td>
      </tr>

      <tr>
        <th scope="row"><label for='color_scheme'>Color Scheme</label></th>
        <td>
          <select id='color_scheme' name='color_scheme' class="regular-text">
            <?php foreach ($schemes as $scheme) : ?>
            <option value="<?php echo $scheme; ?>"><?php echo $scheme; ?></option>
            <?php endforeach; ?>
          </select>
        </td>
      </tr>

    </tbody>
  </table>

  <p class="submit">
    <input type="hidden" name="library" value="<?php echo $library; ?>"/>
    <input type="submit" name="submit" id="submit" class="button button-primary" value="Create">
  </p>

</form>
