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
            reference TEXT,  -- New column for reference
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
    $reference = $_POST["reference"]; // Assuming the reference is sent via POST

    $stmt->bindParam(':fullName', $fullName);
    $stmt->bindParam(':address', $address);
    $stmt->bindParam(':contactNumber', $contactNumber);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':cartItems', $cartItemsJSON);
    $stmt->bindParam(':totalPrice', $totalPrice);
    $stmt->bindParam(':reference', $reference); // Bind reference parameter

    $cartItemsJSON = json_encode($cartItems);
    $stmt->execute();
    echo json_encode(["success" => true, "message" => "Order processed successfully"]);

    $db = null;
} catch (PDOException $ex) {
    echo json_encode(["success" => false, "error" => "Database operation failed: " . $ex->getMessage()]);
}

?>
