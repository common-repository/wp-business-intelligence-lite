<?php $this->layout('admin/baseLayout',
  array('title' => 'WordPress Business Intelligence Pro', 'titleAction' => null ))
?>
<?=$v?>
<p><?=$query?></p>
<p><?=$chart?></p>
<p><?=$dataTable?></p>
<p><?=$variable?></p>
<div class="notice notice-success"><p><?=$message?></p></div>
