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
        //require_once 'test.php';
        session_start();
        if(!isset($_SESSION['username']) && isset($_SESSION['admin_name']))
        {}
        else
            header('Location: http://localhost/scripts/logout.php');
                
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

    <section class="main-sec">

        <a href="http://localhost/scripts/dashboard.php" class="book-btn smol-button" >
            Dashboard
        </a>

        <?php
            
            require_once 'test.php';
            $connection = new mysqli($db_hostname, $db_username, $db_password, $db_database);
            $show_query = "Select * from ticket ";
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
                    $t_amt = $arr['amt'];

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
                            <div><span>Total Amount : </span>Rs.$t_amt</div>
                        </div>
                        <div class="cancelbtn smol-button">
                            <a href="http://localhost/scripts/admin_cancel.php?ticket_id=$t_id" >Cancel</a>
                        </div>
                    </div>
                    
                    HTML;
                }
            }
            else
            {
                echo "<h2>Nothing to show</h2>";
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
            Help us understand why.
        </div>

    </section>
    <script type="text/javascript" src="./js/scripts.js"></script>
</body>

</html>