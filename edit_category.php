<?php
//error_reporting(0);
//Require class 
require_once('db/library.php');
$obj = new Library();
if(isset($_POST['category_edit'])){
	if(!empty($_FILES['imageUpload']['name'])){
            $fileName  = $_FILES['imageUpload']['name'];
            $fileType  = strtolower(pathinfo($_FILES['imageUpload']['name'],PATHINFO_EXTENSION));
            $imageSize = $_FILES['imageUpload']['size'];
            $check = getimagesize($_FILES['imageUpload']['tmp_name']);
            //print_r($check);die();
            if($check == false){
                $imgErr = "Another Type of File Selected? That is not Image!";
            }else if($fileType !== 'jpg' && $fileType !== 'png'){
                $imgErr = "File Type Should be jpg or png Format!!";
            }elseif( $imageSize> 500000){//500kb bits to KB
                $imgErr = "File Size Should be below 500KB!";
            }else{
                /* create new name file */
                $filename   = uniqid() . "-" . time(); // 5dab1961e93a7-1571494241
                $extension  = pathinfo( $_FILES['imageUpload']['name'], PATHINFO_EXTENSION ); // jpg
                $basename   = $filename . "." . $extension; // 5dab1961e93a7_1571494241.jpg
                unlink($_POST['old_image']);
                $directory = "categories/{$basename}";
                $condition_arr=array('cat_name'=>$_POST['cat_name'],'category_image'=> $directory);
                $obj->updateData('categories', $condition_arr,'id',$_GET['id'],$page="categories_list.php");
                move_uploaded_file($_FILES['imageUpload']['tmp_name'],$directory);
            }
		}else{
			$condition_arr=array('cat_name'=>$_POST['cat_name']);
			$obj->updateData('categories', $condition_arr,'id',$_GET['id'],$page="categories_list.php");
		}
	}
/*Selct Categories By ID */
$condition_arr = array('id' =>$_GET['id']);
$result = $obj->getData('categories', '*', $condition_arr, 'id', 'desc');	
?>
<?php include('includes/header.php'); ?>
<div class="col-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Banner</h4>
            <p class="card-description">
                Edit Category
            </p>
            <form class="forms-sample" method="POST" id="myForm" enctype="multipart/form-data">
                <div class="form-group">
                      <label for="cat_name">Category Name</label>
                      <input type="text" class="form-control" id="cat_name" placeholder="Category Name" name="cat_name" required value="<?php echo $result[0]['cat_name']; ?>">
                </div>
                <div class="form-group">
                    <input type="hidden" name="old_image" value="<?php echo $result[0]['category_image']; ?>">
                    <label>Image upload</label>
                    <div id="preview"></div>
                    <input type="file" class="file-upload-default" id="imageUpload" name="imageUpload" accept="image/*" onchange="getImagePreview(event)">
                    <div class="input-group col-xs-12">
                        <input type="text" class="form-control file-upload-info"  placeholder="Upload Image" >
                        <span class="input-group-append">
                            <button class="file-upload-browse btn btn-primary" type="button">Upload</button>
                        </span>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary mr-2" name="category_edit">Submit</button>
                <button class="btn btn-light">Cancel</button>
            </form>
            <div class="row">
                <div class="col-md-12 grid-margin">
                    <div class="card-body d-flex align-items-center justify-content-end">
                        <label>Old Image</label>
                        <?php
                        if(!empty($result[0]['category_image'])){ ?>
                        <img src="<?php echo $result[0]['category_image']; ?>" width="200px" height="200px">
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
include('includes/footer.php');
include('includes/scripts.php');
?>
<!--Form Validation Code -->
<script>
function getImagePreview(event)
	  {
		var image=URL.createObjectURL(event.target.files[0]);
		var imagediv= document.getElementById('preview');
		var newimg=document.createElement('img');
		imagediv.innerHTML='';
		newimg.src=image;
		newimg.width="300";
		imagediv.appendChild(newimg);
	  }
</script>