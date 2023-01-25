<?php

include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
}

if(isset($_POST['add_to_cart'])){

   $product_name = $_POST['product_name'];
   $product_price = $_POST['product_price'];
   $product_image = $_POST['product_image'];
   $product_quantity = $_POST['product_quantity'];

   $check_cart_numbers = mysqli_query($conn, "SELECT * FROM `cart` WHERE name = '$product_name' AND user_id = '$user_id'") or die('query failed');

   if(mysqli_num_rows($check_cart_numbers) > 0){
      $message[] = 'Este produto já existe no carrinho!';
   }else{
      mysqli_query($conn, "INSERT INTO `cart`(user_id, name, price, quantity, image) VALUES('$user_id', '$product_name', '$product_price', '$product_quantity', '$product_image')") or die('query failed');
      $message[] = 'Produto adicionado para o carrinho!';
   }
}

if(isset($_POST['add_to_fav'])){

   $product_name = $_POST['product_name'];
   $product_price = $_POST['product_price'];
   $product_image = $_POST['product_image'];

   $check_favlist_numbers = mysqli_query($conn, "SELECT * FROM `wishlist` WHERE name = '$product_name' AND user_id = '$user_id'") or die('query failed');

   if(mysqli_num_rows($check_favlist_numbers) > 0){
      $message[] = 'Este produto já existe nos favoritos!';
   }else{
      mysqli_query($conn, "INSERT INTO `wishlist`(user_id, name, price, image) VALUES('$user_id', '$product_name', '$product_price', '$product_image')") or die('query failed');
      $message[] = 'Produto adicionado para os favoritos!';
   }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Dreamshop</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">
   <link rel="stylesheet" href="css/personalizado.css">
   <link rel="stylesheet" href="css/bootstrap.css">

</head>
<body>
   
<?php include 'header.php'; ?>

<!--CARROSEEL--->
<div class="espaco-topo">
<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
  <!-- Indicators -->
  <ol class="carousel-indicators">
    <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
    <li data-target="#carousel-example-generic" data-slide-to="1"></li>
    <li data-target="#carousel-example-generic" data-slide-to="2"></li>
  </ol>

  <!-- Wrapper for slides -->
  <div class="carousel-inner" role="listbox">
    <div class="item active">
      <img src="images/slide1.jpg" alt="sld1">
    </div>

    <div class="item">
    <img src="images/slide1.jpg" alt="sld2">
    </div>
    </div>
  </div>

  <!-- Controls -->
  <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
    <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>
</div>
</div>

<section class="home">
   <div class="content">
      <h3>Escolha os melhores livros.</h3>
      <p>A Leitura é considerada um ato de meditação, e tem se dito que <br>Quem lê já não será a mesma pessoa.</p>
      <a href="about.php" class="white-btn">Descubra mais</a>
   </div>
</section>

<section class="products">
   <h1 class="title">Produtos mais Recentes</h1>

   <div class="box-container">

      <?php  
         $select_products = mysqli_query($conn, "SELECT * FROM `products` LIMIT 6") or die('query failed');
         if(mysqli_num_rows($select_products) > 0){
            while($fetch_products = mysqli_fetch_assoc($select_products)){

      ?>
     <form action="" method="post" class="box">
      <img class="image" src="uploaded_img/<?php echo $fetch_products['image']; ?>" alt="">
      <div class="name"><?php echo $fetch_products['name']; ?></div>
      <div class="price"><?php echo $fetch_products['price']; ?>Kz</div>

      <!--

      <div class="qtd_stock"> "<"-> ?php echo $fetch_products['qtd_stock']; ?> Indisponível</div>

      -->


      <input type="number" min="1" name="product_quantity" value="1" class="qty">
      <input type="hidden" name="product_name" value="<?php echo $fetch_products['name']; ?>">
      <input type="hidden" name="product_price" value="<?php echo $fetch_products['price']; ?>">
      <input type="hidden" name="product_image" value="<?php echo $fetch_products['image']; ?>">
      <input type="submit" value="Adicionar ao cart" name="add_to_cart" class="btn">
      <input type="submit" value="Add favoritos" name="add_to_fav" class="btn">
     </form>
      <?php
         }
      }else{
         echo '<p class="empty">Nenhum produto adicionado ainda!</p>';
      }
      ?>
   </div>

   <div class="load-more" style="margin-top: 2rem; text-align:center">
      <a href="shop.php" class="option-btn">Ver mais</a>
   </div>

</section>

<section class="about">

   <div class="flex">

      <div class="image">
         <img src="images/about-img.jpg" alt="">
      </div>

      <div class="content">
         <h3>Sobre Nós Dreamshop</h3>
         <p>Somos uma livraria, que possibilitará viajar em todos os genêro de livros, sem sair de casa.
         Encetivamos a leitura e nos abstemos do universo digital, em forma de preservação ao tradicional.</p>
         <a href="about.php" class="btn">Consulte mais</a>
      </div>

   </div>

</section>

<section class="home-contact">

   <div class="content">
      <h3>Tem alguma pergunta?</h3>
      <p>Tem alguma questão que deseja saber à respeito da nossa loja?</p>
      <a href="contact.php" class="white-btn">Contate-nos</a>
   </div>

</section>

<?php include 'footer.php'; ?>

<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>