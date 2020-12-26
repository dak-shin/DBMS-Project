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
        if(!isset($_SESSION['username']) && isset($_SESSION['admin_name']))
        {
            require_once 'test.php';
            $connection = new mysqli($db_hostname, $db_username, $db_password, $db_database);

            function san_ip($var)
            {
                $var = stripslashes($var);
                $var = htmlentities($var);
                $var = strip_tags($var);
                return $var; 
            }
            // if(isset($_POST['create']))
            // {   
            //     $result = '';
            //     $email = san_ip($_POST['s_email']);
            //     $user_name = san_ip($_POST['s_username']);
            //     $pwd = san_ip($_POST['s_psw']);
            //     $rpwd = san_ip($_POST['psw-repeat']);
            //     if($pwd != $rpwd) 
            //     {
            //         $pwd_same = false;
            //     }
            //     else
            //     {   

            //         // echo "$user_name, $pwd";
            //         $query = "Insert into customer(email, user_name, password) values ('$email','$user_name','$pwd')";
            //         $result = $connection->query($query);
            //         if(!$result) 
            //             echo "<h3> $connection->error </h3>";
            //         else 
            //             $acco_create = true;
            //     }
            // }

            if (isset($_POST['admin_login'])) 
            {
                //echo "login active";
                if(isset($_SESSION['admin_name']))
                    $already_logged = true;
                
                $result = '';
                $admin_name = san_ip($_POST['a_username']);
                $pwd = san_ip($_POST['a_password']);
                $query = "Select * from admin where admin_name = '$admin_name' and password = '$pwd'";
                $result = $connection->query($query);
               
                if(!$result)
                    echo "<h3> $connection->error </h3>";
                elseif(!($result->num_rows < 1))
                {
                    // print_r($result);
                    $arr = $result->fetch_assoc();
                    if($admin_name == $arr['admin_name'] && $pwd == $arr['password'])
                    {   
                        $_SESSION['admin_id'] = $arr['admin_id'];
                        $_SESSION['admin_name'] = $admin_name;
                        $a_loggin_succ = true;
                    }
                    else
                        $a_loggin_succ = 'false';

                }
                else
                    $a_loggin_succ = 'false';

            }
        }
        else
        {
            echo "Please log in as the admin";
            //header('Location: http://localhost/scripts/logout.php');
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

    <section class="dash-sec" >
     
        <div class="in-dash-sec">
            <div class="concert-part">
                <span>Concert Queries</span><br><br><br>
                <a href="http://localhost/scripts/admin_concert.php?c_flag=1" class="book-btn smol-button" >
                    Show Concerts
                </a>
                <br>
                <a href="http://localhost/scripts/admin_concert.php?c_flag=2" class="book-btn smol-button" >
                    Insert Concert
                </a>
                <br>
                <a href="http://localhost/scripts/admin_concert.php?c_flag=3" class="book-btn smol-button" >
                    Delete Concert
                </a>
            </div>

            <div class="ticket-part">
                <span>Ticket Queries</span><br><br><br>
                <a href="http://localhost/scripts/admin_ticket.php?t_flag=1" class="book-btn smol-button" >
                    Show All Tickets
                </a><br>
                <a href="http://localhost/scripts/admin_ticket.php?t_flag=2" class="book-btn smol-button" >
                    See Revenue
                </a>
            </div>

            <div class="admin-part">
                <span>Admin Queries</span><br><br><br>
                <a href="http://localhost/scripts/admin_q.php?a_flag=1" class="book-btn smol-button" >
                    Add Admin
                </a><br>
                <a href="http://localhost/scripts/admin_q.php?a_flag=2" class="book-btn smol-button" >
                    Remove admin
                </a>
            </div>
        </div>

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