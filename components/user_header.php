<?php
if(isset($message)){
    foreach($message as $message){
       echo '
       <div class="message">
          <span>'.$message.'</span>
          <i class="uil uil-times" onclick="this.parentElement.remove();"></i>
       </div>
       ';
    }
 }
?>

<!-- header start -->
    <header class="site-header">
        <div class="container">
            <div class="row">
                <div class="col-lg-2">
                    <div class="header-logo">
                        <a href="Homepage.php">
                            <img src="logo.png" width="100" height="100" alt="Logo">
                        </a>
                    </div>
                </div>
                <div class="col-lg-10">
                    <div class="main-navigation">
                        <button class="menu-toggle"><span></span><span></span></button>
                        <nav class="header-menu">
                            <ul class="menu food-nav-menu">
                                <li><a href="Homepage.php">Home</a></li>
                                <li><a href="Ourstory.php">Our Story</a></li>
                                <li><a href="Menu.php">Menu</a></li>
                                <li><a href="Order.php">Order</a></li>
                                <li><a href="Bookatable.php">Book a Table</a></li>
                                <li><a href="Contact.php">Contact</a></li>
                            </ul>
                        </nav>
                        <div class="header-right">
                           <?php
                              $count_cart_items = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
                              $count_cart_items->execute([$user_id]);
                              $total_cart_items = $count_cart_items->rowCount();
                           ?>
                            <a href="Cart.php" class="header-btn header-cart">
                                <i class="uil uil-shopping-cart"></i>
                                <span class="cart-number"><?= $total_cart_items; ?></span>
                            </a>
                            <a href="#" class="header-btn" id="header-btn1">
                                <i class="uil uil-user-square"></i>
                            </a>
                        </div>
                        <div class="profile">
                           <?php
                              $select_profile = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
                              $select_profile->execute([$user_id]);
                              if($select_profile->rowCount() > 0){
                                 $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
                           ?>
                           <p class="name"><?= $fetch_profile['name']; ?></p>
                                <a href="Profilepage.php" class="btn">profile</a>
                                <a href="components/user_logout.php" onclick="return confirm('logout from this website?');" class="btn">logout</a>
                           <p class="account"><a href="Signin.php">login</a> or <a href="Signup.php">register</a></p>
                           <?php
                           }
                           else{
                           ?>
                              <p class="name">please login first</p>
                              <a href="Signin.php"class="btn">login</a>
                           <?php
                           }
                           ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
