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
    
    <!-- Estilos para a caixa de mensagens customizada -->
    <style>
        #messageBox {
            display: none;
            position: fixed;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            padding: 15px 25px;
            border-radius: 8px;
            color: white;
            font-family: 'Montserrat', sans-serif; 
            font-size: 16px;
            z-index: 1000;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            min-width: 300px;
            text-align: center;
            opacity: 0;
            transition: opacity 0.3s ease-in-out;
        }
        #messageBox.show {
            opacity: 1;
        }
        #closeMessageBox {
            background: none;
            border: none;
            color: white;
            font-size: 20px;
            position: absolute;
            right: 10px;
            top: 5px;
            cursor: pointer;
        }
    </style>
</head>
