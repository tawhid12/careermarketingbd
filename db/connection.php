<?php
class Connection{
	protected $connection;

	public function __construct(){
		$host = 'localhost';
		$user = 'root';
		$pass = '';
		$db	  =	'careermarketingbd';
		$this->connection = mysqli_connect($host,$user,$pass,$db);
		if(!$this->connection){
			die('Connection Error'.mysqli_connect_error($this->connection));
		}
	}
}

