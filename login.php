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
        session_start();
        require_once 'test.php';
        $connection = new mysqli($db_hostname, $db_username, $db_password, $db_database);

        function san_ip($var)
        {
            $var = stripslashes($var);
            $var = htmlentities($var);
            $var = strip_tags($var);
            return $var; 
        }

        if(isset($_POST['create']))
        {   
            $result = '';
            $email = san_ip($_POST['s_email']);
            $user_name = san_ip($_POST['s_username']);
            $pwd = san_ip($_POST['s_psw']);
            $rpwd = san_ip($_POST['psw-repeat']);
            if($pwd != $rpwd) 
            {
                $pwd_same = false;
            }
            elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) 
            {    
                $valid_email = 'false';
            }
            else
            {   

                // echo "$user_name, $pwd";
                $query = "Insert into customer(email, user_name, password) values ('$email','$user_name','$pwd')";
                $result = $connection->query($query);
                if(!$result) 
                    $uniq_user = false;
                else 
                    $acco_create = true;
            }
        }
        elseif (isset($_POST['login'])) 
        {
            if(isset($_SESSION['username']))
                $already_logged = true;
            
            $result = '';
            $user_name = san_ip($_POST['l_username']);
            $pwd = san_ip($_POST['l_password']);
            $query = "Select * from customer where user_name = '$user_name' and password = '$pwd'";
            $result = $connection->query($query);
           
            if(!$result)
                echo "<h3> $connection->error </h3>";
            elseif(!($result->num_rows < 1))
            {
                // print_r($result);
                $arr = $result->fetch_assoc();
                if($user_name == $arr['user_name'] && $pwd == $arr['password'])
                {   
                    $_SESSION['userid'] = $arr['customer_id'];
                    $_SESSION['username'] = $user_name;
                    $loggin_succ = true;
                }
                else
                    $loggin_succ = 'false';

            }
            else
                $loggin_succ = 'false';

        }
                
    ?>
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
                    <div class="login-btn button">
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
    <section class="login-sec">
        <div class="sign-up user-info">
            <form action="login.php" method="post">
                <div class="container">
                    <h1>Sign Up</h1>
                    <p>Please fill in this form to create an account.</p>
                    <hr>

                    <label for="s_email"><b>Email</b></label>
                    <input class="input" type="text" placeholder="Your email" name="s_email" required autocomplete="off">

                    <label for="s_username"><b>Username</b></label>
                    <input class="input" type="text" placeholder="Username" name="s_username" required autocomplete="off">

                    <label for="s_psw"><b>Password</b></label>
                    <input class="input" type="password" placeholder="Password" name="s_psw" required autocomplete="off">

                    <label for="psw-repeat"><b>Repeat Password</b></label>
                    <input class="input" type="password" placeholder="Repeat Password" name="psw-repeat" required autocomplete="off">

                    <br>
                    <p>By creating an account you agree to our <a href="#" style="color:dodgerblue">Terms & Privacy</a>.
                    </p>
                    <input type="hidden" name="create" value="yes">
                    <div >
                        <button type="reset" class="signupbtn">Cancel</button>
                        <button type="submit" class="signupbtn">Sign Up</button>
                    </div>
                </div>
            </form>
            <?php

                require_once 'test.php';
                if($acco_create == true)
                {
                    echo "<h2> Account created successfully</h2>";
                    $acco_create = '';
                }
                if($valid_email == 'false')
                {
                    echo "<h2>Enter valid email</h2>";
                    $valid_email = '';
                }
                
                if ($pwd_same == false) 
                {
                    echo "<h2>Password do not match, Please re-enter</h2>";
                    $pwd_same = true;
                }

                if($uniq_user == false)
                {
                    echo "Username already taken";
                    $uniq_user = true;
                }
            ?>
        </div>
        <div class="login user-info">
            <form action="login.php" method="post">
                <div class="container">
                    <h1>Log In</h1>

                    <label for="l_username">Username<br></label>
                    <input class="input" type="text" name="l_username" id="username" autocomplete="off" >
                    <label for="l_password">Password<br></label>
                    <input class="input" type="password" name="l_password" id="password" autocomplete="off">
                    <input type="hidden" name="login" value="yes">
                    <button type="submit">
                        Log In
                    </button>
                    <br>
                    <a href="adminlogin.php">Admin Login</a>

                </div>
            </form>
            <?php

                require_once 'test.php';
                if($loggin_succ == true && isset($_SESSION['username']))
                {
                    $name = $_SESSION['username'];
                    //echo "<h2>Login successfully, Hello $name</h2>";
                    
                    header('Location: http://localhost/scripts/index.php');
                    $loggin_succ = '';
                }
                
                elseif ($loggin_succ == 'false') 
                {
                    echo "<h2>Invalid username or password</h2>";
                    $loggin_succ = '';
                }

                if($already_logged == true)
                    echo "<h3>Already logged in</h3>";
            ?>
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