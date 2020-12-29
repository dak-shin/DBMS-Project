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
        $connection = new mysqli($db_hostname, $db_username, $db_password, $db_database);
        if(!isset($_SESSION['username']) && isset($_SESSION['admin_name']))
        {
            require_once 'test.php';
            

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
           
            header('Location: http://localhost/scripts/logout.php');
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

    <section class="main-sec">

        <a href="http://localhost/scripts/dashboard.php" class="book-btn smol-button" >
            Dashboard
        </a>


        <?php

            require_once 'test.php';
            $connection = new mysqli($db_hostname, $db_username, $db_password, $db_database);

            $flag = $_GET['c_flag'];
            switch ($flag) {
                case 1 :
                    //echo "show all concerts";

                    require_once 'test.php';
                    $connection = new mysqli($db_hostname, $db_username, $db_password, $db_database);

                    $show_c_query ="select * from concert";
                    $result1 = $connection->query($show_c_query);
                    $rows = $result1->num_rows;

                    echo <<<HTML
                            <br>
                            <br>
                            <table id="concert">
                                <tr>
                                    <th>Concert id</th>
                                    <th>Concert name</th>
                                    <th>Venue name</th>
                                    <th>Artist Name</th>
                                    <th>Concert date</th>
                                    <th>Merch type</th>
                                    <th>Sponsor ID</th>
                                    <th>Timming</th>
                                </tr>
                        HTML;

                    for ($i=0; $i <$rows ; $i++) 
                    { 
                        
                        $arr = $result1->fetch_assoc();
                        $id = $arr['concert_id']; 
                        $c_name = $arr['concert_name'];              //concert_id
                        $venue_name = $arr['venue_name'];           //Venue name
                        $concert_date = $arr['concert_date'];       //Concert Date 
                        $merch_type = $arr['merch_type'];         //merch_type
                        $spon_id = $arr['spon_id']; 
                        $time = $arr['timming'];

                        $artist_id = $arr['artist_id'];
                        $art_query = "select * from artists where artist_id = '$artist_id'";
                        $artist_name = $connection->query($art_query)->fetch_assoc()['artist_name'];


                        echo <<<HTML
                            <tr>
                                <td>$id</td>
                                <td>$c_name</td>
                                <td>$venue_name</td>
                                <td>$artist_name</td>
                                <td>$concert_date</td>
                                <td>$merch_type</td>
                                <td>$spon_id</td>
                                <td>$time</td>
                            </tr>
                        HTML;

                    }

                    echo "</table>";


                    break;

                case 2 :
                    //echo "Insert concert";

                    echo <<<HTML

                        <br>
                        <br>
                        Enter concert details : 
                        <br>
                        <br>
                        <form action="add_c.php" method="post" style="margin-left: 30px;">
                            
                            <label for="concert_name">Concert Name</label>
                            <input type="text" class="input" name="concert_name" autocomplete="off" required>
    
                            <label for="venue_name">Venue Name</label>
                            <select class="input" name="venue_name" required>
                    HTML;

                        $venue_query = "Select * from venue";
                        $result = $connection->query($venue_query);
                        if(!$result) die($connection->error);
                        $rows = $result->num_rows;

                        for($i = 0 ; $i < $rows ; $i++)
                        {
                            $arr = $result->fetch_assoc();
                            $v_name = $arr['venue_name'];
                            $v_location = $arr['venue_location'];
                            echo <<<HTML
                                <option value="$v_name">$v_name - $v_location</option>
                                HTML;
                        }

                    echo <<<HTML
                            </select>
                            

                            <label for="artist_id">Artist ID</label>
                            <select class="input" name="artist_id" required>

                    HTML;

                        $artist_query = "Select * from artists";
                        $result = $connection->query($artist_query);
                        if(!$result) die($connection->error);
                        $rows = $result->num_rows;

                        for($i = 0 ; $i < $rows ; $i++)
                        {
                            $arr = $result->fetch_assoc();
                            $art_id = $arr['artist_id'];
                            $art_name = $arr['artist_name'];
                            echo <<<HTML
                                <option value="$art_id">$art_id - $art_name</option>
                                HTML;
                        }


                    echo <<<HTML
                            </select>

                            <label for="concert_date">Concert Date (YYYY-MM-DD)</label>
                            <input type="text" class="input" name="concert_date" autocomplete="off" required>

                            <label for="merch_type">Merch Type</label>
                            <select class="input" name="merch_type" required>
                    HTML;

                        $merch_query = "Select * from merch";
                        $result = $connection->query($merch_query);
                        if(!$result) die($connection->error);
                        $rows = $result->num_rows;

                        for($i = 0 ; $i < $rows ; $i++)
                        {
                            $arr = $result->fetch_assoc();
                            $merch_name = $arr['merch_type'];
                            echo <<<HTML
                                <option value="$merch_name">$merch_name</option>
                                HTML;
                        }

                    echo <<<HTML
                                
                            </select>
                            <label for="spon_id">Sponsor ID</label>
                            <select class="input" name="spon_id" required>

                    HTML;

                        $spon_query = "Select * from sponsors";
                        $result = $connection->query($spon_query);
                        if(!$result) die($connection->error);
                        $rows = $result->num_rows;

                        for($i = 0 ; $i < $rows ; $i++)
                        {
                            $arr = $result->fetch_assoc();
                            $spon_name = $arr['spon_name'];
                            $spon_id = $arr['spon_id'];
                            echo <<<HTML
                                <option value="$spon_id">$spon_id - $spon_name</option>
                                HTML;
                        }

                    echo <<<HTML
                                
                            </select>

                            <label for="timming">Time (HH:MM AM/PM)</label>
                            <input type="text" class="input" name="timming" autocomplete="off" required>

                            <button type="submit">Insert</button>

                        </form>

                    HTML;

                    break;

                case 3 :
                    //echo "delete concert";

                    echo <<<HTML

                        <br>
                        <br>
                        Enter concert ID : 
                        <br>
                        <br>
                        <form action="delete_c.php" method="post" style="margin-left: 30px;">
                            
                            <label for="concert_id">Concert ID</label>
                            <input type="text" class="input" name="concert_id" autocomplete="off" required>

                            <button type="submit">Delete</button>

                        </form>

                    HTML;

                    if(isset($_GET['valid_concert_id']))
                    {
                        echo "<h3>Please enter valid concert id</h3>";
                    }

                    break;
                
                default:
                    # code...
                    break;
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