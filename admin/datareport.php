<?php
include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
   header('location:admin_login.php');
   exit; // Make sure to exit after redirection
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Data Report</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="../css/admin_style.css">

   <style>
      /* Additional style for print button */
      .print-button {
         text-align: right;
         margin-top: 20px;
         font-size: 20px;
      }

      table {
         font-family: Arial, sans-serif;
         border-collapse: collapse;
         width: 100%;
         margin-top: 20px;
      }

      th, td {
         border: 1px solid #dddddd;
         text-align: left;
         padding: 12px;
         font-size: 16px; /* Adjust the font size for smaller screens */
      }

      th {
         background-color: #f2f2f2;
      }

      h2 {
         text-align: center;
         font-size: 23px;
      }

      .table-form{
         margin: 0 auto;
         width: 100%;
         overflow-x: auto;
      }

      @media screen and (max-width: 768px) {
         td, th {
            padding: 8px; /* Adjust padding for smaller screens */
            font-size: 10px; /* Adjust font size for smaller screens */
         }
      }
   </style>
</head>

<body>

   <?php include '../components/admin_header.php' ?>

   <section class="messages">

      <h1 class="heading">Data Report</h1>

      <form method="get" action="">
         <select name="month" onchange="this.form.submit()">
            <option value="" selected disabled hidden>Select Month</option>
            <?php
            $conn = new mysqli("localhost", "root", "", "food_db");

            // Check connection
            if ($conn->connect_error) {
               die("Connection failed: " . $conn->connect_error);
            }

            $sql = "SELECT DISTINCT MONTHNAME(placed_on) as mname FROM orders";

            $result = $conn->query($sql);

            if ($result) {
               while ($row = $result->fetch_object()) {
                  echo "<option value='$row->mname'>$row->mname</option>";
               }
            } else {
               echo "Error: " . $conn->error;
            }

            $conn->close(); // Close the database connection
            ?>
         </select>
      </form>

      <?php
      if (isset($_GET['month'])) {
         $selectedMonth = $_GET['month'];
         echo "<h2>$selectedMonth</h2>";
      }
      ?>

      <div class="table-form" id="table-form">
         <?php
         if (isset($_GET['month'])) {
            $selectedMonth = $_GET['month'];
            $conn = new mysqli("localhost", "root", "", "food_db");

            // Check connection
            if ($conn->connect_error) {
               die("Connection failed: " . $conn->connect_error);
            }

            $sql = "SELECT id, user_id, total_products, total_price, placed_on FROM orders WHERE MONTHNAME(placed_on)='$selectedMonth'";

            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
               echo "<table>";
               echo "<tr><th>Table Number</th><th>Placed On</th><th>Order ID</th><th>User ID</th><th>Total Products</th><th>Total Price</th></tr>";
               $tableNumber = 1;
               $totalPriceSum = 0;
               while ($row = $result->fetch_assoc()) {
                  echo "<tr>";
                  echo "<td>" . $tableNumber . "</td>";
                  echo "<td>" . $row['placed_on'] . "</td>";
                  echo "<td>" . $row['id'] . "</td>";
                  echo "<td>" . $row['user_id'] . "</td>";
                  echo "<td>" . $row['total_products'] . "</td>";
                  echo "<td>RM " . $row['total_price'] . "</td>";
                  echo "</tr>";
                  $totalPriceSum += $row['total_price'];
                  $tableNumber++;
               }
               echo "<tr><td colspan='4'></td><td><strong>Total Price Sum:</strong></td><td><strong>RM " . $totalPriceSum . "</strong></td></tr>";
               echo "</table>";
            } else {
               echo "No results found.";
            }

            $conn->close(); // Close the database connection
         }
         ?>
      </div>

      <div class="print-button">
         <button onclick="printData('table-form')">Print</button>
      </div>

   </section>

   <!-- custom js file link  -->
   <script src="../js/admin_script.js"></script>

   <script>
      function printData(id) {
         var data = document.getElementById(id).innerHTML;
         var myWindow = window.open('', '', 'width=800, height=600');
         myWindow.document.write('<html><head><title>Data Report</title>');
         myWindow.document.write('<style>@media print { .print-button { display: none; } }</style>');
         myWindow.document.write('</head><body>');
         myWindow.document.write(data);
         myWindow.document.write('</body></html>');
         myWindow.document.close();
         myWindow.focus();
         myWindow.print();
      }
   </script>

</body>

</html>
