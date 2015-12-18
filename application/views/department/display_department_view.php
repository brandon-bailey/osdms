<div class="modal fade" role="dialog" id="displayDepartmentModal" data-keyboard="false" data-backdrop="static">
<div class="modal-dialog">
<div class="modal-content">
  <div class="modal-header">
   <a class="close" data-dismiss="modal" name="closeModal">
		<i class="fa fa-times"></i></a>
    <center><h3 >Displaying <?php echo $deptDetails[0]->name ?></h3></center>
  </div> 
  <div class="modal-body">
<div class="row-fluid">	
<div class="well">
<center>
<h3> <?php echo $deptDetails[0]->name ?> </h3>
<h4>Department ID: <?php echo $deptDetails[0]->id?></h4>
<label> Color: <input type="color" value="<?php echo $deptDetails[0]->color ?>" disabled></input></label>
<p><b>Users in this department</b></p>
	    <table id="departmentTable" name="main" class="table table-striped">
			<thead>
				<tr>
                  <th>
				  Last Name
				  </th>
				    <th>
				  First Name
				  </th>
                </tr>
			</thead>
						<tbody>
						<?php	foreach ($deptUsers as $row) : ?>
								<tr>
								<td> <?php echo $row->first_name ?></td>
								<td><?php echo $row->last_name ?></td>
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
jQuery('#departmentTable').DataTable();
});
  </script>
</div>	