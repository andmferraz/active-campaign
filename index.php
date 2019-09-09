<?php
require_once "_api/ActiveCampaign.php";

// Instance the class ActiveCampaign
$ac = new ActiveCampaign;

// Create a connection
$connection = $ac->createConnection("Service Name", "abc123def456", "Service Test", "http://dominio.com/path/imagename.png", "http://dominio.com/foo/");
var_dump($connection);


// Create a customer
$createCustomer = $ac->createCustomer("2", "61609", "email@mail.com", "1");
var_dump($createCustomer);


// Create a order
$orderProducts = [
    "orderProducts" => 
    [
        "externalid"  => "PROD12345",
        "name"        => "Produto 1",
        "price"       => "4990",
        "quantity"    => "2",
        "category"    => "Toys",
        "description" => "The most advanced Pogo Stick ever created!",
        "productUrl"  => "https://example.com/products/pogo-stick",
        "imageUrl"    => "https://example.com/products/pogo-stick.jpg",
        "sku"         => "123"
    ],
    [
        "externalid"  => "PROD54321",
        "name"        => "Produto 2",
        "price"       => "3650",
        "quantity"    => "4",
        "category"    => "Aneis",
        "description" => "The most advanced Pogo Stick ever created!",
        "productUrl"  => "https://example.com/products/pogo-stick",
        "imageUrl"    => "https://example.com/products/pogo-stick.jpg",
        "sku"         => "123"
    ]
];

$createOrder = $ac->createOrder("123456", "1", "email@mail.com", $orderProducts, "https://example.com/products/pogo-stick", "2019-09-09T15:43:00-03:00", "2019-09-09T15:43:00-03:00", "Credicard", "5000", "200", "150", "121", "R$", "1", "1");
var_dump($createOrder);


// Create a abandoned cart
$cartProducts = [
    "orderProducts" => 
    [
        "externalid"  => "ABCDE", // required
        "name"        => "Product 01", // required
        "price"       => "4990", // required
        "quantity"    => "4", // required
        "category"    => "Toys",
        "description" => "The most advanced Pogo Stick ever created!",
        "productUrl"  => "https://example.com/products/pogo-stick",
        "imageUrl"    => "https://example.com/products/pogo-stick.jpg",
        "sku"         => "123"
    ],
    [
        "externalid"  => "EDCBA", // required
        "name"        => "Product 02", // required
        "price"       => "3250", // required
        "quantity"    => "9", // required
        "category"    => "Toys",
        "description" => "The most advanced Pogo Stick ever created!",
        "productUrl"  => "https://example.com/products/pogo-stick",
        "imageUrl"    => "https://example.com/products/pogo-stick.jpg",
        "sku"         => "321"
    ]
];

$createAbandonedCart = $ac->createAbandonedCart("123456", "1", "email@mail.com", $cartProducts, "https://example.com/orders/3246315233", "2019-09-09T15:14:17-04:00", "2019-09-09T15:14:17-04:00", "2019-09-09T15:14:17-04:00", "5000", "USD", "1", "1");
var_dump($createAbandonedCart);
