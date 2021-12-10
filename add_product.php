<?php
//error_reporting(0);
//Require class 
require_once('db/library.php');
$obj = new Library();
if(isset($_POST['add_category'])){
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
                $directory = "products/{$basename}";
                $condition_arr=array('product_name'=>$_POST['product_name'],'cat_id'=>$_POST['cat_id'],'buy_price'=>$_POST['buy_price'],'sell_price'=>$_POST['sell_price'],'product_image'=> $directory);
                $obj->insertData('products',$condition_arr,$page='products_list.php');
                move_uploaded_file($_FILES['imageUpload']['tmp_name'],$directory);
            }
		}
	}
/*Select Authors */
$categories = $obj->getData('categories', '*', '', 'id', 'desc');	
?>
<?php include('includes/header.php'); ?>
<div class="col-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Product</h4>
            <p class="card-description">
                Add Product
            </p>
            <form class="forms-sample" method="POST" id="myForm" enctype="multipart/form-data">
                <div class="form-group">
                      <label for="cat_name">Product Name</label>
                      <input type="text" class="form-control" id="product_name" placeholder="Product Name" name="product_name" required>
                </div>
                <div class="form-group">
                    <label for="cat_id">Category</label>
                    <select class="form-control" id="cat_id" name="cat_id" required>
                        <option value="">Select Category</option>
                        <?php
                        if($categories)
                        foreach ($categories as  $cat) {
                        ?>
                        <option value="<?php echo $cat['id']?>"><?php echo $cat['cat_name']?></option>
                        <?php
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                      <label for="buy_price">Buy Price</label>
                      <input type="text" class="form-control" id="buy_price	" placeholder="Buy Price" name="buy_price" required>
                </div>
                <div class="form-group">
                      <label for="sell_price">Sell Price</label>
                      <input type="text" class="form-control" id="sell_price" placeholder="Sell Price" name="sell_price" required>
                </div>
                <div class="form-group">
                    <label>Category Image</label>
                    <div id="preview"></div>
                    <input type="file" class="file-upload-default" id="imageUpload" name="imageUpload" accept="image/*" onchange="getImagePreview(event)" required>
                    <div class="input-group col-xs-12">
                        <input type="text" class="form-control file-upload-info"  placeholder="Upload Image" >
                        <span class="input-group-append">
                            <button class="file-upload-browse btn btn-primary" type="button">Upload</button>
                        </span>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary mr-2" name="add_category">Submit</button>
                <button class="btn btn-light">Cancel</button>
            </form>
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