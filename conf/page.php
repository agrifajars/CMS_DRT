<?php
    if(isset($_GET['menu'])) {
        $menu = $_GET['menu'];
        switch ($menu) {
            case 'homepage';
                include 'pages/homepage.php';
                break;
            case 'category':
                include 'pages/category/category.php';
                break;
            case 'user':
                include 'pages/user/user.php';
                break;
            case 'supplier':
                include 'pages/supplier/supplier.php';
                break;
            case 'inventory';
                include 'pages/inventory/inventory.php';
                break;
            case 'inbound';
                include 'pages/inbound/inbound.php';
                break;
            case 'outbound';
                include 'pages/outbound/outbound.php';
                break;
            case 'transaction';
                include 'pages/transaction/transaction.php';
                break;
            case 'transaction_detail';
                include 'pages/transaction/transaction_detail.php';
                break;
        }
    } else {
        include 'pages/homepage.php';
    }
?>
