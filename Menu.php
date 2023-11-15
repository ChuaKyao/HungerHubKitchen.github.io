<?php

    include 'components/connect.php';

    session_start();

    if(isset($_SESSION['user_id'])){
        $user_id = $_SESSION['user_id'];
    }else{
        $user_id = '';
    };

    include 'components/add_cart.php';

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HungerHub Kitchen</title>
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
    <script src="js/script.js" defer></script>
</head>

<body class="body-fixed">
    <?php include 'components/user_header.php'?>

    <div id="viewport">
        <div id="js-scroll-content">
<!--bgimg--><section style="background-image: url(images/menu/menu-img.jpeg);"
class="our-menu section bg-light repeat-img" id="menu">
                <div class="sec-wp">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="sec-title text-center mb-5">
                                    <p class="sec-sub-title mb-3">our menu</p>
                                    <h2 class="h2-title">Craftsmanship<span> & Flavor Meet Here.</span></h2>
                                </div>
                            </div>
                        </div>
                        <div class="menu-tab-wp">
                            <div class="row">
                                <div class="col-lg-12 m-auto">
                                    <div class="menu-tab text-center">
                                        <ul class="filters">
                                            
                                            <li class="filter" data-filter=".all, .maindish, .beverage, .desserts" id="first-filter">
<!--img for menu logo-->                        <img src="images/menu/menu-1.png" alt="">
                                                All
                                            </li>
                                            <li class="filter" data-filter=".maindish">
<!--img for menu logo-->                        <img src="images/menu/menu-2.png" alt="">
                                                Main Dish
                                            </li>
                                            <li class="filter" data-filter=".beverage">
<!--img for menu logo-->                        <img src="images/menu/menu-3.png" alt="">
                                                Beverage
                                            </li>
                                            <li class="filter" data-filter=".desserts">
<!--img for menu logo-->                        <img src="images/menu/menu-4.png" alt="">
                                                Dessert
                                            </li>
                                            <div class="filter-active"></div>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="menu-list-row">
                            <div class="row g-xxl-5 bydefault_show" id="menu-dish">
                            <?php
                                $select_products = $conn->prepare("SELECT * FROM `products` LIMIT 21");
                                $select_products->execute();
                                if($select_products->rowCount() > 0){
                                    while($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)){
                            ?>
                            <div class="col-lg-4 col-sm-6 dish-box-wp all <?= str_replace(' ','',$fetch_products['category']); ?>">
                            <form method="post" action="">
                                <div class="dish-box text-center">
                                <input type="hidden" name="pid" value="<?= $fetch_products['id']; ?>">
                                <input type="hidden" name="name" value="<?= $fetch_products['name']; ?>">
                                <input type="hidden" name="price" value="<?= $fetch_products['price']; ?>">
                                <input type="hidden" name="image" value="<?= $fetch_products['image']; ?>">
                                <input type="hidden" name="details" value="<?= $fetch_products['details']; ?>">
                                <input type="hidden" name="rating" value="<?= $fetch_products['rating']; ?>">
                                <input type="hidden" name="type" value="<?= $fetch_products['type']; ?>">
                                <input type="hidden" name="size" value="<?= $fetch_products['size']; ?>">
                                    <div class="dist-img">
                                        <img src="uploaded_img/<?= $fetch_products['image']; ?>" alt="<?= $fetch_products['name']; ?>">
                                    </div>
                                    <div class="dish-rating">
                                        <!-- Assuming you want to display stars based on the product rating -->
                                        <?php
                                            $rating = $fetch_products['rating'];
                                            for($i = 0; $i < $rating; $i++){
                                                echo '<i class="uis uis-star"></i>';
                                            }
                                        ?>
                                    </div>
                                    <div class="dish-title">
                                        <h3 class="h3-title"><?= $fetch_products['name']; ?></h3>
                                        <p><?= $fetch_products['details']; ?></p>
                                    </div>
                                    <div class="dish-info">
                                        <ul>
                                            <li>
                                                <p>Type</p>
                                                <b><?= $fetch_products['type']; ?></b>
                                            </li>
                                            <li>
                                                <p>Size</p>
                                                <b><?= $fetch_products['size']; ?></b>
                                            </li>
                                        </ul>
                                    </div>
                                    <!-- Assuming you want to display the price and add to cart button as well -->
                                    <div class="dist-bottom-row">
                                        <ul>
                                            <li>
                                                <b>RM <?= $fetch_products['price']; ?></b>
                                            </li>
                                            <li>
                                                <input type="number" name="qty" class="qty" min="1" max="99" value="1" onkeypress="if(this.value.length == 2) return false;">
                                            </li>
                                            <li>
                                                <button type="submit" class="dish-add-btn" name="add-to-cart">
                                                    <i class="uil uil-plus"></i>
                                                </button>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </form>
                            </div>
                            <?php
                                    }
                                }else{
                                    echo '<p class="empty">no products added yet!</p>';
                                }
                            ?>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="two-col-sec section">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-lg-5">
                            <div class="sec-img mt-5">
<!--img-->                      <img src="images/menu/spaghetti-1.png" alt="">
                            </div>
                        </div>
                        <div class="col-lg-7">
                            <div class="sec-text">
                                <h3 class="xxl-title">Allo Scoglio</h3>
                                <p>Spaghetti allo scoglio is found all over coastal Italy, and it's prized for its mix of fresh seafood, 
                                    which can include clams, mussels, shrimp, and cuttlefish or squid. Like spaghetti alle vongole, scoglio isn't saucy; 
                                    instead it consists of long strands of al dente pasta with a silky coating packed with briny seafood flavor.</p>
                               
                                    <p><b>Ingredients:</b><br>This dish features fresh clams and mussels cooked in a white wine and clam juice broth, along with shrimp, squid, 
                                        and cherry tomatoes. The seafood is served over cooked spaghetti, drizzled with lemon juice, and garnished with parsley for a delicious
                                        and flavorful seafood pasta.</p>

                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="two-col-sec section pt-0">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-lg-6 order-lg-1 order-2">
                            <div class="sec-text">
                                <h3 class="xxl-title">Chilli Prawns & Butternut</h3>
                                <p>Chilli prawns and butternut spaghetti is a mouthwatering dish that combines succulent prawns, a spicy chili sauce, 
                                   and tender butternut squash noodles for a harmonious blend of heat and sweetness.</p>
                                <p><b>Ingredients:</b><br>Toast breadcrumbs and sesame seeds in olive oil, add chili and cooked king prawns. Combine with 
                                    spiralized butternut spaghetti and finish with parsley and lime for a tasty, quick meal.</p>
                            </div>
                        </div>
                        <div class="col-lg-6 order-lg-2 order-1">
                            <div class="sec-img">
<!--img-->                      <img src="images/menu/spaghetti-2.png" alt="">
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