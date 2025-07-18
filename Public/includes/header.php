<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BuyAtHome</title> 
    <link rel="stylesheet" href="../../Public/css/main.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Luckiest+Guy&family=Montserrat:ital,wght@0,100..900;1,100..900&family=Tourney:ital,wght@0,900;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" xintegrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmRysVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
   
    <style>
       #messageBox {
        position: fixed;
        top: 20px;
        left: 50%;
        transform: translateX(-50%);
        background-color: #f44336;
        color: white;
        padding: 15px 40px 15px 20px;
        border-radius: 8px;
        font-weight: 600;
        box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        display: none; 
        z-index: 9999;
        min-width: 300px;
        max-width: 90vw;
        user-select: none;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        letter-spacing: 0.03em;
        box-sizing: border-box;
        }

        #messageText {
        display: inline-block;
        vertical-align: middle;
        font-size: 16px;
        }

        #closeMessageBox {
        position: absolute;
        top: 8px;
        right: 10px;
        background: transparent;
        border: none;
        color: white;
        font-size: 22px;
        font-weight: bold;
        cursor: pointer;
        padding: 0;
        line-height: 1;
        user-select: none;
        transition: color 0.2s ease;
        }

        #closeMessageBox:hover {
        color: #ddd;
        }


    </style>
</head>
