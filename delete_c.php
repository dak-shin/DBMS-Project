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

            $concert_id = $_POST['concert_id'];
            
            $delete_query = "delete from concert where concert_id = '$concert_id'";

            $result = $connection->query($delete_query);
            if(!$result) die($connection->error);
            else echo "Concert deleted successfully";
        
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