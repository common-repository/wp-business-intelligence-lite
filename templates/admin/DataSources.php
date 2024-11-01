<?php $this->layout('admin/baseLayout', array('title' => 'Data Sources')) ?>

<table class="form-table">
  <tbody>

    <?php foreach ($connections as $connection) : ?>
      <tr>
        <td>
          <h4><?=$this->e($connection['title'])?></h4>
          <div>
            <a href="<?=$this->e($connection['url'])?>" target="_blank" class="button button-primary">Create</a>
          </div>
        </td>
        <td>
          <p class="description">
            <?=$this->e($connection['description'])?>
          </p>
        </td>
      </tr>
    <?php endforeach; ?>

  </tbody>
</table>
