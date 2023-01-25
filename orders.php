<?php

include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Encomendas</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'header.php'; ?>

<div class="heading">
   <h3>SUAS ENCOMENDAS</h3>
   <p> <a href="home.php">Home</a> / Encomendas </p>
</div>

<section class="placed-orders">

   <h1 class="title">Encomendas Feitas</h1>

   <div class="box-container">

      <?php
         $order_query = mysqli_query($conn, "SELECT * FROM `orders` WHERE user_id = '$user_id'") or die('query failed');
         if(mysqli_num_rows($order_query) > 0){
            while($fetch_orders = mysqli_fetch_assoc($order_query)){
      ?>
      <div class="box">
         <p> Colocado em : <span><?php echo $fetch_orders['placed_on']; ?></span> </p>
         <p> Nome : <span><?php echo $fetch_orders['name']; ?></span> </p>
         <p> Número : <span><?php echo $fetch_orders['number']; ?></span> </p>
         <p> E-mail : <span><?php echo $fetch_orders['email']; ?></span> </p>
         <p> Morada : <span><?php echo $fetch_orders['address']; ?></span> </p>
         <p> Forma de pagamento : <span><?php echo $fetch_orders['method']; ?></span> </p>
         <p> seus pedidos : <span><?php echo $fetch_orders['total_products']; ?></span> </p>
         <p> Preço total : <span><?php echo $fetch_orders['total_price']; ?>Kz</span> </p>
         <p> Estado do pagamento : <span style="color:<?php if($fetch_orders['payment_status'] == 'pending'){ echo 'red'; }else{ echo 'green'; } ?>;"><?php echo $fetch_orders['payment_status']; ?></span> </p>
         </div>
      <?php
       }
      }else{
         echo '<p class="empty">Nenhuma encomenda ainda foi solicitada!</p>';
      }
      ?>
   </div>

</section>








<?php include 'footer.php'; ?>

<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>