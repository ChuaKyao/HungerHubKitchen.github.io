<?php

    include 'components/connect.php';

    session_start();

    if(isset($_SESSION['user_id'])){
        $user_id = $_SESSION['user_id'];
    }else{
        $user_id = '';
        header('location:Homepage.php');
    };

    if(isset($_POST['submit'])){

        $name = $_POST['name'];
        $name = filter_var($name, FILTER_SANITIZE_STRING);
        $number = $_POST['number'];
        $number = filter_var($number, FILTER_SANITIZE_STRING);
        $email = $_POST['email'];
        $email = filter_var($email, FILTER_SANITIZE_STRING);
        $method = $_POST['method'];
        $method = filter_var($method, FILTER_SANITIZE_STRING);
        $address = $_POST['address'];
        $address = filter_var($address, FILTER_SANITIZE_STRING);
        $total_products = $_POST['total_products'];
        $total_price = $_POST['total_price'];
     
        $check_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
        $check_cart->execute([$user_id]);

        if($check_cart->rowCount() > 0){

            if($address == ''){
                $message[] = 'please add your address!';
            }else{
                
                $insert_order = $conn->prepare("INSERT INTO `orders`(user_id, name, number, email, method, address, total_products, total_price) VALUES(?,?,?,?,?,?,?,?)");
                $insert_order->execute([$user_id, $name, $number, $email, $method, $address, $total_products, $total_price]);

                $delete_cart = $conn->prepare("DELETE FROM `cart` WHERE user_id = ?");
                $delete_cart->execute([$user_id]);

                $message[] = 'order placed & paid successfully!';
            }
            
        }else{
            $message[] = 'your cart is empty';
        }
     
    }

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
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
            <section class="checkout section" style="background-image: url(images/booktable-img.png);">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="sec-title text-center mb-5">
                                <p class="sec-sub-title mb-3">Checkout</p>
                                <h2 class="h2-title">Order Summary</h2>
                            </div>
                            <div class="checkout-middle">
                                <form action="" method="post">
                                    <div class="cart-items">
                                        <h3>Cart Items</h3>
                                        <?php
                                            $grand_total = 0;
                                            $cart_items[] = '';
                                            $select_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
                                            $select_cart->execute([$user_id]);
                                            if($select_cart->rowCount() > 0){
                                                while($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)){
                                                $cart_items[] = $fetch_cart['name'].' ('.$fetch_cart['price'].' x '. $fetch_cart['quantity'].') - ';
                                                $total_products = implode($cart_items);
                                                $grand_total += ($fetch_cart['price'] * $fetch_cart['quantity']);
                                        ?>
                                        <p><span class="dish-title"><?= $fetch_cart['name']; ?></span><span class="price">RM <?= $fetch_cart['price']; ?> x <?= $fetch_cart['quantity']; ?></span></p>
                                        <?php
                                                }
                                            }else{
                                                echo '<p class="empty">your cart is empty!</p>';
                                            }
                                        ?>
                                        <p class="grand-total"><span class="dish-title">sub total : </span><span class="price">RM <?= $grand_total; ?></span></p>
                                        <a href="Cart.php" class="btn">view cart</a>
                                    </div>

                                    <input type="hidden" name="total_products" value="<?= $total_products; ?>">
                                    <input type="hidden" name="total_price" value="<?= $grand_total; ?>" value="">
                                    <input type="hidden" name="name" value="<?= $fetch_profile['name'] ?>">
                                    <input type="hidden" name="number" value="<?= $fetch_profile['number'] ?>">
                                    <input type="hidden" name="email" value="<?= $fetch_profile['email'] ?>">
                                    <input type="hidden" name="address" value="<?= $fetch_profile['address'] ?>">

                                    <div class="user-profile">
                                        <h3>Your Info</h3>
                                        <p><i class="uil uil-user"></i><span><?= $fetch_profile['name'] ?></span></p>
                                        <p><i class="uil uil-phone"></i><span><?= $fetch_profile['number'] ?></span></p>
                                        <p><i class="uil uil-envelope"></i><span><?= $fetch_profile['email'] ?></span></p>
                                        <a href="Updateinfo.php" class="btn">Update Info</a>
                                        <p><i class="uil uil-location-point"></i><span><?php if($fetch_profile['address'] == ''){echo 'please enter your address';}else{echo $fetch_profile['address'];} ?></span></p>
                                        <a href="Updateaddress.php" class="btn">Update Address</a>
                                        <div class="payment-method">
                                            <input type="radio" name="method" id="method-1" checked value="Visa">
                                            <label for="method-1" class="payment-method-item">
                                                <img src="images/visa.png" alt="">
                                            </label>
                                            <input type="radio" name="method" id="method-2" value="MasterCard">
                                            <label for="method-2" class="payment-method-item">
                                                <img src="images/mastercard.png" alt="">
                                            </label>
                                            <input type="radio" name="method" id="method-3" value="Paypal">
                                            <label for="method-3" class="payment-method-item">
                                                <img src="images/paypal.png" alt="">
                                        </div>
                                        <div class="payment-form-group">
                                            <input type="text" pattern="[0-9]*" inputmode="numeric" placeholder=" " class="payment-form-control" id="card-number" required maxlength="16">
                                            <label for="card-number" class="payment-form-label payment-form-label-required">Card Number</label>
                                        </div>
                                        <div class="payment-form-group-flex">
                                            <div class="payment-form-group">
                                                <input type="date" placeholder=" " class="payment-form-control" id="expiry-date" required>
                                                <label for="expiry-date" class="payment-form-label payment-form-label-required">Expiry Date</label>
                                            </div>
                                            <div class="payment-form-group">
                                                <input type="text" pattern="[0-9]*" inputmode="numeric" placeholder=" " class="payment-form-control" id="cvv" required maxlength="3">
                                                <label for="cvv" class="payment-form-label payment-form-label-required">CVV</label>
                                            </div>
                                        </div>
                                        <div class="button-2">
                                            <input type="submit" value="place order" name="submit" class="btn <?php if($fetch_profile['address'] == ''){echo 'disabled';} ?>">
                                        </div>
                                    </div>
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