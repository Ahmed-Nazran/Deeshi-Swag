<?php

try {
    $db = new PDO('sqlite:database.sqlite');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $res = $db->exec(
        "CREATE TABLE IF NOT EXISTS orders (
            id INTEGER PRIMARY KEY AUTOINCREMENT, 
            fullName TEXT, 
            address TEXT, 
            contactNumber TEXT, 
            email TEXT, 
            cartItems TEXT, 
            totalPrice REAL,
            reference TEXT,
            orderTime TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )"
    );

    $stmt = $db->prepare(
        "INSERT INTO orders (fullName, address, contactNumber, email, cartItems, totalPrice, reference) 
        VALUES (:fullName, :address, :contactNumber, :email, :cartItems, :totalPrice, :reference)"
    );

    $fullName = $_POST["fullName"];
    $address = $_POST["address"];
    $contactNumber = $_POST["contactNumber"];
    $email = $_POST["email"];
    $cartItems = json_decode($_POST["cartItems"], true);
    $totalPrice = $_POST["totalPrice"];
    $reference = isset($_POST["reference"]) ? $_POST["reference"] : null;

    $stmt->bindParam(':fullName', $fullName);
    $stmt->bindParam(':address', $address);
    $stmt->bindParam(':contactNumber', $contactNumber);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':cartItems', $cartItemsJSON);
    $stmt->bindParam(':totalPrice', $totalPrice);
    $stmt->bindParam(':reference', $reference);

    $cartItemsJSON = json_encode($cartItems);
    $stmt->execute();
    echo json_encode(["success" => true, "message" => "Order processed successfully"]);

    $db = null;
} catch (PDOException $ex) {
    echo json_encode(["success" => false, "error" => "Database operation failed: " . $ex->getMessage()]);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - Deeshi Swag</title>
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" />
    <link rel="stylesheet" href="style.css">
    <style>
        .checkout-form {
            margin-top: 20px;
        }

        .checkout-form input,
        .checkout-form button {
            width: 100%;
            margin-bottom: 10px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        .checkout-form button {
            background-color: #007bff;
            color: #fff;
            cursor: pointer;
        }
    </style>
</head>

<body>
    <section id="header">
        <a href=""> <img src="img/Im.png" title="Deeshi Swag"></a>
        <div>
            <ul id="navbar">
                <li><a href="index.html">Home</a></li>
                <li> <a href="shop.html">Shop</a></li>
                <li><a href="blog.html">Blog</a></li>
                <li><a href="about.html">About</a></li>
                <li><a href="contact.html">Contact</a></li>
                <li><a class="active" href="cart.html"><i class="far fa-shopping-bag" style="font-weight: 550;"> Cart</i></a></li>
                <li><a href="log&sign.html">Sign Up</a></li>
            </ul>
            <a href="#" id="close"><i class="far fa-times"></i></a>
        </div>
        <div id="mobile">
            <i id="bar" class="fas fa-outdent"></i>
        </div>
    </section>

    <section id="cart" class="s-1">
        <h2>Shopping Cart Summary</h2>
        <div class="cart-container">
            <div class="cart-items" id="cartItems">
                <!-- Cart items will be dynamically added here -->
            </div>
            <div class="cart-summary">
                <h3>Summary</h3>
                <div class="total">
                    <h4>Total</h4>
                    <h4 id="totalPrice">$0.00</h4>
                </div>
            </div>
        </div>
    </section>

    <section id="checkout" class="s-1 section-m1 checkout-form">
        <!-- Checkout Section -->
        <h2>Checkout</h2>
        <form id="checkoutForm" onsubmit="confirmOrder(); return false;">
            <input type="text" name="fullName" id="fullName" placeholder="Full Name" required>
            <input type="text" name="address" id="address" placeholder="Address" required>
            <input type="text" name="contactNumber" id="contactNumber" placeholder="Contact Number" required>
            <input type="email" name="email" id="email" placeholder="Email" required>
            <input type="text" name="reference" id="reference" placeholder="Affiliate Reference (optional)">
            <button type="submit">Confirm Order</button>
        </form>
    </section>

    <section id="newsletter" class="s-1 section-m1">
        <div class="nt">
            <h4>Sign Up For News Letters</h4><br>
            <p>Get E-mail updates about our latest shop and <span>special offers.</span></p>
        </div>
        <div class="form">
            <input type="email" id="email" placeholder="Email Adress" required>
            <button class="bt"> Sign Up </button>
        </div>
    </section>
    <footer class="s-1">
        <div class="c">
            <img src="img/Im.png" alt=""><br>
            <h4>Contact</h4>
            <p><strong>Adress: </strong>Banasree Dhaka 1000 C block Road no 4</p>
            <p><strong>Phone: </strong>(+880)19xxxxxxxx</p>
            <p><strong>Hours: </strong>10:00 - 18:00, Sat - Fri</p>
            <div class="follow">
                <h4>Follow us</h4>
                <div class="icon">
                    <i class="fab fa-facebook-f" style="font-weight: 400;"></i>
                    <i class="fab fa-instagram" style="font-weight: 400;"></i>
                    <i class="fab fa-twitter" style="font-weight: 400;"></i>
                    <i class="fab fa-pinterest" style="font-weight: 400;"></i>
                    <
