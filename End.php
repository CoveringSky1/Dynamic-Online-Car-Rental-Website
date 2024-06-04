<?php
session_start();

$json = file_get_contents("car.json");

if ($json === false) {
    die("Failed to read car.json");
}

$cars = json_decode($json, true);

if ($cars === null) {
    die("Failed to parse JSON");
}

if (!isset($_SESSION['cart'])) {
    die("No items in cart");
}

foreach ($_SESSION['cart'] as $item) 
{
    $model = $item['model'];
    if (isset($cars['cars'][$model]))
    {
        $cars['cars'][$model]['avaliability'] = false;
    }
    else 
    {
        echo "No car with model: $model. Skipping this model.\n";
        continue;
    }
}

$json = json_encode($cars, JSON_PRETTY_PRINT);

if ($json === false) {
    die("Failed to encode JSON");
}

$result = file_put_contents("car.json", $json);

if ($result === false) {
    die("Failed to write to car.json");
}

unset($_SESSION['cart']);
?>

<!DOCTYPE html>
<html>
<head>
	<title>Cars Data</title>
	<!DOCTYPE html>
	<link rel="stylesheet" href="stylecart.css">
<html>
<head>
	<title>Cars List</title>
</head>
<body>
    <header>
    <h1><a style= "color: white; text-decoration: none;" href = "MainPage.php">Car Rental Center</a></h1>
    </header>
	<main>
    <h2>Car Reservation Recipt</h2>
    <br>
    <strong>Thank you to rent the car via us. Congratulations your booking is successful, Safe all the way</strong>
    <br>
    <strong>Your Information</strong>
    <br>
    <strong>Your Name:</strong> <?php echo $_POST['name'];?>
    <br>
    <strong>Address:</strong> <?php echo $_POST['address'];?>
    <br>
    <strong>Suburb:</strong> <?php echo $_POST['suburb'];?>
    <br>
    <strong>State:</strong> <?php echo $_POST['state'];?>
    <br>
    <strong>Country:</strong> <?php echo $_POST['country'];?>
    <br>
    <strong>Your Email:</strong> <?php echo $_POST['email'];?>
    <br>
    <strong>Total Price: $</strong> <?php echo $_POST['price'];?>
    </main>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
	<script src="script.js"></script>
</body>
</html>