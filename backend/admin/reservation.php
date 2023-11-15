<?php

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:admin_login.php');
}

if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   $delete_reservation = $conn->prepare("DELETE FROM `reservation` WHERE id = ?");
   $delete_reservation->execute([$delete_id]);
   header('location:reservation.php');
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>reservation</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>

<?php include '../components/admin_header.php' ?>

<section class="messages">

   <h1 class="heading">reservation</h1>

   <div class="box-container">

   <?php
      $select_reservation = $conn->prepare("SELECT * FROM `reservation`");
      $select_reservation->execute();
      if($select_reservation->rowCount() > 0){
         while($fetch_reservation = $select_reservation->fetch(PDO::FETCH_ASSOC)){
   ?>
   <div class="box">
      <p> name : <span><?= $fetch_reservation['name']; ?></span> </p>
      <p> number : <span><?= $fetch_reservation['number']; ?></span> </p>
      <p> email : <span><?= $fetch_reservation['email']; ?></span> </p>
      <p> date : <span><?= $fetch_reservation['date']; ?></span> </p>
      <p> time : <span><?= $fetch_reservation['time']; ?></span> </p>
      <p> pax : <span><?= $fetch_reservation['pax']; ?></span> </p>
      <a href="reservation.php?delete=<?= $fetch_reservation['id']; ?>" class="delete-btn" onclick="return confirm('delete this reservation?');">delete</a>
   </div>
   <?php
         }
      }else{
         echo '<p class="empty">No reservation yet!</p>';
      }
   ?>

   </div>

</section>










<!-- custom js file link  -->
<script src="../js/admin_script.js"></script>

</body>
</html>