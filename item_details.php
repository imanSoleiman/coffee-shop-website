<?php
session_start();
require 'connection.php';
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
$itemId = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($itemId <= 0) {
    echo "<p style='text-align:center;margin-top:50px;'>Invalid item ID.</p>";
    include 'footer.php';
    exit;
}

// Fetch item
$stmt = $pdo->prepare("SELECT * FROM shop_items WHERE itemid = :id");
$stmt->execute([':id' => $itemId]);
$item = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$item) {
    echo "<p style='text-align:center;margin-top:50px;'>Item not found.</p>";
    include 'footer.php';
    exit;
}

$stmtFav = $pdo->prepare("SELECT 1 FROM favorites WHERE user_id = ? AND item_id = ?");
$stmtFav->execute([$user_id, $itemId]);
$isFavorite = $stmtFav->fetch() ? true : false;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($item['name']) ?> - Details</title>
    <script>
        const isLoggedIn = <?= isset($_SESSION['user_id']) && !empty($_SESSION['user_id']) ? 'true' : 'false' ?>;
    </script>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            margin: 0;
            font-family: 'Roboto', sans-serif;
            padding: 20px;
            background: #f5f5f5;
        }

        .item-container {
            max-width: 900px;
            margin: 0 auto;
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            padding: 30px;
            display: flex;
            gap: 40px;
            flex-wrap: wrap;
            position: relative;
            align-items: center;
        }

        main {
            padding-top: 100px;
            padding-bottom: 50px;
        }

        .item-left {
            flex: 1 1 300px;
        }

        .item-left h1 {
            font-size: 2rem;
            color: #0766AD;
            margin-bottom: 10px;
        }

        .item-left .price {
            font-size: 1.6rem;
            font-weight: 700;
            color: #e66f3c;
            margin-bottom: 15px;
        }

        .item-left p.description {
            color: #555;
            margin-bottom: 20px;
        }

        .sizes label {
            margin-right: 10px;
            cursor: pointer;
        }

        .sizes input[type=radio] {
            margin-right: 5px;
            accent-color: #ff4f27;
        }

        .add-to-cart {
            position: relative;
            top: 30px;
            padding: 12px 50px;
            background: #0766AD;
            color: #fff;
            border: none;
            border-radius: 10px;
            font-size: 1rem;
            cursor: pointer;
            margin-top: 10px;
        }

        .add-to-cart:hover {
            background: #054a7a;
        }

        .item-right {
            flex: 1 1 250px;
            text-align: center;
        }

        .item-right img {
            width: 100%;
            max-width: 300px;
            border-radius: 20px;
            margin-bottom: 20px;
            object-fit: cover;
        }

        .quantity {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-bottom: 20px;
        }

        .quantity button {
            width: 40px;
            height: 40px;
            border: none;
            background: #aaacad;
            color: #fff;
            font-size: 1.2rem;
            cursor: pointer;
            border-radius: 5px;
        }

        .quantity input {
            width: 60px;
            text-align: center;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 1rem;
            padding: 5px;
        }

        .heart {
            position: absolute;
            top: 20px;
            right: 25px;
            font-size: 2rem;
            color: #ccc;
            cursor: pointer;
            transition: color 0.3s, transform 0.3s;
        }

        .heart.active {
            color: #ff4d6d;
            transform: scale(1.2);
        }

        .cart-popup {
            width: 200px;
            background: #ff7300;
            color: #fff;
            padding: 15px 25px;
            border-radius: 50px;
            font-weight: 600;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            opacity: 0;
            transform: translateY(0);
            pointer-events: none;
            z-index: 10000;
            animation: none;
        }

        @keyframes floatUp {
            0% {
                opacity: 0;
                transform: translateY(0) scale(0.8);
            }

            10% {
                opacity: 1;
                transform: translateY(-10px) scale(1);
            }

            50% {
                opacity: 1;
                transform: translateY(-80px) scale(1.05);
            }

            100% {
                opacity: 0;
                transform: translateY(-150px) scale(1);
            }
        }


        @media(max-width:768px) {
            .item-container {
                flex-direction: column;
                align-items: center;
            }
        }
    </style>
