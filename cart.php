<?php
session_start();
require 'connection.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if (isset($_SESSION['is_admin']) && $_SESSION['is_admin'] === true) {
    header("Location: admin/index.php");
    exit;
}
$user_id = $_SESSION['user_id'];

$stmt = $pdo->prepare("
    SELECT c.id, c.quantity, c.size, c.total_price, c.added_at, 
           i.name, i.description, i.image, i.price AS base_price
    FROM cart c
    JOIN shop_items i ON c.item_id = i.itemid
    WHERE c.user_id = ?
");
$stmt->execute([$user_id]);
$cartItems = $stmt->fetchAll(PDO::FETCH_ASSOC);

$subtotal = 0;
foreach ($cartItems as $item) {
    $subtotal += $item['total_price'];
}

$tax = $subtotal * 0.1;
$total = $subtotal + $tax;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
        .menu-image {
            width: 100%;
            text-align: start;
            padding: 10px;
            background-color: #ece6e373;
            border-radius: 15px;
            margin-bottom: 30px;
            padding-bottom: 50px;
            padding-top: 150px;
            padding-left: 20px;
        }

        .menu-image h1 {
            font-size: 2rem;
            font-weight: 700;
            color: #0766AD;
            margin: 0;
            font-family: 'Roboto', sans-serif;
        }

        .cart-container {
            display: flex;
            gap: 20px;
            justify-content: flex-start;
            flex-wrap: wrap;
            max-width: 100%;
        }

        .cart-items {
            flex: 2;
            padding: 25px;
            min-width: 300px;
        }


        .cart-summary {
            flex: 1;
            position: sticky;
            top: 20px;
            height: fit-content;
            background-color: #fff;
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        }


        .cart-item {
            display: flex;
            align-items: center;
            background-color: #fff;
            padding: 15px;
            border-radius: 15px;
            margin-bottom: 15px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            gap: 15px;
            flex-wrap: wrap;
        }

        .cart-item img {
            width: 120px;
            height: 120px;
            border-radius: 15px;
            object-fit: cover;
        }

        .item-details {
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 5px;
        }

        .item-details h2 {
            margin: 0;
            color: #333;
            font-size: 1.2rem;
        }

        .item-details p {
            margin: 0;
            color: #555;
        }

        .item-details .price {
            font-weight: 700;
            color: #333;
            margin-top: 5px;
        }

        .item-details .sizes label {
            margin-right: 10px;
            font-size: 0.9rem;
            cursor: pointer;
        }

        .item-details .sizes input[type="radio"] {
            margin-right: 5px;
            accent-color: #f45a0df1;
        }

        .quantity {
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .quantity button {
            width: 30px;
            height: 30px;
            border: none;
            background-color: #ccc;
            color: white;
            font-size: 1rem;
            cursor: pointer;
            border-radius: 5px;
            transition: background 0.3s ease;
        }

        .quantity button:hover {
            background-color: #ff5500ff;
        }

        .quantity input {
            width: 50px;
            text-align: center;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 1rem;
            padding: 3px;
        }

        .remove-btn {
            background-color: #ccc;
            border: none;
            color: white;
            font-size: 1.2rem;
            cursor: pointer;
            border-radius: 5px;
            padding: 2px 6px;
            transition: background 0.3s ease;
        }

        .remove-btn:hover {
            background-color: #f55815ff;

        }

        .cart-summary h3 {
            margin-top: 0;
            color: #eb5d25ff;
        }

        .summary-item {
            display: flex;
            justify-content: space-between;
            margin: 10px 0;
            font-weight: 500;
        }

        .empty-cart {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 50px 20px;
            text-align: center;
            width: 100%;
        }

        .empty-cart img {
            max-width: 600px;
            width: 50%;
            margin-bottom: 20px;
            opacity: 0.8;
        }

        .empty-cart p {
            font-size: 1.2rem;
            color: #555;
            margin-bottom: 20px;
        }

        .back-to-menu-btn {
            display: inline-block;
            padding: 12px 25px;
            background-color: #ff7300ff;
            color: #fff;
            border-radius: 10px;
            text-decoration: none;
            font-weight: 600;
            transition: background 0.3s ease;
        }

        .back-to-menu-btn:hover {
            background-color: #2851d6ff;
        }

        .checkout-btn {
            width: 100%;
            padding: 12px;
            background-color: #ccc;
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 1rem;
            cursor: pointer;
            margin-top: 20px;
            transition: background 0.3s ease;
        }

        .checkout-btn:hover {
            background-color: #2679ffff;

        }

        @media (max-width: 768px) {
            .cart-container {
                flex-direction: column;
            }

            .cart-item {
                flex-direction: column;
                align-items: flex-start;
            }

            .cart-item img {
                margin-bottom: 10px;
            }
        }
    </style>
</head>

<body>

    <?php include("header.php"); ?>

    <div class="menu-image">
        <h1>Shopping Cart</h1>
    </div>

    <div class="cart-container">
        <div class="cart-items">
            <?php if (count($cartItems) === 0): ?>
                <div class="empty-cart">
                    <img src="images/WhatsApp Image 2025-12-27 at 11.29.45 PM.jpeg" alt="Empty Cart">
                    <a href="shop.php" class="back-to-menu-btn">Head to Menu</a>
                </div>
            <?php else: ?>
                <?php foreach ($cartItems as $index => $item): ?>
                    <div class="cart-item" data-cart-id="<?= $item['id'] ?>">
                        <img src="./image/<?= htmlspecialchars($item['image']) ?>" alt="<?= htmlspecialchars($item['name']) ?>">
                        <div class="item-details">
                            <h2><?= htmlspecialchars($item['name']) ?></h2>
                            <p><?= htmlspecialchars($item['description']) ?></p>
                            <span class="price" data-base-price="<?= $item['base_price'] ?>">$<?= number_format($item['total_price'], 2) ?></span>

                            <div class="sizes">
                                <label><input type="radio" name="size<?= $index ?>" value="small" <?= $item['size'] == 'small' ? 'checked' : '' ?>> Small</label>
                                <label><input type="radio" name="size<?= $index ?>" value="medium" <?= $item['size'] == 'medium' ? 'checked' : '' ?>> Medium</label>
                                <label><input type="radio" name="size<?= $index ?>" value="large" <?= $item['size'] == 'large' ? 'checked' : '' ?>> Large</label>
                            </div>

                            <div class="quantity">
                                <button class="minus">-</button>
                                <input type="number" value="<?= $item['quantity'] ?>" min="1">
                                <button class="plus">+</button>
                                <button class="remove-btn" title="Remove Item">&times;</button>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
        <div id="checkoutPopup" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%;
    background: rgba(0,0,0,0.6); justify-content:center; align-items:center; z-index:2000;">
            <div style="background:#fff; padding:30px; border-radius:15px; text-align:center; max-width:400px; width:90%; box-shadow:0 8px 20px rgba(0,0,0,0.2);">
                <h2 style="margin-bottom:15px; color:#0766AD;">Order Confirmation</h2>
                <p id="checkoutTotal" style="font-size:1.2rem; margin-bottom:25px;">Your total payment is $0.00</p>
                <button id="closeCheckoutPopup" style="padding:12px 25px; background-color:#ff7300ff; color:#fff; border:none; border-radius:10px; font-size:1rem; cursor:pointer; font-weight:600; transition:0.3s;">OK</button>
            </div>
        </div>

        <?php if (count($cartItems) > 0): ?>
            <div class="cart-summary">
                <h3>Order Summary</h3>
                <div class="summary-item">
                    <span>Subtotal</span>
                    <span id="subtotal">$<?= number_format($subtotal, 2) ?></span>
                </div>
                <div class="summary-item">
                    <span>Tax (10%)</span>
                    <span id="tax">$<?= number_format($tax, 2) ?></span>
                </div>
                <div class="summary-item">
                    <span>Total</span>
                    <span id="total">$<?= number_format($total, 2) ?></span>
                </div>
                <button class="checkout-btn">Proceed to Checkout</button>
            </div>
        <?php endif; ?>
    </div>

    <div id="rewardBanner" style="display:none; margin-bottom:20px; padding:15px; border-radius:15px; background:#ffefc5; text-align:center; box-shadow:0 4px 12px rgba(0,0,0,0.1);">
        <h3 style="color:#e66f3c; margin-bottom:10px;">🎉 Congratulations!</h3>
        <p>You earned a <strong>FREE Coffee Box</strong> for orders above $30!</p>
        <img src="images/547206093_17904338919254010_3702293719692060981_n (1).jpg" alt="Free Coffee Box" style="max-width:200px; margin-top:10px;">
    </div>

    <div id="checkoutPopup" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%;
    background: rgba(0,0,0,0.6); justify-content:center; align-items:center; z-index:2000;">
        <div style="background:#fff; padding:30px; border-radius:15px; text-align:center; max-width:400px; width:90%; box-shadow:0 8px 20px rgba(0,0,0,0.2);">
            <h2 style="margin-bottom:15px; color:#0766AD;">Order Confirmation</h2>
            <p id="checkoutTotal" style="font-size:1.2rem; margin-bottom:25px;">Your total payment is $0.00</p>
            <button id="closeCheckoutPopup" style="padding:12px 25px; background-color:#ff7300ff; color:#fff; border:none; border-radius:10px; font-size:1rem; cursor:pointer; font-weight:600; transition:0.3s;">OK</button>
        </div>
    </div>

    <div id="removePopup" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; 
background: rgba(0,0,0,0.5); justify-content:center; align-items:center; z-index:1000;">
        <div style="background:#fff; padding:20px; border-radius:10px; text-align:center; max-width:300px; width:90%;">
            <p style="margin-bottom:20px;">Do you want to remove this item?</p>
            <button id="confirmRemove" style="background:#FFA500; color:#fff; border:none; padding:10px 20px; border-radius:5px; margin-right:10px; cursor:pointer;">Yes</button>
            <button id="cancelRemove" style="background:#ccc; color:#333; border:none; padding:10px 20px; border-radius:5px; cursor:pointer;">No</button>
        </div>
    </div>

    <?php include("footer.php"); ?>


    <script>
        const cartItems = document.querySelectorAll('.cart-item');
        const checkoutBtn = document.querySelector('.checkout-btn');
        const checkoutPopup = document.getElementById('checkoutPopup');
        const checkoutTotal = document.getElementById('checkoutTotal');
        const closeCheckoutPopup = document.getElementById('closeCheckoutPopup');

        cartItems.forEach(item => {
            const minus = item.querySelector('.minus');
            const plus = item.querySelector('.plus');
            const input = item.querySelector('input[type="number"]');
            const remove = item.querySelector('.remove-btn');
            const priceEl = item.querySelector('.price');
            const basePrice = parseFloat(priceEl.dataset.basePrice);
            const sizeInputs = item.querySelectorAll('input[type="radio"]');

            function updatePriceAndDB() {
                const sizeValue = item.querySelector('input[type="radio"]:checked').value;
                const quantity = parseInt(input.value);
                const extra = (sizeValue === 'small') ? 1 : 2;
                const totalPrice = (basePrice + extra) * quantity;
                priceEl.textContent = '$' + totalPrice.toFixed(2);


                updateSummary();
                const cartId = item.dataset.cartId;
                fetch('update_cart.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        cart_id: cartId,
                        quantity: quantity,
                        size: sizeValue,
                        total_price: totalPrice
                    })
                });
            }

            minus.addEventListener('click', () => {
                if (parseInt(input.value) > 1) {
                    input.value--;
                    updatePriceAndDB();
                }
            });

            plus.addEventListener('click', () => {
                input.value++;
                updatePriceAndDB();
            });

            sizeInputs.forEach(i => i.addEventListener('change', updatePriceAndDB));

            let currentItemToRemove = null;
            remove.addEventListener('click', () => {
                currentItemToRemove = item;
                document.getElementById('removePopup').style.display = 'flex';
            });

            document.getElementById('cancelRemove').addEventListener('click', () => {
                currentItemToRemove = null;
                document.getElementById('removePopup').style.display = 'none';
            });

            document.getElementById('confirmRemove').addEventListener('click', () => {
                if (currentItemToRemove) {
                    const cartId = currentItemToRemove.dataset.cartId;
                    fetch('remove_cart.php', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify({
                                cart_id: cartId
                            })
                        })
                        .then(res => res.json())
                        .then(data => {
                            if (data.status === 'success') {
                                currentItemToRemove.remove();
                                updateSummary();
                            } else {
                                alert('Error removing item: ' + data.message);
                            }
                            currentItemToRemove = null;
                            document.getElementById('removePopup').style.display = 'none';
                        });
                }
            });
        });
        checkoutBtn.addEventListener('click', () => {
            fetch('checkout.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    }
                })
                .then(res => res.json())
                .then(data => {
                    if (data.status === 'success') {
                        checkoutTotal.textContent = 'Your total payment is $' + data.total.toFixed(2) + '. Proceeding with your order!';
                        checkoutPopup.style.display = 'flex';
                        if (data.total > 30) {
                            document.getElementById('rewardBanner').style.display = 'block';
                        }

                        document.querySelectorAll('.cart-item').forEach(item => item.remove());
                        updateSummary();
                    } else {
                        checkoutTotal.textContent = 'Error: ' + data.message;
                        checkoutPopup.style.display = 'flex';
                    }
                });
        });

        closeCheckoutPopup.addEventListener('click', () => {
            checkoutPopup.style.display = 'none';

        });

        function updateSummary() {
            let subtotal = 0;
            document.querySelectorAll('.cart-item').forEach(item => {
                const price = parseFloat(item.querySelector('.price').textContent.replace('$', ''));
                subtotal += price;
            });
            const tax = subtotal * 0.1;
            const total = subtotal + tax;

            document.getElementById('subtotal').textContent = '$' + subtotal.toFixed(2);
            document.getElementById('tax').textContent = '$' + tax.toFixed(2);
            document.getElementById('total').textContent = '$' + total.toFixed(2);
            const rewardBanner = document.getElementById('rewardBanner');
            if (total > 30) {
                rewardBanner.style.display = 'block';
            } else {
                rewardBanner.style.display = 'none';
            }
        }
    </script>

</body>

</html>