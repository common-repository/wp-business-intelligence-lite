<?php $this->layout('admin/baseLayout', array('title' => 'Edit WordPress Data Charts')) ?>
<form id='edit-database-connection' action='<?=$this->e($action)?>' method='post'>
  <input type='hidden' value='<?=$this->e($id)?>' name='id' />

  <table class="form-table">
    <tbody>

      <tr>
        <th scope="row"><label for='name'>Name</label></th>
        <td>
          <select id='definition' name='name' class='large-text' required>
            <?php foreach ($wpData as $key => $data) : ?>
            <option value="<?=$this->e($key)?>" <?=$this->e($databaseConnection->name) == $key ? 'selected' : ''?>><?=$this->e($data)?></option>
            <?php endforeach; ?>
          </select>
        </td>
      </tr>

      <tr>
        <th scope="row"><label for='cname'>Chart Name</label></th>
        <td>
          <input id='cname' name='cname' type='text' class="regular-text" value="<?=$this->e($databaseConnection->cname)?>" />
        </td>
      </tr>

      <tr>
        <th scope="row"><label for='caption'>Caption</label></th>
        <td>
          <input id='caption' name='caption' type='text' class="regular-text" value="<?=$this->e($databaseConnection->caption)?>" />
        </td>
      </tr>

      <tr>
        <th scope="row"><label for='color_scheme'>Color Scheme</label></th>
        <td>
          <select id='color_scheme' name='color_scheme' class="regular-text" autocomplete="off">
            <?php foreach ($schemes as $scheme) : ?>
            <option value="<?php echo $scheme; ?>" <?php echo (($databaseConnection->color_scheme == $scheme) ? 'selected' : ''); ?>><?php echo $scheme; ?></option>
            <?php endforeach; ?>
          </select>
        </td>
      </tr>

      <tr>
        <td>
          <input id='library-link' name='library' type='hidden' value='<?php echo !empty($databaseConnection->name) ? $databaseConnection->name : 'posts_365'; ?>' />
          <input id='chart_type-link' name='chart_type' type='hidden' value='<?php echo !empty($databaseConnection->name) ? $databaseConnection->name : 'posts_365'; ?>' />
          <input id='query_id-link' name='query_id' type='hidden' value='<?php echo !empty($databaseConnection->name) ? $databaseConnection->name : 'posts_365'; ?>' />
          <input id='topic-link' name='topic' type='hidden' value='<?php echo !empty($databaseConnection->name) ? $databaseConnection->name : 'posts_365'; ?>' />
          <input id='value-link' name='value' type='hidden' value='<?php echo !empty($databaseConnection->name) ? $databaseConnection->name : 'posts_365'; ?>' />
        </td>
      </tr>

    </tbody>
  </table>

  <p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary" value="Save Changes"></p>

</form>

<p>If a embedded widget is not shown below, an error has occurred.
  Please check that your URL returns a non-empty oEmbed results.</p>
<?=$wpDataHtml?>

<?php $this->insert('admin/partials/WpDataShortcode', array('wpDataId' => $id)) ?>

<script type="text/javascript">
  jQuery(document).ready(function($) {
    jQuery('#definition').change(function() {
      var name = $('option:selected', this).val();
      jQuery('#library-link').val(name);
      jQuery('#chart_type-link').val(name);
      jQuery('#query_id-link').val(name);
      jQuery('#topic-link').val(name);
      jQuery('#value-link').val(name);
    });
  });
</script>