</head>

<body>

    <?php include 'header.php'; ?>
    <main>

        <div id="cartPopup" class="cart-popup">
            <span>Added to cart!</span>
        </div>
        <div class="item-container">
            <div class="heart <?= $isFavorite ? 'active' : '' ?>" id="heart" data-item-id="<?= $item['itemid'] ?>">&#10084;</div>

            <div class="item-right">
                <img src="./image/<?= htmlspecialchars($item['image']) ?>" alt="<?= htmlspecialchars($item['name']) ?>">
                <div class="quantity">
                    <button type="button" id="minus">-</button>
                    <input type="number" id="quantity" value="1" min="1">
                    <button type="button" id="plus">+</button>
                </div>
            </div>

            <div class="item-left">
                <h1><?= htmlspecialchars($item['name']) ?></h1>
                <span class="price" id="price">$<?= number_format($item['price'], 2) ?></span>
                <p class="description"><?= htmlspecialchars($item['description']) ?></p>

                <div class="sizes">
                    <label><input type="radio" name="size" value="small" checked> Small (+$1)</label>
                    <label><input type="radio" name="size" value="medium"> Medium (+$2)</label>
                    <label><input type="radio" name="size" value="large"> Large (+$2)</label>
                </div>
                <a href="shop.php" class=" add-to-cart" data-id="<?= $item['itemid'] ?>">Add to Cart</a>
            </div>
        </div>


    </main>



    <?php include 'footer.php'; ?>

    <script>
        const basePrice = <?= $item['price'] ?>;
        const priceEl = document.getElementById('price');
        const quantityInput = document.getElementById('quantity');
        const sizeInputs = document.querySelectorAll('input[name="size"]');

        function updatePrice() {
            let sizeValue = document.querySelector('input[name="size"]:checked').value;
            let extra = (sizeValue === 'small') ? 1 : 2;
            let quantity = parseInt(quantityInput.value);
            priceEl.textContent = '$' + ((basePrice + extra) * quantity).toFixed(2);
        }

        sizeInputs.forEach(i => i.addEventListener('change', updatePrice));
        quantityInput.addEventListener('input', updatePrice);
        document.getElementById('minus').addEventListener('click', () => {
            if (quantityInput.value > 1) {
                quantityInput.value--;
                updatePrice();
            }
        });
        document.getElementById('plus').addEventListener('click', () => {
            quantityInput.value++;
            updatePrice();
        });

        // Heart / Favorite
        const heartBtn = document.getElementById('heart');
        heartBtn.addEventListener('click', () => {
            heartBtn.classList.toggle('active');
            const itemId = heartBtn.dataset.itemId;
            fetch('toggle_favorite.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    item_id: itemId
                })
            }).then(res => res.json()).then(data => {
                console.log(data);
            });
        });

        const addBtn = document.querySelector('.add-to-cart');
        const cartPopup = document.getElementById('cartPopup');

        addBtn.addEventListener('click', (e) => {
            e.preventDefault(); // prevent default link

            // Check if logged in
            if (!isLoggedIn) {
                alert("Please log in first to add items to your cart.");
                window.location.href = 'login.php'
                return;
            }

            const itemId = addBtn.dataset.id;
            const quantity = parseInt(quantityInput.value);
            const size = document.querySelector('input[name="size"]:checked').value;
            const price = parseFloat(priceEl.textContent.replace('$', ''));

            fetch('add_to_cart.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    item_id: itemId,
                    quantity,
                    price,
                    size
                })
            }).then(res => res.json()).then(data => {
                if (data.status === 'success') {
                    cartPopup.style.animation = 'floatUp 2s forwards';
                    cartPopup.addEventListener('animationend', () => {
                        cartPopup.style.animation = 'none';
                    }, {
                        once: true
                    });
                }
            });
        });
    </script>

</body>

</html>