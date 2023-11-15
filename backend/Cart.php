<?php

    include 'components/connect.php';

    session_start();

    if(isset($_SESSION['user_id'])){
        $user_id = $_SESSION['user_id'];
    }else{
        $user_id = 'location:Homepage.php';
    };

    if(isset($_POST['delete'])){
        $cart_id = $_POST['cart_id'];
        $delete_cart_item = $conn->prepare("DELETE FROM `cart` WHERE id = ?");
        $delete_cart_item->execute([$cart_id]);
        $message[] = 'cart item deleted!';
    }
        
    if(isset($_POST['delete_all'])){
        $delete_cart_item = $conn->prepare("DELETE FROM `cart` WHERE user_id = ?");
        $delete_cart_item->execute([$user_id]);
        // header('location:cart.php');
        $message[] = 'deleted all from cart!';
    }
        
    if(isset($_POST['update_qty'])){
        $cart_id = $_POST['cart_id'];
        $qty = $_POST['qty'];
        $qty = filter_var($qty, FILTER_SANITIZE_STRING);
        $update_qty = $conn->prepare("UPDATE `cart` SET quantity = ? WHERE id = ?");
        $update_qty->execute([$qty, $cart_id]);
        $message[] = 'cart quantity updated';
    }

    $grand_total = 0;

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart</title>

    <link rel="icon" type="image/x-icon" href="logo.png">
    <!-- for icons  -->
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.8/css/solid.css">
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
    <script src="script.js" defer></script>
</head>

<body class="body-fixed">
    <?php include 'components/user_header.php'?>

    <div id="viewport">
        <div id="js-scroll-content">
            <section class="cart section" style="background-image: url(images/booktable-img.png);">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="sec-title text-center mb-5">
                                <p class="sec-sub-title mb-3">Cart</p>
                                <h2 class="h2-title">Checkout<span>& Checkout</span></h2>
                            </div>
                        </div>
                    </div>
                    <div class="menu-list-row">
                        <div class="row g-xxl-5 bydefault_show" id="menu-dish">
                            <?php
                                $grand_total = 0;
                                $select_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
                                $select_cart->execute([$user_id]);
                                if($select_cart->rowCount() > 0){
                                    while($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)){
                            ?>
                            <div class="col-lg-4 col-sm-6 dish-box-wp">
                                <form method="post" action="">
                                    <div class="dish-box text-center">
                                        <input type="hidden" name="cart_id" value="<?= $fetch_cart['id']; ?>">
                                            <div class="dist-img">
                                                <img src="uploaded_img/<?= $fetch_cart['image']; ?>" alt="<?= $fetch_cart['name']; ?>">
                                            </div>
                                            <div class="dish-rating">
                                                <?php
                                                    $rating = $fetch_cart['rating'];
                                                    for($i = 0; $i < $rating; $i++){
                                                        echo '<i class="uis uis-star"></i>';
                                                    }
                                                ?>
                                            </div>
                                            <div class="dish-title">
                                                <h3 class="h3-title"><?= $fetch_cart['name']; ?></h3>
                                                <p><?= $fetch_cart['details']; ?></p>
                                            </div>
                                            <div class="dish-info">
                                                <ul>
                                                    <li>
                                                        <p>Type</p>
                                                        <b><?= $fetch_cart['type']; ?></b>
                                                    </li>
                                                    <li>
                                                        <p>Size</p>
                                                        <b><?= $fetch_cart['size']; ?></b>
                                                    </li>
                                                </ul>
                                            </div>
                                            <!-- Assuming you want to display the price and add to cart button as well -->
                                            <div class="dist-bottom-row">
                                                <ul>
                                                    <li>
                                                        <b>RM <?= $fetch_cart['price']; ?></b>
                                                    </li>
                                                    <li>
                                                        <input type="number" name="qty" class="qty" min="1" max="99" value="<?= $fetch_cart['quantity']; ?>" onkeypress="if(this.value.length == 2) return false;">
                                                    </li>
                                                    <li>
                                                        <button type="submit" class="dish-edit-btn" name="update_qty">
                                                            <i class="uil uil-edit"></i>
                                                        </button>
                                                    </li>
                                                    <li>
                                                        <button type="submit" class="dish-delete-btn" name="delete">
                                                            <i class="uil uil-trash-alt" onclick="return confirm('delete this item?');"></i>
                                                        </button>
                                                    </li>
                                                </ul>
                                            </div>
                                        <div class="sub-total">sub total : <span>RM <?= $sub_total = ($fetch_cart['price'] * $fetch_cart['quantity']); ?>/-</span></div>
                                    </div>
                                </form>
                            </div>
                            <?php
                                    $grand_total += $sub_total;
                                    }
                                }else{
                                    echo '<p class="empty">your cart is empty</p>';
                                }
                            ?>
                        </div>
                        <div class="cart-total">
                            <p>cart total : <span>RM <?= $grand_total; ?></span></p>
                            <a href="Checkout.php" class="btn <?= ($grand_total > 1)?'':'disabled'; ?>">proceed to checkout</a>
                        </div>
                        <div class="dist-bottom-row">
                            <div class="more-btn">
                                <form action="" method="post">
                                    <button type="submit" class="dish-delete-all-btn"  name="delete_all">
                                        <i class="delete all <?= ($grand_total > 1)?'':'disabled'; ?>" onclick="return confirm('delete all from cart?');">Delete All</i>
                                    </button>
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