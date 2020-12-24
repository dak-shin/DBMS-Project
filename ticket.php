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

		if(isset($_POST['book']))
		{
			require_once 'test.php';
	        $connection = new mysqli($db_hostname, $db_username, $db_password, $db_database);
			$customer_name = $_SESSION['username'];

			$customer_query = "Select * from customer where user_name = '$customer_name' ";
        	$result = $connection->query($customer_query);
        	if(!$result) die($connection->error);
        	$customer_id = $result->fetch_assoc()['customer_id']; //customer_id

			$type = $_POST['level']; //type id
			

        	$size = $_POST['number']; //number of seats 
        	$conc_name = $_SESSION['concert_name'];

        	$type_query = "Select * from ticket_type where seating_area = '$type' ";
        	$result1 = $connection->query($type_query);
        	if(!$result1) die($connection->error);
        	$type_id = $result1->fetch_assoc()['type_id'];

        	$concert_query = "Select * from concert where concert_name = '$conc_name' ";
        	$result2 = $connection->query($concert_query);
        	if(!$result2) die($connection->error);
        	$concert_id = $result2->fetch_assoc()['concert_id'];

			$venue_name = $_SESSION['venue_name']; 
			$ticket_query = "Insert into ticket (type_id,venue_location, seat_no, concert_id, customer_id) values ('$type_id','$venue_name','$size','$concert_id','$customer_id')";
			$result3 = $connection->query($ticket_query);
			if(!$result3) die($connection->error);
			else 
			{

				echo <<<HTML
					<p class="booked" style="display: inline;">Ticket booked successfully</p>
					<a href="http://localhost/scripts/ticket.php" class="book-btn smol-button" style="margin-left: auto;">
						Show Tickets
					</a>
				HTML;


			}

		}

		else
		{

			require_once 'test.php';
	        $connection = new mysqli($db_hostname, $db_username, $db_password, $db_database);
			$customer_name = $_SESSION['username'];

			$customer_query = "Select * from customer where user_name = '$customer_name' ";
        	$result = $connection->query($customer_query);
        	if(!$result) die($connection->error);
        	$customer_id = $result->fetch_assoc()['customer_id'];

        	$show_query = "Select * from ticket where customer_id = $customer_id ";
        	$result1 = $connection->query($show_query);
        	if(!$result1) die($connection->error);
        	$rows = $result1->num_rows;


        	if($rows>0)
        	{
	        	for($i = 0; $i<$rows;$i++)
	        	{	
	        		
	        		$arr = $result1->fetch_assoc();
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
						<div class="cancelbtn smol-button">
							<a href="http://localhost/scripts/cancel.php?ticket_id=$t_id" >Cancel</a>
						</div>
					</div>
					
					HTML;
	        	}
	        }
	        else
	        {
	        	echo "<h2>Nothing to show</h2>";
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