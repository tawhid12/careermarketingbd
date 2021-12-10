<?php
require_once('connection.php');
date_default_timezone_set("Asia/Dhaka");
class Library extends Connection
{
	public function insertData($table, $condition_arr,$page='')
	{
		if ($condition_arr != '') {
			foreach ($condition_arr as $key => $val) {
				$fieldArr[] = $key;
				$valueArr[] = $val;
			}
			$field = implode(",", $fieldArr);
			$value = implode("','", $valueArr);
			$value = "'" . $value . "'";
			$sql = "insert into $table($field) values($value) ";
			$result = mysqli_query($this->connection, $sql);
			if ($result) {
				header("location:{$page}");
			}
		}
	}
	public function getData($table, $field = '*', $condition_arr = '', $order_by_field = '', $order_by_type = 'desc', $limit = '')
	{
		$sql = "select $field from $table ";
		if ($condition_arr != '') {
			$sql .= ' where ';
			$c = count($condition_arr);
			$i = 1;
			foreach ($condition_arr as $key => $val) {
				if ($i == $c) {
					$sql .= "$key='$val'";
				} else {
					$sql .= "$key='$val' and ";
				}
				$i++;
			}
		}
		if ($order_by_field != '') {
			$sql .= " order by $order_by_field $order_by_type ";
		}

		if ($limit != '') {
			$sql .= " limit $limit ";
		}
		//die($sql);
		$result = mysqli_query($this->connection, $sql);
		if ($result->num_rows > 0) {
			$arr = array();
			while ($row = $result->fetch_assoc()) {
				$arr[] = $row;
			}
			/*echo '<pre>';
					print_r($arr);
				echo '</pre>';
				die();*/
			return $arr;
		} else {
			return 0;
		}
	}
	public function updateData($table,$condition_arr,$where_field,$where_value,$page){
		if($condition_arr!=''){
			$sql="update $table set ";
			$c=count($condition_arr);	
			$i=1;
			foreach($condition_arr as $key=>$val){
				if($i==$c){
					$sql.="$key='$val'";
				}else{
					$sql.="$key='$val', ";
				}
				$i++;
			}
			$sql.=" where $where_field='$where_value' ";
			$result=mysqli_query($this->connection, $sql);
			if ($result) {
				header("location:{$page}");
			}
		}
	}
	public function deleteBlog($id, $imageUrl)
	{
		$sql = "delete from blog_info where id ='$id'";
		if ($imageUrl) {
			unlink($imageUrl);
		}
		//echo $sql;
		if (mysqli_query($this->connection, $sql)) {;
			$message = "Data Deleted Successfully";
			HEADER("Location:index.php");
		} else {
			die("Error" . mysqli_connect_error($this->connection));
		}
	}
	/*Books Join Query */
	public function allProducts(){
		$sql = "SELECT 
		products.*,categories.cat_name
		from products
		JOIN categories on products.cat_id = categories.id 
		ORDER by id desc";
		$result = mysqli_query($this->connection, $sql);
		if ($result->num_rows > 0) {
			$arr = array();
			while ($row = $result->fetch_assoc()) {
				$arr[] = $row;
			}
			return $arr;
		} else {
			return 0;
		}
	}
}
