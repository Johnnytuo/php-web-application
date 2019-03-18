<?php
//Declaring variables to prevent errors
$fname ="";
$lname ="";
$em="";
$em2="";
$password="";
$password2="";
$date="";
$error_array=array();


if(isset($_POST['register_button'])){
    //Registration form values

    //firstname
    $fname = strip_tags($_POST['reg_fname']);
    $fname = str_replace(' ','', $fname);
    $fname=ucfirst(strtolower($fname)); //uppercase first letter
    $_SESSION['reg_fname'] = $fname; //stores variable into session

    $lname = strip_tags($_POST['reg_lname']);
    $lname = str_replace(' ','', $lname);
    $lname=ucfirst(strtolower($lname)); //uppercase first letter
    $_SESSION['reg_lname'] = $lname;


    $em = strip_tags($_POST['reg_email']);
    $em = str_replace(' ','', $em);
    $em = ucfirst(strtolower($em)); //uppercase first letter
    $_SESSION['reg_email'] = $em;


    $em2 = strip_tags($_POST['reg_email2']);
    $em2= str_replace(' ','', $em2);
    $em2 = ucfirst(strtolower($em2)); //uppercase first letter
    $_SESSION['reg_email2'] = $em2;

    $password = strip_tags($_POST['reg_password']);
    // print_r($password);
    $password2 = strip_tags($_POST['reg_password2']);
    // print_r($password2);
    $date = date("Y-m-d");//get current date

    if($em == $em2) {
        //check if email is the same
        if(filter_var($em,FILTER_VALIDATE_EMAIL)){
            $em = filter_var($em,FILTER_VALIDATE_EMAIL);
            $e_check = mysqli_query($con, "SELECT email FROM users WHERE email = '$em'");
            $num_rows = mysqli_num_rows($e_check);
            if($num_rows > 0 ){
                array_push($error_array,"Email already in use<br>");

            }

        }
        else{
            array_push($error_array, "Invalid format<br>");
        }
    }
    else{
        array_push($error_array, "Emails don't match<br>");
    }
    if(strlen($fname) >25 || strlen($fname) <2){
        array_push($error_array, "Your first name must be in 2-25 characters<br>");
    }
    if(strlen($lname) >25 || strlen($lname) <2){
        array_push($error_array,"Your last name must be in 2-25 characters<br>");
    }

    if($password != $password2){
        // echo "Your passwords do not match<br>";
        array_push($error_array, "Your passwords do not match<br>");
    }else{
        if(preg_match('/[^A-Za-z0-9]/',$password)){
            array_push($error_array,"Your password should only contain english characters or numbers<br>");
        }
    }

    if(strlen($password > 30 || strlen($password)<5)){
        array_push($error_array, "Your password must be between 5 and 30 characters<br>");
    }

    // echo "out";
    // print_r($error_array);
    if(empty($error_array)){
        // echo "in";
        $password = md5($password);  //encrypt
        //generate a username
        $username = strtolower($fname . "_" . $lname);
        $check_username_query = mysqli_query($con, "SELECT username FROM users WHERE username='$username'");
        $i = 0;
        while(mysqli_num_rows($check_username_query) != 0){
            $i++;
            echo $i;
            $username = $username . "_" . $i;
            $check_username_query = mysqli_query($con,"SELECT username FROM users WHERE username='$username'");
        }

        $profile_pic = "assets/images/profile_pics/defaults/head_default.jpg";

        $query = mysqli_query($con, "INSERT INTO users VALUES('','$fname','$lname','$username','$em','$password','$date','$profile_pic','0','0','no',',')");
        array_push($error_array,"<span style='color: #14C800;'> You're all set! Go ahead and login!</span><br>");


        //clear session variable
        $_SESSION['reg_fname']="";
        $_SESSION['reg_lname']="";
        $_SESSION['reg_email']="";
        $_SESSION['reg_email2']="";

    }

}
?>
