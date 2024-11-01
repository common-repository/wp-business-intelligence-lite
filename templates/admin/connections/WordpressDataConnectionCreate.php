<?php $this->layout('admin/baseLayout', array('title' => 'Create WordPress Data Charts')) ?>
<form id='create-database-connection' action='<?=$this->e($action)?>' method='post'>

  <table class="form-table">
    <tbody>

      <tr>
        <th scope="row"><label for='definition'>Name</label></th>
        <td>
          <select id='definition' name='name' class='large-text' required>
            <?php foreach ($wpData as $key => $data) : ?>
            <option value="<?=$this->e($key)?>"><?=$this->e($data)?></option>
            <?php endforeach; ?>
          </select>
        </td>
      </tr>

      <tr>
        <th scope="row"><label for='cname'>Chart Name</label></th>
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
            <option value="<?=$this->e($scheme)?>"><?=$this->e($scheme)?></option>
            <?php endforeach; ?>
          </select>
        </td>
      </tr>

      <tr>
        <td>
          <input id='library-link' name='library' type='hidden' value='posts_365' />
          <input id='chart_type-link' name='chart_type' type='hidden' value='posts_365' />
          <input id='query_id-link' name='query_id' type='hidden' value='posts_365' />
          <input id='topic-link' name='topic' type='hidden' value='posts_365' />
          <input id='value-link' name='value' type='hidden' value='posts_365' />
        </td>
      </tr>

    </tbody>
  </table>

  <p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary" value="Create"></p>
</form>

<script type="text/javascript">
  jQuery(document).ready(function($) {
    jQuery('#definition').change(function() {
      var name = $('option:selected', this).val();
      $('#library-link').val(name);
      $('#chart_type-link').val(name);
      $('#query_id-link').val(name);
      $('#topic-link').val(name);
      $('#value-link').val(name);
    });
  });
</script>
