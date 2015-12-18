<div class="modal fade" role="dialog" id="displayCategoryModal" data-keyboard="false" data-backdrop="static">
<div class="modal-dialog">
<div class="modal-content">
  <div class="modal-header">
   <a class="close" data-dismiss="modal" name="closeModal">
		<i class="fa fa-times"></i></a>
    <center><h3 >Displaying <?php echo $categoryDetails->name ?></h3></center>
  </div> 
  <div class="modal-body">
<div class="row-fluid">	
<div class="well">
<center>
<h3> <?php echo $categoryDetails->name ?> </h3>
<h4>Category ID: <?php echo $categoryDetails->id?></h4>
<p><b>Files in this category</b></p>
	    <table id="categoryFileTable" name="main" class="table table-striped">
			<thead>
				<tr>
				  <th>
				  File ID
				  </th>				
                  <th>
				  File Name
				  </th>
                </tr>
			</thead>
						<tbody>
						<?php	foreach ($categoryFiles as $file) : ?>
								<tr>
								<td> <?php echo $file->id ?></td>
								<td><?php echo $file->realname ?></td>
								</tr>
						<?php endforeach; ?>
						</tbody>
                            </table>
						</center>
						</div>
					</div>       
                      
  </div>
  <div class="modal-footer">
  <a class="btn btn-primary" data-dismiss="modal" name="closeModal" >Close</a>
  </div>
  </div>
  </div>
  <script>
  jQuery(document).ready(function() {
jQuery('#categoryFileTable').DataTable();
});
  </script>
</div>	