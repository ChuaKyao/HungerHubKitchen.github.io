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
        $date = $_POST['date'];
        $date = filter_var($date, FILTER_SANITIZE_STRING);
        $time = $_POST['time'];
        $time = filter_var($time, FILTER_SANITIZE_STRING);
        $pax = $_POST['pax'];
        $pax = filter_var($pax, FILTER_SANITIZE_STRING);
     
        $select_reservation = $conn->prepare("SELECT * FROM `reservation` WHERE name = ? AND email = ? AND number = ? AND date = ? AND time = ? AND pax = ?");
        $select_reservation->execute([$name, $email, $number, $date, $time, $pax]);
     
        if($select_reservation->rowCount() > 0){
           $message[] = 'already book a table!';
        }else{
     
           $insert_reservation = $conn->prepare("INSERT INTO `reservation`(user_id, name, email, number, date, time, pax) VALUES(?,?,?,?,?,?,?)");
           $insert_reservation->execute([$user_id, $name, $email, $number, $date, $time, $pax]);
     
           $message[] = 'book reservation successfully!';
     
        }
     
     }

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservation</title>

    <link rel="icon" type="image/x-icon" href="logo.png">
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
    <script src="js/script.js" defer></script>
</head>

<body class="body-fixed">
    <?php include 'components/user_header.php'?>

    <div id="viewport">
        <div id="js-scroll-content">
            <section style="background-image: url(images/booktable-img.png);"class="book-a-table section bg-light">
                <div class="book-table-shape">
<!--shape-->        <img src="images/ " alt="">
                </div>

                <div class="book-table-shape book-table-shape2">
<!--shape-->        <img src="images/" alt="">
                </div>

                <div class="sec-wp">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="sec-title text-center mb-5">
                                    <p class="sec-sub-title mb-3">Book Table</p>
                                    <h2 class="h2-title">Opening Table</h2>
                                </div>
                            </div>
                        </div>

                        <div class="book-table-info">
                            <div class="row align-items-center">
                                <div class="col-lg-4">
                                    <div class="call-now text-center">
                                        <i class="uil uil-phone"></i>
                                        <a href="tel:+6012-345-6789">+6012-345-6789</a>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="table-title text-center">
                                        <h3>Monday to Thrusday</h3>
                                        <p>9:00 am - 22:00 pm</p>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="table-title text-center">
                                        <h3>Friday to Sunday</h3>
                                        <p>11:00 am to 22:00 pm</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section class = "banner">
                <div class="container">
                    <img class="book-table-leave-left" src="images/table-leaves.png">
                   
                    <div class="row">
                        <div class="col-lg-12">
                            <img class="book-table-leave-right" src="images/table-leaves.png">
                            <div class="sec-title text-center mb-5">
                                
                                <p class="sec-sub-title mb-3">Reservation</p>
                                <h2 class="h2-title">Book Here!</h2>
                            </div>
                        </div>
                    </div>
                </div>
                <div class = "card-container">
                    <div class = "card-content">
                        <h3>Reservation</h3>
                        <form action="" method="post">
                            <div class = "form-row">
                                    <input type="text" name="name" required placeholder="Full Name" class="box" maxlength="100">
                                    <input type="email" name="email" required placeholder="Your email" class="box" maxlength="100">
                                </div>
    
                                <div class="form-row">
                                    <input type="date" required name="date">
                                    <input type="time" placeholder="Time" required name="time">
                                </div>
    
                            <div class = "form-row">
                                <input type="number" name="number" required placeholder="+60" class="box" maxlength="999999999999">
                                <input type = "number" placeholder="How Many Pax?" min = "1" required name="pax">
                            </div>
    
                            <div class = "form-btn">
                                <input type="submit" value="Book Table" name="submit">
                            </div>
                        </form>
                    </div>
                    <div class = "card-img">
                        <img class = "card-img" src="images/card-img.png" alt="" height=360px>
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