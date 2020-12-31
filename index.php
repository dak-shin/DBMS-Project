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
		<div class="logo blue-font" >
			OnePage
		</div>
		<div class="home-btn">
			<a href="index.php" class="blue-font" style="color: white;">Home</a>
		</div>
		<div class="home-btn2">
			<a href="ticket.php" style="color: white;text-decoration: none;">MyTickets</a>
		</div>
		<?php
			session_start();
            require_once 'test.php';
            $loginbtn = <<<HTML
                <a href="./login.php" >
                    <div class="login-btn button blue-font">
                        Sign up/Log in
                    </div>
                </a>
                HTML;
            $logoutbtn = <<<HTML
                <a href="./logout.php" >
                    <div class="login-btn button blue-font">
                        Logout
                    </div>
                </a>
                HTML;
            if(!isset($_SESSION['username']))
                echo $loginbtn;
            else
                echo $logoutbtn;
        ?>
	</section>

	<section class="about-us">
		<h1 class="heading">
			Bring Music to Life
		</h1>
	</section>
	<?PHP
		if(isset($_SESSION['username']))
			{ 
				$user = $_SESSION['username'];
			echo <<<HTML
					<p class="card-heading">Musical Events near you, $user</p> 

					<form action="index.php" method="POST" style="margin-left: 20px;display: inline;">
						<span>Sort By : </span>
						<input type="hidden" name="sort_by_date" value="yes">
						<button class="button" type="submit" style="margin-left: 10px">Date</button>
					</form>
					<form action="index.php" method="POST" style="margin-left: 10px;display: inline;">
						<input type="hidden" name="sort_by_time" value="yes">
						<button class="button" type="submit" style="margin-left: 10px">Time</button>
					</form>
					<form action="index.php" method="POST" style="margin-left: 10px;display: inline;">
						<input type="hidden" name="sort_by_name" value="yes">
						<button class="button" type="submit" style="margin-left: 10px">Name</button>
					</form>
					<form action="index.php" method="POST" style="margin-left: 10px;display: inline;">
						<button class="button" type="submit" style="margin-left: 10px">None</button>
					</form>
				HTML;
			}
			else
			{
				echo <<<HTML
					<p class="card-heading">Upcoming music events</p> 

					<form action="index.php" method="POST" style="margin-left: 20px;display: inline;">
						<span>Sort By : </span>
						<input type="hidden" name="sort_by_date" value="yes">
						<button class="button" type="submit" style="margin-left: 10px">Date</button>
					</form>
					<form action="index.php" method="POST" style="margin-left: 10px;display: inline;">
						<input type="hidden" name="sort_by_time" value="yes">
						<button class="button" type="submit" style="margin-left: 10px">Time</button>
					</form>
					<form action="index.php" method="POST" style="margin-left: 10px;display: inline;">
						<input type="hidden" name="sort_by_name" value="yes">
						<button class="button" type="submit" style="margin-left: 10px">Name</button>
					</form>
					<form action="index.php" method="POST" style="margin-left: 10px;display: inline;">
						
						<button class="button" type="submit" style="margin-left: 10px">None</button>
					</form>
				HTML;
			}
	?>
	<section class="concert-cards">
		<?php

			// session_start();
	        require_once 'test.php';
	        $connection = new mysqli($db_hostname, $db_username, $db_password, $db_database);

	        function san_ip($var)
	        {
	            $var = stripslashes($var);
	            $var = htmlentities($var);
	            $var = strip_tags($var);
	            return $var; 
	        }
	        $row = '';
	        
	        $query = 'Select * from concert';

	        if(isset($_POST['sort_by_date']))
	        {
	        	$query = 'Select * from concert order by concert_date';
	        }

	        if(isset($_POST['sort_by_time']))
	        {
	        	$query = 'Select * from concert order by timming';
	        }

	        if(isset($_POST['sort_by_name']))
	        {
	        	$query = 'Select * from concert order by concert_name';
	        }

	        $result = $connection->query($query);
	        if(!$result) die($connection->error);
	        $rows = $result->num_rows;
	        $c_names = array();
			//       for($i = 0; $i<$rows;$i++)
			//       {
			//       	$row = $result->fetch_assoc();
			//       	$c_id[] = $row['concert_id'];
			//       	$c_names[] = $row['concert_name'];
			//       	$c_time[] = $row['timming'];
			//       	$c_date[] = $row['concert_date'];
			//       }
			// foreach($c_names as $name)
			// {
			// 	echo <<<HTML
			// 		<div class="card">
			// 			<img src="./img/dm.png" class="c-image">
			// 			<div class="c-name">
			// 				<h3>$name</h3>
			// 			</div>
			// 			<a href="http://localhost/scripts/booking.php?concert_name=$name" class="book-btn smol-button">
			// 				Book now
			// 			</a>
			// 		</div> 
			// 	HTML;
			// }

			for($i = 0; $i<$rows;$i++)
	        {
	        	$row = $result->fetch_assoc();
	        	$c_id = $row['concert_id'];
	        	$name = $row['concert_name'];
	        	$time = $row['timming'];
	        	$date = $row['concert_date'];
				$url = "./img/c_poster".$c_id.".jpg";
	        	$date1 = (string)$date;
				$date2 = date("Y-m-d");

				if ($date1 >= $date2) 
				{
				    echo <<<HTML
					<div class="card">
						<img src=$url class="c-image">
						<div class="c-name">
							<h3>$name</h3>
						</div>
						<div class="c-name">
							$date
						</div>
						<br>
						<div class="c-name">
							$time
						</div>
						<a href="http://localhost/scripts/booking.php?concert_name=$name" class="book-btn smol-button">
							Book now
						</a>
					</div> 
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
	      <p>1725,<br> Banashankri 3rd-stage <br> Bangalore, Karnataka</p>
	    </div>

	    <div class="review footer-div">
			<h4>Didn't like it?</h4>
            Help us understand why
	    </div>

  	</section>
	<script type="text/javascript" src="./js/scripts.js"></script>
</body>
</html>