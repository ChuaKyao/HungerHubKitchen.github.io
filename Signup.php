<?php

    include 'components/connect.php';

    session_start();

    if(isset($_SESSION['user_id'])){
        $user_id = $_SESSION['user_id'];
    }else{
        $user_id = '';
    }

    if(isset($_POST['submit'])){

        $name = $_POST['name'];
        $name = filter_var($name, FILTER_SANITIZE_STRING);
        $email = $_POST['email'];
        $email = filter_var($email, FILTER_SANITIZE_STRING);
        $number = $_POST['number'];
        $number = filter_var($number, FILTER_SANITIZE_STRING);
        $pass = sha1($_POST['pass']);
        $pass = filter_var($pass, FILTER_SANITIZE_STRING);
        $cpass = sha1($_POST['cpass']);
        $cpass = filter_var($cpass, FILTER_SANITIZE_STRING);
     
        $select_user = $conn->prepare("SELECT * FROM `users` WHERE email = ? OR number = ?");
        $select_user->execute([$email, $number]);
        $row = $select_user->fetch(PDO::FETCH_ASSOC);
     
        if($select_user->rowCount() > 0){
           $message[] = 'email or number already exists!';
        }else{
           if($pass != $cpass){
              $message[] = 'confirm password not matched!';
           }else{
              $insert_user = $conn->prepare("INSERT INTO `users`(name, email, number, password) VALUES(?,?,?,?)");
              $insert_user->execute([$name, $email, $number, $cpass]);
              $select_user = $conn->prepare("SELECT * FROM `users` WHERE email = ? AND password = ?");
              $select_user->execute([$email, $pass]);
              $row = $select_user->fetch(PDO::FETCH_ASSOC);
              if($select_user->rowCount() > 0){
                 $_SESSION['user_id'] = $row['id'];
                 header('location:Homepage.php');
              }
           }
        }
     
     }

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="icon" type="image/x-icon" href="logo.png">

    <!-- font awesome cdn link-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <!-- for icons  -->
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <!-- bootstrap  -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <!-- for swiper slider  -->
    <link rel="stylesheet" href="css/swiper-bundle.min.css">

    <!-- fancy box  -->
    <link rel="stylesheet" href="css/jquery.fancybox.min.css">
    <!-- custom css  -->
    <link rel="stylesheet" href="css/style.css">

    <!--  Google Fonts link for icons   -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0">
</head>

<body class="body-fixed">
    <?php include 'components/user_header.php'?>
    
    <div id="viewport">
        <div id="js-scroll-content">
            <section class="register section" style="background-image: url(images/booktable-img.png);">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-container">
                                <form action="" method="post">
                                    <h3>Register Now</h3>
                                    <input type="name" name="name" required placeholder="enter your name" class="box" maxlength="100">
                                    <input type="email" name="email" required placeholder="enter your email" class="box" maxlength="100" oninput="this.value = this.value.replace(/\s/g, '')">
                                    <input type="number" name="number" required placeholder="enter your number" class="box" maxlength="999999999999" oninput="this.value = this.value.replace(/\s/g, '')">
                                    <input type="password" name="pass" required placeholder="enter your password" class="box" maxlength="100" oninput="this.value = this.value.replace(/\s/g, '')">
                                    <input type="password" name="cpass" required placeholder="confirm your password" class="box" maxlength="100" oninput="this.value = this.value.replace(/\s/g, '')">
                                    <input type="submit" value="register now" name="submit" class="btn">
                                    <p>already have an account? <a href="Signin.php">login now</a></p>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>



    <!-- jquery  -->
    <script src="js/jquery-3.5.1.min.js"></script>
    <!-- bootstrap -->
    <script src="js/bootstrap.min.js"></script>
    <script src="js/popper.min.js"></script>

    <!-- fontawesome  -->
    <script src="js/font-awesome.min.js"></script>

    <!-- swiper slider  -->
    <script src="js/swiper-bundle.min.js"></script>

    <!-- mixitup -- filter  -->
    <script src="js/jquery.mixitup.min.js"></script>

    <!-- fancy box  -->
    <script src="js/jquery.fancybox.min.js"></script>

    <!-- parallax  -->
    <script src="js/parallax.min.js"></script>

    <!-- gsap  -->
    <script src="js/gsap.min.js"></script>

    <!-- scroll trigger  -->
    <script src="js/ScrollTrigger.min.js"></script>
    <!-- scroll to plugin  -->
    <script src="js/ScrollToPlugin.min.js"></script>
    <!-- rellax  -->
    <!-- <script src="js/rellax.min.js"></script> -->
    <!-- <script src="js/rellax-custom.js"></script> -->
    <!-- smooth scroll  -->
    <script src="js/smooth-scroll.js"></script>
    <!-- custom js  -->
    <script src="js/main.js"></script>

    <script src="js/script.js"></script>

</body>

</html>