

<?php
require 'config/config.php';
include("includes/classes/User.php");
include("includes/classes/Post.php");
include("includes/classes/Message.php");
include("includes/classes/Notification.php");
?>



<?php



if(isset($_SESSION['username'])){
    $userLoggedIn= $_SESSION['username'];
    $user_details_query = mysqli_query($con, "SELECT * FROM users WHERE username='$userLoggedIn'");
	$user = mysqli_fetch_array($user_details_query);
    // echo "in";
}
else{
    header("Location: register.php");
}
?>

<html>
<head>
    <title>
    WaterFlow
    </title>
    <!-- <js> -->
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script> -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>
	<script src="assets/js/bootstrap.js"></script>
	<script src="assets/js/bootbox.min.js"></script>
	<script src="assets/js/demo.js"></script>
	<script src="assets/js/jquery.Jcrop.js"></script>
	<script src="assets/js/jcrop_bits.js"></script>

    <!-- <css> -->
    <!-- font-awesomw -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="assets/css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="assets/css/style.css">
	<link rel="stylesheet" href="assets/css/jquery.Jcrop.css" type="text/css" />
</head>
<body>

    <div class ="top_bar">
        <div class="logo">
            <a href="index.php">WaterFlow!</a>
        </div>


        <div class="search">

			<form action="search.php" method="GET" name="search_form">
				<input type="text" onkeyup="getLiveSearchUsers(this.value, '<?php echo $userLoggedIn; ?>')" name="q" placeholder="Search..." autocomplete="off" id="search_text_input">

				<div class="button_holder">
					<img src="assets/images/icons/magnifying_glass.png">
				</div>

			</form>

			<div class="search_results">
			</div>

			<div class="search_results_footer_empty">
			</div>



		</div>
    

        <nav>
            <?php
				//Unread messages 
				$messages = new Message($con, $userLoggedIn);
                $num_messages = $messages->getUnreadNumber();

                //Unread notifications 
				$notifications = new Notification($con, $userLoggedIn);
				$num_notifications = $notifications->getUnreadNumber();

				//Unread notifications 
				$user_obj = new User($con, $userLoggedIn);
				$num_requests = $user_obj->getNumberOfFriendRequests();
            ?>
            
        <a href="<?php echo $userLoggedIn; ?>">
				<?php echo $user['first_name']; ?>
            </a>
            <a href="index.php">
                <i class="fa fa-home fa-lg"></i>
            </a>
            <a href="javascript:void(0);" onclick="getDropdownData('<?php echo $userLoggedIn; ?>', 'message')">
                <i class="fa fa-envelope fa-lg"></i>
                <?php
				if($num_messages > 0)
				 echo '<span class="notification_badge" id="unread_message">' . $num_messages . '</span>';
				?>
            </a>
			<a href="javascript:void(0);" onclick="getDropdownData('<?php echo $userLoggedIn; ?>', 'notification')">
				<i class="fa fa-bell fa-lg"></i>
				<?php
				if($num_notifications > 0)
				 echo '<span class="notification_badge" id="unread_notification">' . $num_notifications . '</span>';
				?>
			</a>
            <a href="requests.php">
                <i class="fa fa-users fa-lg"></i>
                <?php
				if($num_requests > 0)
				 echo '<span class="notification_badge" id="unread_notification">' . $num_requests . '</span>';
				?>
            </a>
            <a href="settings.php">
                <i class="fa fa-cog fa-lg"></i>
            </a>
            <a href="includes/handlers/logout.php">
                <i class="fa fa-sign-out-alt fa-lg"></i>
            </a>
        </nav>
        <div class="dropdown_data_window" style="height:0px; border:none;"></div>
		<input type="hidden" id="dropdown_data_type" value="">


    </div>




    <div class ="wrapper">
        <!-- <div class ="user_details column"> -->
    <!-- </div> -->





