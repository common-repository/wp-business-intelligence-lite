<?php $this->layout('admin/baseLayout', array('title' => 'Delete Database')) ?>
<p>Are you sure you want to delete this database connection?</p>
<p class="description">If this database is being used for queries, then those must be deleted first.</p>
<form action='<?=$this->e($action)?>' method='post'>
  <p class="submit"><input type="submit" name="submit" id="submit" class="button" value="Delete Database"></p>
</form>
