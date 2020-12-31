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
    <?php  
         require_once 'test.php';
        session_start();
        if(isset($_SESSION['username']) )
        {

        }
        else
        {
        	header('Location: http://localhost/scripts/ticket.php');
        }


    ?>
    <section id="navigation-bar" class="navigation-bar">
        <div class="logo">
            OnePage
        </div>
        <?php
            require_once 'test.php';
            $loginbtn = <<<HTML
                <a href="./login.php" >
                    <div class="login-btn button">
                        Sign up/Log in
                    </div>
                </a>
                HTML;
            $logoutbtn = <<<HTML
                <a href="./a_logout.php" >
                    <div class="login-btn button">
                        Logout
                    </div>
                </a>
                HTML;
            if(!isset($_SESSION['admin_name']))
                echo $loginbtn;
            else
                echo $logoutbtn;
        ?>
    </section>

    <section class="dash-sec pay-sec" style="background-image: none;">
     <?php

     	$t_class = $_POST['level'];
		$venue_name = $_POST['venue-name'];
		$number = $_POST['number'];
		$concert_name = $_POST['concert-name'];
		$time = $_POST['time'];
		$date = $_POST['concert-date'];
		$payment = $_POST['payment'];
		$total = 0;

		require_once 'test.php';
	    $connection = new mysqli($db_hostname, $db_username, $db_password, $db_database);

		$type_query = "Select * from ticket_type where seating_area = '$t_class' ";
		$result1 = $connection->query($type_query);
    	if(!$result1) die($connection->error);
    	$price = $result1->fetch_assoc()['ticket_price'];
    	$total = (1.08*($number*$price)+30);

		echo <<<HTML
					<div class="ticket-card">
						<div class="ticket-info">
							<div><span>Ticket Class : </span>$t_class</div>
							<div><span>Venue Name : </span>$venue_name</div>
							<div><span>Number of People : </span>$number</div>
							<div><span>Concert Name : </span>$concert_name</div>
							<div><span>Time : </span>$time</div>
							<div><span>Date : </span>$date</div>
							<div><span>Total Amount : </span>Rs.$total</div>
						</div>
						<div class="cancelbtn smol-button">
							<a href="http://localhost/scripts/booking.php?concert_name=$concert_name" >Cancel</a>
						</div>
					</div>

					<form action="ticket.php" method="POST">
						
						<input type="hidden" name="level" value="$t_class">
						<input type="hidden" name="number" value="$number">
						<input type="hidden" name="book" value="yes">
						<label style="margin-left: 10px;">
							Do you wish to book the above ticket, followed by payment through <span>$payment</span> : 
						</label>
						<button type="submit" class="button">
							Yes
						</button>
					</form>

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






