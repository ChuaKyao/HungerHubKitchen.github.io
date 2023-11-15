<?php

    include 'components/connect.php';

    session_start();

    if(isset($_SESSION['user_id'])){
        $user_id = $_SESSION['user_id'];
    }else{
        $user_id = '';
        header('location:Homepage.php');
    }

    if ($user_id != '') {
        $current_time = date('Y-m-d H:i:s');
        $time_limit = date('Y-m-d H:i:s', strtotime('-30 seconds'));
    
        $update_order_status = $conn->prepare("UPDATE orders SET order_status = 'completed' WHERE user_id = ? AND order_status = 'pending' AND placed_on <= ? ");
        $update_order_status->execute([$user_id, $time_limit]);
    }    

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order</title>

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
            <section class="order section" style="background-image: url(images/booktable-img.png);">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="sec-title text-center mb-5">
                                <p class="sec-sub-title mb-3">Order</p>
                                <h2 class="h2-title">Order History<span>& Payment Status</span></h2>
                            </div>
                            <div class="orders">
                            <?php
                                if($user_id == ''){
                                    header("Location: Signin.php");
                                    exit;
                                }else{
                                    $select_orders = $conn->prepare("SELECT * FROM `orders` WHERE user_id = ?");
                                    $select_orders->execute([$user_id]);
                                    if($select_orders->rowCount() > 0){
                                        while($fetch_orders = $select_orders->fetch(PDO::FETCH_ASSOC)){
                            ?>
                                <div class="box">
                                    <p>placed on : <span><?= $fetch_orders['placed_on']; ?></span></p>
                                    <p>name : <span><?= $fetch_orders['name']; ?></span></p>
                                    <p>number : <span><?= $fetch_orders['number']; ?></span></p>
                                    <p>email : <span><?= $fetch_orders['email']; ?></span></p>
                                    <p>address : <span><?= $fetch_orders['address']; ?></span></p>
                                    <p>your orders : <span><?= $fetch_orders['total_products']; ?></span></p>
                                    <p>total price : <span>RM <?= $fetch_orders['total_price']; ?></span></p>
                                    <p>payment method : <span><?= $fetch_orders['method']; ?></span></p>
                                    <p>payment status : <span style="color: green">completed</span></p>
                                    <p>order status : <span style="color:<?php if($fetch_orders['order_status'] == 'pending'){ echo 'red'; }else{ echo 'green'; }; ?>"><?= $fetch_orders['order_status']; ?></span></p>
                                </div>
                            <?php
                                }
                                }else{
                                    echo '<p class="empty">no orders placed yet!</p>';
                                }
                                }
                            ?>
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