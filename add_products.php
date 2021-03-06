<?php
session_start();
include("../../db.php");


if(isset($_POST['btn_save']))
{
$product_name=$_POST['product_name'];
$details=$_POST['details'];
$price=$_POST['price'];
$product_type=$_POST['product_type'];
$brand=$_POST['brand'];
$tags=$_POST['tags'];

$files=$_FILES['picture'];
$filename=$files['name'];
$fileerror=$files['error'];
$filetemp=$files['tmp_name'];
$fileext=explode('.',$filename);
$filecheck=strtolower(end($fileext));
$fileextstored=array('png','jpg','jpeg','gif');
if(in_array($filecheck,$fileextstored))
{ 
  $folder="upload/".$filename;
  //move_uploaded_file($filetemp,$destinationfile);
 if(move_uploaded_file($filetemp, $folder))
 {
  
  mysqli_query($con,"INSERT INTO `products`(`product_cat`, `product_brand`, `product_title`, `product_price`, `product_desc`, `product_image`, `product_keywords`) VALUES ('$product_type','$brand','$product_name','$price','$details','$folder','$tags')") or die ("query incorrect");

 header("location: sumit_form.php?success=1");
}
}
//
/*$target_dir = "D:\xampp\htdocs\sales1\product_images";
$target_file = $target_dir . basename($_FILES['picture']['name']);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
//picture coding
$picture_name=$_FILES['picture']['name'];
$picture_type=$_FILES['picture']['type'];
$picture_tmp_name=$_FILES['picture']['tmp_name'];
$picture_size=$_FILES['picture']["size"] 

if($picture_type=="image/jpeg" || $picture_type=="image/jpg" || $picture_type=="image/png" || $picture_type=="image/gif")
{
	if($picture_size<=50000000)
	
		$pic_name=time()."_".$picture_name;
		move_uploaded_file($picture_tmp_name,"D:\xampp\htdocs\sales1\product_images".$pic_name);
		
mysqli_query($con,"INSERT INTO `products`(`product_cat`, `product_brand`, `product_title`, `product_price`, `product_desc`, `product_image`, `product_keywords`) VALUES ('$product_type','$brand','$product_name','$price','$details','$pic_name','$tags')") or die ("query incorrect");

 header("location: sumit_form.php?success=1");
}*/

mysqli_close($con);
}
include "sidenav.php";
include "topheader.php";
?>
      <!-- End Navbar -->
      <div class="content">
        <div class="container-fluid">
          <form action="" method="post" type="form" name="form" enctype="multipart/form-data">
          <div class="row">
          
                
         <div class="col-md-7">
            <div class="card">
              <div class="card-header card-header-primary">
                <h5 class="title">Add Product</h5>
              </div>
              <div class="card-body">
                
                  <div class="row">
                    
                    <div class="col-md-12">
                      <div class="form-group">
                        <label>Product Title</label>
                        <input type="text" id="product_name" required name="product_name" class="form-control">
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="">
                        <label for="">Add Image</label>
                        <input type="file" name="picture" required class="btn btn-fill btn-success" id="picture" >
                      </div>
                    </div>
                     <div class="col-md-12">
                      <div class="form-group">
                        <label>Description</label>
                        <textarea rows="4" cols="80" id="details" required name="details" class="form-control"></textarea>
                      </div>
                    </div>
                  
                    <div class="col-md-12">
                      <div class="form-group">
                        <label>Pricing</label>
                        <input type="text" id="price" name="price" required class="form-control" >
                      </div>
                    </div>
                  </div>
                 
                  
                
              </div>
              
            </div>
          </div>
          <div class="col-md-5">
            <div class="card">
              <div class="card-header card-header-primary">
                <h5 class="title">Categories</h5>
              </div>
              <div class="card-body">
                
                  <div class="row">
                    
                    <div class="col-md-12">
                      <div class="form-group">
                        <label>Product Category</label>
                         <select class="form-control" id="product_type" name="product_type">
							 <option style="background-color: #202940">All Categories</option> 
                        <?php 
                            $sql="select * from categories";
                            $result=mysqli_query($con,$sql);
                            while ($row = mysqli_fetch_array(
                              $result,MYSQLI_ASSOC)):; 
                                ?>
                        echo '<option value="<?php echo $row["cat_id"]; ?>" style="background-color: #202940" ><?php echo $row["cat_title"]; ?></option>';
                        <?php 
                endwhile; 
                // While loop must be terminated
            ?>
                                  </select>
                             
                        <!--input type="number" id="product_type" name="product_type" required="[1-6]" class="form-control"-->
                      </div>
                    </div>
                    <div class="col-md-12">
                      <div class="form-group">
                        <label for="">Product Grade</label>
						  <select class="form-control" id="product_type" name="brand">
							 <option style="background-color: #202940">All Grandes</option> 
                        <?php 
                            $sqls="select * from brands";
                            $results=mysqli_query($con,$sqls);
                            while ($rows = mysqli_fetch_array(
                              $results,MYSQLI_ASSOC)):; 
                                ?>
                        <option value="<?php echo $rows["brand_id"]; ?>" style="background-color: #202940" ><?php echo $rows["brand_title"]; ?></option>';
                        <?php 
                endwhile; 
                // While loop must be terminated
            ?>
                                  </select>
                      </div>
                    </div>
                     
                  
                    <div class="col-md-12">
                      <div class="form-group">
                        <label>Product Keywords</label>
                        <input type="text" id="tags" name="tags" required class="form-control" >
                      </div>
                    </div>
                  </div>
                
              </div>
              <div class="card-footer">
                  <button type="submit" id="btn_save" name="btn_save" required class="btn btn-fill btn-primary">Update Product</button>
              </div>
            </div>
          </div>
          
        </div>
         </form>
          
        </div>
      </div>
      <?php
include "footer.php";
?>