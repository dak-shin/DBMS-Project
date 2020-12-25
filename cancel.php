<!DOCTYPE html>
<html>
<head>
	<title>myWebpage</title>
	<link rel="icon" type="image/png" href="./img/ds.png">
	<link rel="stylesheet" type="text/css" href="./css/newstyles.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto">
</head>
<body>
	<section id="navigation-bar" class="navigation-bar">
		<div class="logo">
			OnePage
		</div>
		<div class="home-btn">
			<a href="index.php" style="color: white;">Home</a>
		</div>
		<div class="home-btn2">
			<a href="ticket.php" style="color: white;text-decoration: none;">MyTickets</a>
		</div>
		<?php
			session_start();
			if(!isset($_SESSION['username']))
				header('Location: http://localhost/scripts/login.php');
            require_once 'test.php';
            $loginbtn = <<<HTML
                <a href="./login.php" >
                    <div class="login-btn button">
                        Sign up/Log in
                    </div>
                </a>
                HTML;
            $logoutbtn = <<<HTML
				
				<a href="./logout.php" >
					<div class="login-btn button">Logout</div>
				</a>
				HTML;
            if(!isset($_SESSION['username']))
                echo $loginbtn;
            else
                echo $logoutbtn;
        ?>
	</section>

	<section class="ticket-sec" >
	
	<?php
		$connection = new mysqli($db_hostname, $db_username, $db_password, $db_database);
		if(isset($_GET['ticket_id']))
		{
			require_once 'test.php';
			$t_id = $_GET['ticket_id'];

			$show_query = "Select * from ticket where ticket_id = $t_id ";
			$result = $connection->query($show_query);
			if(!$result) die($connection->error);
			else
			{

				$arr = $result->fetch_assoc();
				$t_id = $arr['ticket_id'];
				$t_type = $arr['type_id'];
				$t_venue = $arr['venue_location'];
				$t_no = $arr['seat_no'];
				$c_id = $arr['concert_id'];
				$cu_id = $arr['customer_id'];

				$concert_query = "Select * from concert where concert_id = $c_id";
				$result2 = $connection->query($concert_query);
				if(!$result2) die($connection->error);
				$arr = $result2->fetch_assoc();
				$c_name = $arr['concert_name'];
    			$c_time = $arr['timming'];
    			$c_date = $arr['concert_date'];

				echo <<<HTML
				<div class="ticket-card">
					<div class="ticket-info">
						<div><span>Ticket ID : </span> $t_id</div>
						<div><span>Ticket Class : </span>$t_type</div>
						<div><span>Venue Name : </span>$t_venue</div>
						<div><span>Number of People : </span>$t_no</div>
						<div><span>Concert Name : </span>$c_name</div>
						<div><span>Time : </span>$c_time</div>
						<div><span>Date : </span>$c_date</div>
						<div><span>User ID : </span>$cu_id</div>
					</div>
				</div>
				<div class="conf" style="margin-left: 5px;">
					<form action="http://localhost/scripts/cancel.php" method="post">
						<label class="confirmation">
							Are you sure you would like to cancel?
						</label>
						<input type="hidden" name="t_id" value=$t_id>
						<input type="hidden" name="cancel" value="yes">
						<button type="submit" class="smol-button"> Yes</button>
						<a href="http://localhost/scripts/ticket.php" class="no-button ">No</a>
					</form>
				</div>`
				HTML;

			}
		}
		elseif(isset($_POST['cancel']) && isset($_POST['t_id']))
		{
			$id = $_POST['t_id'];
			$cancel_query = "Delete from ticket where ticket_id = '$id'";
			$result = $connection->query($cancel_query);
			if(!$result) die($connection->error);
			else 
			{
				echo <<<HTML
						<p class="booked" style="display: inline;">Ticket has been cancelled, refund will be initiated shortly</p>
						<a href="http://localhost/scripts/ticket.php" class="book-btn smol-button" style="margin-left: auto;">
							Show Tickets
						</a>
					HTML;

			}
		}
	?>

	</section>

	<section class="footer">

	    <div class="social footer-div">
	      <h4>Social Links</h4>
	      <a href="#" class="Facebook"><i class="fa fa-facebook-official fa-lg" aria-hidden="true"></i></a>
	      <a href="#" class="Instagram"><i class="fa fa-instagram fa-lg" aria-hidden="true"></i></a>
	      <a href="#" class="Twitter"><i class="fa fa-twitter-square fa-lg" aria-hidden="true"></i></a>
	      <a href="#" class="Gmail"><i class="fa fa-envelope fa-lg" aria-hidden="true"></i></a>
	      <a href="#" class="youtube"><span class="fa fa-youtube-play fa-lg" aria-hidden="true"></span></a>
	    </div>

	    <div class="Location footer-div">
	      <h4 style="font-weight: bolder;">Our address</h4>
	      <p>1725,<br> Slough Avenue <br> Scranton, Pennsylvania</p>
	    </div>

	    <div class="review footer-div">
			<h4>Didn't like it?</h4>
            Help us understand why
	    </div>

  	</section>
	<script type="text/javascript" src="./js/scripts.js"></script>
</body>
</html>