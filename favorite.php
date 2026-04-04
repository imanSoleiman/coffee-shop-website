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
    SELECT f.favorite_id AS fav_id, i.itemid, i.name, i.price, i.image
    FROM favorites f
    JOIN shop_items i ON f.item_id = i.itemid
    WHERE f.user_id = ?
");
$stmt->execute([$user_id]);
$favorites = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>My Favorites</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            margin: 0;

        }

        h1 {
            background: #f5f5f5;
            text-align: start;
            color: #0766AD;
            margin-bottom: 30px;

            padding: 50px 50px;
            padding-top: 100px;
        }

        .favorites-grid {
            padding: 40px;
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
            gap: 20px;
            max-width: 1200px;
            margin-bottom: 50px;
        }

        .fav-item {
            background: #fff;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            position: relative;
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .fav-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.15);
        }

        .fav-item img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }

        .fav-item .details {
            padding: 15px;
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .fav-item .details h2 {
            margin: 0;
            font-size: 1.2rem;
            color: #333;
        }

        .fav-item .details .price {
            font-weight: 700;
            color: #e66f3c;
            font-size: 1rem;
        }

        .heart {
            position: absolute;
            top: 10px;
            right: 10px;
            font-size: 1.8rem;
            color: #ff4d6d;
            cursor: pointer;
            transition: transform 0.3s, color 0.3s, opacity 0.3s;
        }

        .heart.removed {
            color: #ccc;
            transform: scale(0);
            opacity: 0;
        }

        @media(max-width:768px) {
            .favorites-grid {
                grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
            }

            .fav-item img {
                height: 150px;
            }
        }
    </style>
</head>

<body>

    <?php include 'header.php'; ?>

    <h1>My Favorites</h1>

    <?php if (count($favorites) === 0): ?>
        <p style="text-align:center; font-size:1.2rem; color:#555;">You have no favorite items yet.</p>
    <?php else: ?>
        <div class="favorites-grid">
            <?php foreach ($favorites as $item): ?>
                <div class="fav-item" data-item-id="<?= $item['itemid'] ?>">
                    <div class="heart" title="Remove from favorites">&#10084;</div>
                    <img src="./image/<?= htmlspecialchars($item['image']) ?>" alt="<?= htmlspecialchars($item['name']) ?>">
                    <div class="details">
                        <h2><?= htmlspecialchars($item['name']) ?></h2>
                        <span class="price">$<?= number_format($item['price'], 2) ?></span>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <?php include 'footer.php'; ?>

    <script>
        const hearts = document.querySelectorAll('.fav-item .heart');

        hearts.forEach(heart => {
            heart.addEventListener('click', () => {
                const favItem = heart.closest('.fav-item');
                const itemId = favItem.dataset.itemId;

                fetch('remove_favorite.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            item_id: itemId
                        })
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.status === 'removed') {
                            heart.classList.add('removed');
                            setTimeout(() => {
                                favItem.remove();
                                if (document.querySelectorAll('.fav-item').length === 0) {
                                    document.querySelector('.favorites-grid').innerHTML =
                                        '<p style="text-align:center; font-size:1.2rem; color:#555;">You have no favorite items yet.</p>';
                                }
                            }, 300);
                        } else {
                            alert('Failed to remove favorite');
                        }
                    });
            });
        });
    </script>

</body>

</html>