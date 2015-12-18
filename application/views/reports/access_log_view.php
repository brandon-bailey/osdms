<div class="container">
<div id="col-md-12">
<?php if(isset($error)): ?>
<div class="alert alert-danger">
<p><?php echo $error['msg']; ?></p>
</div>
<?php else: ?>
    <table id="accessLogTable" class="table table-striped table-hover">
    <thead>
        <tr>
            <?php if (isset($showCheckBox)):?>
                <th><input type="checkbox" id="checkall"/></th>
           <?php endif;?>
            <th>Filename</th>
            <th>File ID</th>
            <th>Username</th>
            <th>Action</th>
            <th>Date</th>
        </tr>
    </thead>
    <tbody>
	<?php 
?>
<?php foreach($accessLogArray as  $item):
			?>
        <tr
		<?php if($item['action'] == 'File Deleted'):?>class="error"<?php endif;?>
		<?php if($item['action'] == 'File Rejected'):?>class="warning"<?php endif;?>
		>
            <td><a href="<?php echo $item['details_link']?>"><?php echo $item['realname'] ?></a></td>
            <td ><?php echo $item['file_id'] ?></td>
            <td><?php echo $item['user_name'] ?></td>
			<td><?php echo $item['action'] ?></td>
            <td><?php echo $item['timestamp'] ?></td>
        </tr>
  <?php

  endforeach;?>
    </tbody>
    <tfoot>
       <tr>
            <th>Filename</th>
            <th>File ID</th>
            <th>Username</th>
            <th>Action</th>
            <th>Date</th>
        </tr>
    </tfoot>
</table>
<?php endif; ?>
</div>
</div>
  <script>
  jQuery(document).ready(function() {
jQuery('#accessLogTable').DataTable();
});
  </script>