<?php $this->layout('admin/baseLayout', array('title' => 'Delete WordPress Data')) ?>
<p>Are you sure you want to delete this WordPress Data connection?</p>
<form action='<?=$this->e($action)?>' method='post'>
  <p class="submit"><input type="submit" name="submit" id="submit" class="button" value="Delete WP Data"></p>
</form>
