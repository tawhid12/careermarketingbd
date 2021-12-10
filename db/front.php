<?php
require_once('library.php');
date_default_timezone_set("Asia/Dhaka");
class Front extends Library
{

	public function dashboard(){
		$sql = "
		SELECT *,genre.genre_name,authors.author_name,languages.lang_name FROM books 
		join genre on books.genre_id = genre.id
		join authors on books.author_id = authors.id
		join languages on books.lang_id = languages.id
		WHERE books.status =1 ";
		if(isset($_POST["minimum_price"], $_POST["maximum_price"]) && !empty($_POST["minimum_price"]) && !empty($_POST["maximum_price"]))
		{
			$sql .= "
			 AND books_price BETWEEN '".$_POST["minimum_price"]."' AND '".$_POST["maximum_price"]."'
			";
		}
		if(isset($_POST["genre"]))
		{
			$genre_filter = implode("','", $_POST["genre"]);
			$sql .= "
			 AND genre_id IN('".$genre_filter."')
			";
		}
		if(isset($_POST["author"]))
		{
			$ram_filter = implode("','", $_POST["author"]);
			$sql .= "
			 AND author_id IN('".$ram_filter."')
			";
		}
		if(isset($_POST["language"]))
		{
			$storage_filter = implode("','", $_POST["language"]);
			$sql .= "
			 AND lang_id IN('".$storage_filter."')
			";
		}
		//echo $sql;die();
		$output = '';
		$books = mysqli_query($this->connection, $sql);
                if ($books->num_rows > 0) {

		  foreach($books as $row)
		  {
		   $output .= '
		   
		   <div class="col-sm-4 col-lg-4 col-md-4 my-3">
			
			 <img src="admin/'. $row['books_image'] .'" alt="" class="img-responsive" >
			 <p align="center"><strong><a href="#">'. $row['books_name'] .'</a></strong></p>
			 <h4 style="text-align:center;" class="text-danger" >'. $row['books_price'] .'</h4>
			 <p>Author : '. $row['author_name'].' <br />
			 Genre : '. $row['genre_name'] .' <br />
			 Language : '. $row['lang_name'] .'  </p>
			';?>
			<?php
			if($row['books_type'] == 1){
			$output .= '<button type="submit" class="col-md-12 btn btn-block btn-danger">Paid Book</button>';
			}
			else{
			$output .= '<button type="button" class="col-md-12 btn btn-block btn-success">Fee Book</button>';	
			}
			$output .= '
		   </div>
		   ';
		  }
		 }else
 {
  $output = '<h3>No Data Found</h3>';
 }
 echo $output;
 
    }
	
}
