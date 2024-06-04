$(document).ready(function(){
	$.ajax({
		url: "car.json",
		type: "GET",
		dataType: "json",
		success: function(data){
			displayCars(data.cars);
		}
	});

window.onload = function() {
	$.ajax({
		url: "car.json",
		type: "GET",
		dataType: "json",
		success: function(data){
			displayCars(data.cars);
		}
	})};
	

	function displayCars(cars){
		var output = "";
        output += "<div class = 'table'>";
		for(var i in cars){
            output += "<div class ='item'>"
			output += "<h3>"+ cars[i].year + "-" + cars[i].brand + "-" + cars[i].model + "</h3>";
			output += "<img src='image/"+cars[i].year + cars[i].model +".jpg'>"
			output += "<ul>";
			output += "<li><strong>Category</strong>: " + cars[i].category + "</li>";
			output += "<li><strong>Mileage</strong>: " + cars[i].mileage + "kms</li>";
			output += "<li><strong>Fuel Type</strong>: " + cars[i].fuel + "</li>";
			output += "<li><strong>Seats</strong>: " + cars[i].seats + "</li>";
			output += "<li><strong>Price Per Day</strong>: $" + cars[i].price + "</li>";
            output += "<li><strong>Availability</strong>: " + cars[i].avaliability + "</li>";
			output += "<li><strong>Description</strong>: " + cars[i].description + "</li>";
            output += "<button id='addToCart-" + i + "' data-index='" + i + "' data-available='" + cars[i].avaliability + "'>Booking</button>";
			output += "</ul>";
            output += "</div>"
		}
        output += "</div>"
		$("#cars").html(output);

		$("button[id^='addToCart-']").click(function() {
			var index = $(this).data("index");
			var available = $(this).data("available");
			
			if (available) {
				addToCart(cars[index]);
			} else {
				alert("Sorry, the car is not available now. Please try other cars.");
			}
		});
	}
});

function addToCart(car) {
	$.ajax({
		url: "addToCart.php",
		type: "POST",
		data: {car: JSON.stringify(car)},
		success: function(response) {
			if (response === "success") {
				alert("Car ready to booking successfully.");
			} else {
				alert("Error booking car.");
			}
		}
	});
}

$("#viewCart").click(function() {
	window.location.href = "cart.php";
});

function validateForm() {
	var name = document.forms["order-form"]["name"].value;
	var address = document.forms["order-form"]["address"].value;
	var suburb = document.forms["order-form"]["suburb"].value;
	var state = document.forms["order-form"]["state"].value;
	var country = document.forms["order-form"]["country"].value;
	var email = document.forms["order-form"]["email"].value;
	var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  
	if (name == "" || address == "" || suburb == "" || state == "" || country == "" || email == "") {
	  alert("Please fill in all required fields.");
	  return false;
	}
	
	if (!emailRegex.test(email)) {
	  alert("Please enter a valid email address.");
	  return false;
	}
	
	return true;
  }