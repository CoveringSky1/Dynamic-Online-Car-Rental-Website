<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
    <title>Shopping Cart</title>
    <!DOCTYPE html>
	<link rel="stylesheet" href="stylecart.css">
</head>
<body>
    <header>
    <h1><a style= "color: white; text-decoration: none;" href = "MainPage.php">Car Rental Center</a></h1>
    </header>
    <main>
    <h2>Car Reservation</h2>
    <?php if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])): ?>
    <form id="order-form" method="POST" action="payment.php" >
    <table>
        <thead>
            <tr>
                <th>Image</th>
                <th>Car</th>
                <th>Fuel Type</th>
                <th>Seat</th>
                <th>Price each Day</th>
                <th>Rental Days</th>
                <th>Remove</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($_SESSION['cart'] as $index => $car): ?>
                <tr>
                    <td><?php echo "<img src='image/" . $car['year'] . $car['model'] . ".jpg'>"; ?></td>
                    <td><?php echo $car['year'] . " " . $car['brand'] . " " . $car['model']; ?></td>
                    <td><?php echo $car['fuel'] ; ?></td>
                    <td><?php echo $car['seats'] ; ?></td>
                    <td><?php echo $car['price'] ; ?></td>
                    <td><input type="number" name="rental_days" value="1" min="1"></td>
                    <td><button class="removeFromCart" data-index="<?php echo $index; ?>">Remove</button></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <table style = "border:2px solid rgb(0, 0, 0); padding:10px; text-align:center; align-items: center;">
      <tr>
        <td><label for="name">Name<span class="required">*</span></label></td>
        <td><input type="text" id="name" placeholder= "Your full name" name="name" required></td>
      </tr>
      <tr>
        <td><label for="address">Address<span class="required">*</span></label></td>
        <td><input type="text" id="address" placeholder= "Your shipping Address" name="address" required></td>
      </tr>
      <tr>
        <td><label for="suburb">Suburb<span class="required">*</span></label></td>
        <td><input type="text" id="suburb" placeholder= "Your suburb of address" name="suburb" required></td>
      </tr>
      <tr>
        <td><label for="state">State<span class="required">*</span></label></td>
        <td><input type="text" id="state" placeholder= "State" name="state" required></td>
      </tr>
      <tr>
        <td><label for="country">Country<span class="required">*</span></label></td>
        <td><input type="text" id="country" placeholder= "Country" name="country" required></td>
      </tr>
      <tr>
        <td><label for="email">Email<span class="required">*</span></label></td>
        <td><input type="email" id="email" placeholder= "XXX@XXX.com" name="email" required></td>
      </tr>
    </table>
    <input type="submit" value="Checkout" name="goButton">
    <?php else: ?>
        <p>Your cart is empty.</p>
    <?php endif; ?>
    </form>
    <br>
    <button id = "backButton" >Back</button>
    </main>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        $(".removeFromCart").click(function() {
            var index = $(this).data("index");

            $.ajax({
                url: "removeFromCart.php",
                type: "POST",
                data: {index: index},
                success: function(response) {
                    if (response === "success") {
                        alert("Car removed from the cart successfully.");
                        location.reload();
                    } else {
                        alert("Error removing car from the cart.");
                    }
                }
            });
        });
        $("#backButton").click(function() {
	        window.location.href = "MainPage.php";
        });
    </script>
</body>
</html>