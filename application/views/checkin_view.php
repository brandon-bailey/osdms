<div class="container">
<?php if ($count > 0):?>
	<div class="alert alert-info">
	<caption>
			<center>
				<?php echo $this->lang->line('message_document_checked_out_to_you'). ' : ' . $count ?>
			</center>
		</caption>
	</div>
<table id="checkedOutTable" class="table table-striped">
	<thead>  
		<tr>
			  <td><?php echo $this->lang->line('button_check_in')?></td>
				<td><b><?php echo $this->lang->line('label_file_name')?></b></td>
				<td><b><?php echo $this->lang->line('label_description')?></b></td>
			   <td><b><?php echo $this->lang->line('label_created_date')?></b></td>
				<td><b><?php echo $this->lang->line('owner')?></b></td>
			   <td><b><?php echo $this->lang->line('label_size')?></b></td>
		</tr>
   </thead>
<?php
foreach($checkedOut as $row) :
if ($row->description == ''):
            $row->description = $this->lang->line('message_no_information_available');
        endif;
$fileName = $this->config->item('dataDir') . $row->location;
		?>
      <tr>
			   <td><a class="btn btn-primary" href="checkin/checkfilein/<?php echo $row->id?>" ><i class="fa fa-upload fa-2x"></i> <?php echo $this->lang->line('button_check_in')?></a>
			   </td>
				<td><?php echo $row->realname ?></td>
			  <td><?php echo $row->description ?></td>
			   <td><?php echo $this->globalFunction->fixDate($row->created) ?></td> 
			   <td><?php echo $row->last_name . ', ' . $row->first_name ?></td> 
				<td><?php echo $this->globalFunction->displayFilesize($fileName) ?></td> 
       </tr>
<?php endforeach; ?>
</table>

<?php else: ?>
<div class="alert alert-info">
<p>There are no files currently checked out to you.</p>
</div>
<?php endif;?>
</div>
<script>
jQuery(document).ready(function() {
jQuery('#checkedOutTable').DataTable();
});
</script>
