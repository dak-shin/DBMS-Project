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
	
	<section class="booking-sec">
		<?php
			$conc_name = $_GET['concert_name'];		//Concert name		
			
			$customer_name = $_SESSION['username'];
			$customer_id = $_SESSION['userid'];
			// session_start();
        	require_once 'test.php';
        	$connection = new mysqli($db_hostname, $db_username, $db_password, $db_database);
        	
        	$query = "Select * from concert where concert_name = '$conc_name'";
        	$result = $connection->query($query);
        	if(!$result) die($connection->error);
        	

        	$arr = $result->fetch_assoc();
        	$id = $arr['concert_id'];				//concert_id
        	$venue_name = $arr['venue_name'];			//Venue name
        	$artist_id = $arr['artist_id'];
        	$concert_date = $arr['concert_date']; 		//Concert Date 
        	$merch_type = $arr['merch_type'];         //merch_type
        	$spon_id = $arr['spon_id'];	
        	$time = $arr['timming'];	

        	$artist_query = "Select * from artists where artist_id = '$artist_id' ";
        	$result2 = $connection->query($artist_query);
        	if(!$result2) die($connection->error);
        	$artist_name = $result2->fetch_assoc()['artist_name']; // artist_name

        	$spon_query = "Select * from sponsors where spon_id = '$spon_id' ";
        	$result3 = $connection->query($spon_query);
        	if(!$result3) die($connection->error);
        	$spon_name = $result3->fetch_assoc()['spon_name']; //sponsors name 

        	$image = "./img/poster".$id.".jpg";

			
			$_SESSION['concert_name'] =	$conc_name;
			//$_SESSION['artist_name'] =	$artist_name<br>
			$_SESSION['venue_name'] =	$venue_name;
			//$_SESSION['concert_date'] =	$concert_date<br>
			// $_SESSION[''] =	$merch_type<br>
			// $_SESSION[''] =	$spon_name
			

        	if(isset($_POST['book']))
        	{	
        		
        		echo $type;
        		echo $size;
        		$query = "Insert into ticket(type_id, venue_location, seat_no, concert_id, customer_id) values ('','')";
        	}


			echo <<<HTML
				<div class="description">
					<img src=$image class="c-poster">
				</div>
				<div class="booking">
					<div class="details">
						<ul class="details-list">
							<li class="deets">
								<p class="detail name"><span>Concert Name :</span> $conc_name</p>
							</li>
							<li class="deets">
								<p class="detail name"><span>Artist :</span> $artist_name</p>
							</li>
							<li class="deets">
								<p class="detail name"><span>Venue Name :</span> $venue_name</p>
							</li>
							<li class="deets">
								<p class="detail name"><span>Date :</span> $concert_date</p>
							</li>
							<li class="deets">
								<p class="detail name"><span>Time :</span> $time</p>
							</li>	
						</ul>
					</div>
					<form class="booking-form" action="ticket.php" method="post">
						<div class="container">
							<div class="level form">
								<label class="labels" for="level">Seating class : </label>
								<input type="radio" id="Diamond" name="level" value="Diamond " class="ip">
								<label for="Diamond" class="ip-label">Diamond</label>

								<input type="radio" id="Platinum" name="level" value="Platinum " class="ip">
								<label for="Platinum" class="ip-label">Platinum</label>

								<input type="radio" id="Gold" name="level" value="gold " class="ip">
								<label for="Gold" class="ip-label">Gold</label>

								<input type="radio" id="Silver" name="level" value="silver" class="ip">
								<label for="Silver" class="ip-label">Silver</label>

								<input type="radio" id="bronze" name="level" value="bronze" class="ip">
								<label for="bronze" class="ip-label">Bronze</label>
								<br><br><br>
								<label for="number">Number of seats : </label><br>
								<select class="input" name="number" >
								  <option value="1">ONE</option>
								  <option value="2">TWO</option>
								  <option value="3">THREE</option>
								  <option value="4">FOUR</option>
								  <option value="5">FIVE</option>
								  <option value="6">SIX</option>
								  <option value="7">SEVEN</option>
								</select>
							</div>
							
							<input type="hidden" name="book" value="yes">
							<button type="submit" class="pay-btn">
								Proceed to Pay
							</button>
						</div>
					</form>
					<div class="more-deets">
						
					</div>
				</div>
			HTML;

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