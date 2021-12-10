<?php
require_once('db/library.php');
$obj = new Library();
/*===STatus Change Data == */
if (isset($_GET['id']) && isset($_GET['status'])) {
	//var_dump((Int)$_GET['status']);die();
	if($_GET['status'] == "1" ){
		$status = 0;
	}else{
		$status = 1;
	}
  $condition_arr = array('status' =>$status);
  $obj->updateData('banners', $condition_arr,'id',$_GET['id'],$page="banner_list.php");
}

$result = $obj->getData('banners', '*', '', 'id', 'desc');

?>
<?php include('includes/header.php'); ?>
<div class="row">
  <div class="col-md-12 grid-margin">
      <div class="card-body d-flex align-items-center justify-content-end">
        <a href="add_banner.php" class="btn btn-info d-none d-md-block">Add Banner</a>
      </div>
  </div>
</div>
<div class="card">
            <div class="card-body">
              <h4 class="card-title">Data table</h4>
              <div class="row">
                <div class="col-12">
                  <div class="table-responsive">
                    <table id="order-listing" class="table">
                      <thead>
                        <tr>
                            <th>SL #</th>
                            <th>Banner</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                         $sl = 1;
                         if($result)
                         foreach ($result as  $fdata) {
                        ?>
                        <tr>
                            <td><?php echo $sl++; ?></td>
                            <td><img src="<?php echo $fdata['banner_image']?>" alt="no-image"></td>
                            <td><?php echo $fdata['status']? 'active' : 'Inactive'; ?></td>
                            <td>
                              <a href="edit_banner.php?id=<?php echo $fdata['id'];?>" class="btn btn-primary"><i class="fa fa-edit"></i></a>
                              <a href="banner_list.php?id=<?php echo $fdata['id']; ?>&status=<?php echo $fdata['status']; ?>" class="badge badge-danger"><i class="fa fa-times"></i></a>
                            </td>
                        </tr>
                        <?php
                         }
                        ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
          
<?php 
	include('includes/footer.php');
	include('includes/scripts.php');
?>    