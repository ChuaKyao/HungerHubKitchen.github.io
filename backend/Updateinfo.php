<?php

    include 'components/connect.php';

    session_start();

    if(isset($_SESSION['user_id'])){
        $user_id = $_SESSION['user_id'];
    }else{
        $user_id = '';
        header('location:Homepage.php');
    }

    if(isset($_POST['submit'])){

        $name = $_POST['name'];
        $name = filter_var($name, FILTER_SANITIZE_STRING);
     
        $number = $_POST['number'];
        $number = filter_var($number, FILTER_SANITIZE_STRING);
        $email = $_POST['email'];
        $email = filter_var($email, FILTER_SANITIZE_STRING);
     
        if(!empty($name)){
           $update_name = $conn->prepare("UPDATE `users` SET name = ? WHERE id = ?");
           $update_name->execute([$name, $user_id]);
           $message[] = 'username updated!';
        }
     
        if(!empty($email)){
           $select_email = $conn->prepare("SELECT * FROM `users` WHERE email = ?");
           $select_email->execute([$email]);
           if($select_email->rowCount() > 0){
              $message[] = 'email already taken!';
           }else{
              $update_email = $conn->prepare("UPDATE `users` SET email = ? WHERE id = ?");
              $update_email->execute([$email, $user_id]);
              $message[] = 'email updated!';
           }
        }
     
        if(!empty($number)){
           $select_number = $conn->prepare("SELECT * FROM `users` WHERE number = ?");
           $select_number->execute([$number]);
           if($select_number->rowCount() > 0){
              $message[] = 'number already taken!';
           }else{
              $update_number = $conn->prepare("UPDATE `users` SET number = ? WHERE id = ?");
              $update_number->execute([$number, $user_id]);
              $message[] = 'phone number updated!';
           }
        }
        
        $empty_pass = 'da39a3ee5e6b4b0d3255bfef95601890afd80709';
        $select_prev_pass = $conn->prepare("SELECT password FROM `users` WHERE id = ?");
        $select_prev_pass->execute([$user_id]);
        $fetch_prev_pass = $select_prev_pass->fetch(PDO::FETCH_ASSOC);
        $prev_pass = $fetch_prev_pass['password'];
        $old_pass = sha1($_POST['old_pass']);
        $old_pass = filter_var($old_pass, FILTER_SANITIZE_STRING);
        $new_pass = sha1($_POST['new_pass']);
        $new_pass = filter_var($new_pass, FILTER_SANITIZE_STRING);
        $confirm_pass = sha1($_POST['confirm_pass']);
        $confirm_pass = filter_var($confirm_pass, FILTER_SANITIZE_STRING);
     
        if($old_pass != $empty_pass){
           if($old_pass != $prev_pass){
              $message[] = 'old password not matched!';
           }elseif($new_pass != $confirm_pass){
              $message[] = 'confirm password not matched!';
           }else{
              if($new_pass != $empty_pass){
                 $update_pass = $conn->prepare("UPDATE `users` SET password = ? WHERE id = ?");
                 $update_pass->execute([$confirm_pass, $user_id]);
                 $message[] = 'password updated successfully!';
              }else{
                 $message[] = 'please enter a new password!';
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
    <title>Update Info</title>
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
            <section class="Updateinfo section" style="background-image: url(images/booktable-img.png);">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-container">
                                <form action="" method="post">
                                    <h3>Update Profile</h3>
                                    <input type="text" name="name" placeholder="<?= $fetch_profile['name']; ?>" class="box" maxlength="50">
                                    <input type="email" name="email" placeholder="<?= $fetch_profile['email']; ?>" class="box" maxlength="50" oninput="this.value = this.value.replace(/\s/g, '')">
                                    <input type="number" name="number" placeholder="<?= $fetch_profile['number']; ?>" class="box" min="0" max="9999999999" maxlength="10">
                                    <input type="password" name="old_pass" placeholder="enter your old password" class="box" maxlength="50" oninput="this.value = this.value.replace(/\s/g, '')">
                                    <input type="password" name="new_pass" placeholder="enter your new password" class="box" maxlength="50" oninput="this.value = this.value.replace(/\s/g, '')">
                                    <input type="password" name="confirm_pass" placeholder="confirm your new password" class="box" maxlength="50" oninput="this.value = this.value.replace(/\s/g, '')">
                                    <input type="submit" value="update now" name="submit" class="btn">
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <?php include 'components/footer.php'?>
        </div>
    </div>

    <div class="fixed-btn">
        <button class="chatbot-toggler">
            <span class="material-symbols-outlined">mode_comment</span>
            <span class="material-symbols-outlined">close</span>
        </button>

        <div class="chatbot">
            <header>
                <h3>Chatbot</h3>
                <span class="close-btn material-symbols-outlined">close</span>
            </header>
            <ul class="chatbox">
                <li class="chat incoming">
                    <span class="material-symbols-outlined">smart_toy</span>
                    <p>Hi customer 👋🏼 <br>I am here to assist you with any queries related to the food and products available at our menu. How may I assist you today?</p>
                </li>
            </ul>

            <div class="chat-input">
            <input type="text" id="prompt" placeholder="Enter a message..." required>
            <span id="promptButton" class="material-symbols-outlined" onclick="promptAi()">send</span>
            </div>
        </div>
    </div>

    <div class="loader">
        <img src="images/reload.gif" alt="">
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