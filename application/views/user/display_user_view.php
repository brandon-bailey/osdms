<div class="modal fade" role="dialog" id="displayUserModal" data-keyboard="false" data-backdrop="static">
<div class="modal-dialog">
<div class="modal-content">
  <div class="modal-header">
   <a class="close" data-dismiss="modal" name="closeModal">
		<i class="fa fa-times"></i></a>
        <div class="text-center">
		<h3 >Displaying <?php echo $userDetails->username ?></h3>
		</div>
  </div> 
  <div class="modal-body">
				<div class="row-fluid">
				<div class="well">
				    <div class="text-center">
				<h3> User Information for <?php echo $userDetails->username?></h3>
				</div>
				</div>
				</div>
                        <table class="table table-striped table-condensed">                   
                                    
               
             <tr><td>ID</td><td><?php echo  $userDetails->id ?></td></tr>
               <tr><td>Last Name</td><td><?php echo $userDetails->last_name?></td></tr>
              <tr><td>First Name</td><td><?php echo $userDetails->first_name ?></td></tr>
               <tr><td>Username</td><td><?php echo $userDetails->username?></td></tr>
              <tr><td>Department</td><td><?php echo $newUserObj->getDeptName()?></td></tr>
              <tr><td>Email</td><td><?php echo $userDetails->email ?></td></tr>
               <tr><td>Phone Number</td><td><?php echo $userDetails->phone ?></td></tr>
                <tr><td>Admin</td>
<?php    if ($newUserObj->isAdmin()):              
                        $isAdmin = 'Yes';          
				else:                
                        $isAdmin = 'No';
                endif; ?>
               <td><?php echo $isAdmin ?></td>
               </tr>
               <?php  $isReviewer = 'No';
					if($newUserObj->isReviewer()):                
                        $isReviewer    = 'Yes';
					endif; ?>
              <tr><td>Reviewer</td>
			  <td><?php echo $isReviewer ?></td></tr>         
                 
                        </table>          
                      
  </div>
  <div class="modal-footer">
  <a class="btn btn-primary" data-dismiss="modal" name="closeModal" >Close</a>
  </div>
  </div>
  </div>
</div>	
