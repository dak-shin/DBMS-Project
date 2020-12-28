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
        $connection = new mysqli($db_hostname, $db_username, $db_password, $db_database);
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
            if(isset($_GET['a_flag'])) 
            {
                $flag = $_GET['a_flag'];
                switch ($flag) {
                    case 1:
                        
                         echo <<<HTML
                            <a href="http://localhost/scripts/dashboard.php" class="book-btn smol-button" >
                                Dashboard
                            </a>
                            <br><br><br>
                            <span>Enter admin details : </span><br><br>
                            <div style="margin-left: 30px;">
                                <form action="admin_q.php" method="post" >

                                     <label for="admin_name">Admin Name</label>
                                     <input type="text" name="admin_name" required autocomplete="off" class="input">

                                     <label for="email">Admin Email</label>
                                     <input type="text" name="email" required autocomplete="off" class="input">

                                     <label for="password">Password</label>
                                     <input type="password" name="password" required autocomplete="off" class="input">

                                     <input type="hidden" name="add" value="yes">

                                     <button type="submit">Add</button>

                                </form>
                            </div>

                        HTML;


                        if (isset($_GET['valid_email'])) 
                        {
                            echo "<h3> Please enter valid email</h3>";
                        }

                        if(isset($_GET['valid_id']))
                        {
                            echo "<h3> Admin name already taken</h3>";
                        }
                        break;

                    case 2:
                        
                         echo <<<HTML
                            <a href="http://localhost/scripts/dashboard.php" class="book-btn smol-button" >
                                Dashboard
                            </a>
                            <br><br><br>
                            <span>Enter admin ID : </span><br><br>
                            <div style="margin-left: 30px;">
                                <form action="admin_q.php" method="post" >

                                     <label for="admin_id">Admin ID</label>
                                     
                                     <select class="input" name="admin_id" required>
                        HTML;

                            $admin_query = "Select * from admin";
                            $result = $connection->query($admin_query);
                            if(!$result) die($connection->error);
                            $rows = $result->num_rows;

                            for($i = 0 ; $i < $rows ; $i++)
                            {
                                $arr = $result->fetch_assoc();
                                
                                $admin_id = $arr['admin_id'];

                                if($admin_id == $_SESSION['admin_id'])
                                    continue;

                                echo <<<HTML
                                    <option value="$admin_id">$admin_id</option>
                                    HTML;
                            }



                        echo <<<HTML
                                    </select>
                                     <input type="hidden" name="delete" value="yes">

                                     <button type="submit">Delete</button>

                                </form>
                            </div>

                        HTML;

                        if(isset($_GET['admin_valid_id']))
                        {
                            echo " <h3>Enter a valid admin ID</h3>";
                        }


                        break;
                    
                    default:
                        # code...
                        break;
                }
            }   
            else
            {

                if(isset($_POST['add']))
                {

                    $admin_name = $_POST['admin_name'];
                    $admin_email = $_POST['email'];
                    $admin_pwd = $_POST['password'];

                    if (filter_var($admin_email, FILTER_VALIDATE_EMAIL))
                    {

                        $admin_check_query = "Select * from admin where admin_name = '$admin_name'";
                        $result = $connection->query($admin_check_query);
                        if($result->num_rows == 0)
                        {
                            $admin_add_query = "Insert into admin (email, admin_name, password) values ('$admin_email','$admin_name','$admin_pwd' )";
                            $result = $connection->query($admin_add_query);
                            if(!$result) die($connection->error);
                            else 
                            {
                                echo <<<HTML

                                    Admin Account added successfully 
                                    <a href="http://localhost/scripts/dashboard.php" class="book-btn smol-button" style="margin-left: auto;">
                                        Dashboard
                                    </a>

                                HTML;
                            }
                        }
                        else
                        {
                            header('Location: http://localhost/scripts/admin_q.php?a_flag=1&valid_id="false"');
                        }
                    }
                    else
                    {
                        header('Location: http://localhost/scripts/admin_q.php?a_flag=1&valid_email="false"');
                    }

                }
                elseif (isset($_POST['delete']))
                {
                    
                    $admin_id = $_POST['admin_id'];

                    $admin_check_query = "select * from admin where admin_id = '$admin_id'";
                    $result = $connection->query($admin_check_query);

                    if($result->num_rows == 1)
                    {
                        $admin_add_query = "Delete from admin where admin_id = '$admin_id'";
                        $result = $connection->query($admin_add_query);
                        if(!$result) die($connection->error);
                        else 
                        {
                            echo <<<HTML

                                Admin Account removed successfully 
                                <a href="http://localhost/scripts/dashboard.php" class="book-btn smol-button" style="margin-left: auto;">
                                    Dashboard
                                </a>

                            HTML;
                        }
                    }
                    else
                    {
                        header('Location: http://localhost/scripts/admin_q.php?a_flag=2&admin_valid_id="false"');
                    }
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