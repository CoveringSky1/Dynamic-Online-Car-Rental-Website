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
    <?php
session_start();

$conn = mysqli_connect("localhost","root","","assignment2");
if (!$conn)
    die("Could not connect to Server");

$bondAmount = 0;

if ($_SERVER["REQUEST_METHOD"] === "POST") 
{
    $email = $_POST["email"];
    $Date = date("Y-m-d");
    
    $stmt = $conn->prepare("SELECT rent_date FROM history WHERE user_email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    
    if ($stmt->num_rows > 0) 
    {
        $stmt->bind_result($rentDate);
        $stmt->fetch();
    
        $diffMonths = (int)date_diff(date_create($rentDate), date_create($Date))->format("%m");

        if ($diffMonths >= 3)
        {
            $bondAmount = 200;
        }
    
        $stmt = $conn->prepare("UPDATE history SET bond_amount = ? WHERE user_email = ?");
        $stmt->bind_param("is", $bondAmount, $email);
        $stmt->execute();
    } 
        
    else 
    {
        $stmt = $conn->prepare("INSERT INTO history (user_email, rent_date, bond_amount) VALUES (?, ?, 200)");
        $stmt->bind_param("ss", $email, $Date);
        $stmt->execute();
    }
    
    $stmt = $conn->prepare("SELECT bond_amount FROM history WHERE user_email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->bind_result($bondAmount);
    $stmt->fetch();
    $stmt->close();
}

echo "<header>
<h1><a style= 'color: white; text-decoration: none;' href = 'MainPage.php'>Car Rental Center</a></h1>
</header>";
echo "<div style='text-align: center;'>";
echo "<h2>Reservation</h2>";
echo "<table style='border-collapse: collapse; margin: 0 auto;'>";
echo "<thead><tr><th style='padding: 10px;'>Car</th><th style='padding: 10px;'>Rent Day</th><th style='padding: 10px;'>Price/day</th><th style='padding: 10px;'>Sub Total</th></tr></thead>";

$totalPrice = 0;

foreach ($_SESSION['cart'] as $cartItem) {
    $subTotal = $cartItem['price'] * $_POST['rental_days'];
    
    echo "<tr>";
    echo "<td style='padding: 10px;'>" . $cartItem['brand'] . " " . $cartItem['model'] . " " . $cartItem['year'] . "</td>";
    echo "<td style='padding: 10px;'>" . $_POST['rental_days'] . "</td>";
    echo "<td style='padding: 10px;'>$" . $cartItem['price'] . "</td>";
    echo "<td style='padding: 10px;'>$" . number_format($subTotal, 2) . "</td>";
    echo "</tr>";
    
    $totalPrice += $subTotal;
}
echo "<br>";

echo "<tr><td colspan='3' style='text-align: right; padding: 10px; '><b>Bond Amount:</td><td style='padding: 10px;'></b>$" . number_format($bondAmount, 2) . "</td><td style='padding: 10px;'></td></tr>";
$totalPrice += $bondAmount;
echo "<tr><td colspan='3' style='text-align: right; padding: 10px; '><b>Total Price:</td><td style='padding: 10px;'></b>$" . number_format($totalPrice, 2) . "</td><td style='padding: 10px;'></td></tr>";

echo "</table>";

echo "<form method='POST' action='End.php'>";
echo "<strong>Payment Method<strong>";

echo "<input type = 'hidden' id = 'name' name = 'name' value = " . $_POST['name'] . ">";
echo "<input type = 'hidden' id = 'address' name = 'address' value = " . $_POST['address'] . ">";
echo "<input type = 'hidden' id = 'suburb' name = 'suburb' value = " . $_POST['suburb'] . ">";
echo "<input type = 'hidden' id = 'state' name = 'state' value = " . $_POST['state'] . ">";
echo "<input type = 'hidden' id = 'country' name = 'country' value = " . $_POST['country'] . ">";
echo "<input type = 'hidden' id = 'email' name = 'email' value = " . $_POST['email'] . ">";
echo "<input type = 'hidden' id = 'price' name = 'price' value = " . $totalPrice . ">";

echo "</div>";
echo "<input type='radio' name='options' required checked> Credit Card
<input type='radio' name='options' required> Debit Card
<input type='radio' name='options' required> Paypal";

echo "<br>";

echo "<input type='submit' value='Payment' name='goButton'>";

echo "</form>";
echo "<br>";
$conn->close();
?>
<button id = "backButton" >Back</button>
</main>
</body>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
        $("#backButton").click(function() {
	        window.location.href = "MainPage.php";
        });
    </script>

</html>