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

        <?php
            require_once 'test.php';
            $connection = new mysqli($db_hostname, $db_username, $db_password, $db_database);

            $concert_name = $_POST['concert_name'];
            $venue_name = $_POST['venue_name'];
            $artist_id = $_POST['artist_id'];
            $concert_date = $_POST['concert_date'];
            $merch_type = $_POST['merch_type'];
            $spon_id = $_POST['spon_id'];
            $timming = $_POST['timming'];

            $insert_query = "Insert into concert(concert_name, venue_name, artist_id, concert_date, merch_type, spon_id, timming) values ('$concert_name','$venue_name',$artist_id,'$concert_date','$merch_type',$spon_id, '$timming')";

            $result = $connection->query($insert_query);
            if(!$result) echo "Please Enter the correct details of the concert ";
            else echo "Concert added successfully";
        
        ?>


        <a href="http://localhost/scripts/dashboard.php" class="book-btn smol-button" >
            Dashboard
        </a>

        

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