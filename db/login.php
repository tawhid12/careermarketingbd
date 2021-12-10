<?php
session_start();
require_once('connection.php');
class Login extends Connection{
    function ulogin($data,$page=null){
        $email = $_POST['email'];
        $password = md5($_POST['password']);
        $sql = "select id,email,pass from users where email = '$email' and pass = '$password'";
        if(mysqli_query($this->connection, $sql)){
            $result = mysqli_query($this->connection, $sql);
            if(mysqli_num_rows($result) == 1){
                $data = $result->fetch_assoc();
                $_SESSION['email'] = $data['email'];
                $_SESSION['status'] ="Logged In Successfully";
                $_SESSION['status_code'] ="success";
                if($page == 'front')
                HEADER('LOCATION:../index.php');
                else
                HEADER('LOCATION:index.php');
                exit();
            }else{
                HEADER('LOCATION:login.php');
                $_SESSION['status'] ="Your Email or Password Does Not Match";
                $_SESSION['status_code'] ="error";
            }   
        }
        else{
            die("Error".mysqli_connect_error($this->connection));
        }
    }
}
?>