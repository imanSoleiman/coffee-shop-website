<?php
session_start();
include("connection.php");

$user_id = $_SESSION['user_id'] ?? 0;

$selectedCategory = $_GET['category'] ?? null;
$selectedSubcategory = $_GET['subcategory'] ?? null;

$stmtCat = $pdo->query("SELECT id, namecat, image FROM maincategories ORDER BY namecat ASC");
$categories = $stmtCat->fetchAll(PDO::FETCH_ASSOC);

$subcategories = [];
if ($selectedCategory) {
    $stmtSub = $pdo->prepare("SELECT id, namsub FROM subcategories WHERE mainid = :catid ORDER BY namsub ASC");
    $stmtSub->execute([':catid' => $selectedCategory]);
    $subcategories = $stmtSub->fetchAll(PDO::FETCH_ASSOC);
}

$sql = "SELECT si.itemid, si.name, si.price, si.image, si.description,
               mc.namecat AS category, sc.namsub AS subcategory
        FROM shop_items si
        LEFT JOIN maincategories mc ON si.categoryid = mc.id
        LEFT JOIN subcategories sc ON si.subcategoryid = sc.id";
$params = [];
if ($selectedCategory) {
    $sql .= " WHERE si.categoryid = :catid";
    $params[':catid'] = $selectedCategory;
    if ($selectedSubcategory) {
        $sql .= " AND si.subcategoryid = :subid";
        $params[':subid'] = $selectedSubcategory;
    }
}
$sql .= " ORDER BY si.itemid DESC";

$stmtItems = $pdo->prepare($sql);
$stmtItems->execute($params);
$items = $stmtItems->fetchAll(PDO::FETCH_ASSOC);

$favIds = [];
if ($user_id) {
    $stmtFav = $pdo->prepare("SELECT item_id FROM favorites WHERE user_id = ?");
    $stmtFav->execute([$user_id]);
    $favIds = $stmtFav->fetchAll(PDO::FETCH_COLUMN);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shop Page</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            margin: 0;
            font-family: 'Roboto', sans-serif;
        }

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

        @media (max-width: 600px) {
            .menu-image {
                padding: 30px 10px;
            }

            .menu-image h1 {
                font-size: 1.5rem;
            }
        }

        .categories {
            padding: 0 20px 30px 20px;
            display: flex;
            justify-content: center;
            gap: 25px;
            flex-wrap: wrap;
        }

        .category-card {
            display: flex;
            flex-direction: column;
            align-items: center;
            cursor: pointer;
            padding: 5px;
            border-radius: 15px;
            background-color: #fff;
            transition: transform 0.3s ease;
        }

        .category-card img {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            object-fit: cover;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, filter 0.3s ease, border 0.3s ease;
            border: 2px solid transparent;
        }

        .category-card h3 {
            margin: 10px 0 0 0;
            font-size: 0.95rem;
            color: #555;
            font-weight: 700;
            text-align: center;
            transition: color 0.3s ease;
        }

        .category-card:hover img {
            transform: scale(1.1);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
        }

        .category-card.selected img {
            filter: grayscale(0%);
            border: 3px solid orange;
        }

        .category-card.selected h3 {
            color: #0766AD;
        }

        .subcategories {
            display: flex;
            justify-content: center;
            gap: 15px;
            flex-wrap: wrap;
            margin: 10px 0 30px 0;
        }

        .subcat {
            padding: 8px 15px;
            background-color: #0766AD;
            color: white;
            border-radius: 20px;
            font-size: 0.85rem;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        .subcat:hover {
            background-color: #054a7a;
        }

        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 20px;
            padding: 0 20px 50px 20px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .product-card {
            position: relative;
            background-color: #fff;
            border-radius: 15px;
            overflow: hidden;
            cursor: pointer;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1),
                0 8px 20px rgba(0, 0, 0, 0.05);
        }

        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
        }

        .product-card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        /* Heart icon */
        .heart {
            position: absolute;
            top: 10px;
            right: 10px;
            background-color: rgba(255, 255, 255, 0.8);
            border-radius: 50%;
            padding: 5px;
            font-size: 1.2rem;
            color: red;
            z-index: 2;
            transition: background 0.3s ease;
        }

        .heart:hover {
            background-color: rgba(255, 255, 255, 1);
        }

        /* Hover overlay */
        .product-card .overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            backdrop-filter: blur(2px);
            background-color: rgba(0, 0, 0, 0.2);
            opacity: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            transition: opacity 0.3s ease;
        }

        .product-card:hover .overlay {
            opacity: 1;
        }

        .overlay a {
            color: #fff;
            font-size: 2rem;
            background-color: rgba(7, 102, 173, 0.8);
            padding: 10px 15px;
            border-radius: 50%;
            text-decoration: none;
            transition: background 0.3s ease;
        }

        .overlay a:hover {
            background-color: #054a7a;
        }

        .product-info {
            padding: 15px;
        }

        .product-info h2 {
            font-size: 1rem;
            margin: 5px 0;
            color: #0766AD;
            font-weight: 700;
        }

        .product-info p {
            font-size: 0.9rem;
            color: #555;
            margin: 5px 0;
        }

        .product-info span {
            font-size: 1rem;
            font-weight: 700;
            color: #333;
        }

        .about-btn {
            display: inline-block;
            margin-top: 20px;
            padding: 14px 36px;
            border-radius: 30px;
            background-color: #f3e7d3;
            color: #5a4633;
            font-weight: 600;
            text-decoration: none;
            border: 1px solid #e2d2ba;
            transition: all 0.35s ease;
        }


        .about-btn:hover {
            color: white;
            background-color: #ff5627ff;
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.12);
        }

        @media (max-width: 600px) {
            .category-card img {
                width: 60px;
                height: 60px;
            }

            .category-card h3 {
                font-size: 0.85rem;
            }

            .hero-banner {
                height: 180px;
            }

            .hero-text h1 {
                font-size: 1.4rem;
            }

            .hero-text p {
                font-size: 0.9rem;
            }
        }
    </style>
</head>

<body>
    <?php include("header.php"); ?>
    <div class="menu-image">
        <h1>Our Menu</h1>
    </div>

    <div class="categories">
        <?php foreach ($categories as $cat): ?>
            <div class="category-card <?= ($selectedCategory == $cat['id']) ? 'selected' : '' ?>"
                onclick="window.location='?category=<?= $cat['id'] ?>'">
                <img src="./image/<?= $cat['image'] ?>" alt="<?= htmlspecialchars($cat['namecat']) ?>">
                <h3><?= htmlspecialchars($cat['namecat']) ?></h3>
            </div>
        <?php endforeach; ?>
    </div>


    <?php if (!empty($subcategories)): ?>
        <div class="subcategories">
            <div class="subcat about-btn  <?= (!$selectedSubcategory) ? 'selected' : '' ?>" onclick="window.location='?category=<?= $selectedCategory ?>'">All</div>
            <?php foreach ($subcategories as $sub): ?>
                <div class="subcat about-btn <?= ($selectedSubcategory == $sub['id']) ? 'selected' : '' ?>" onclick="window.location='?category=<?= $selectedCategory ?>&subcategory=<?= $sub['id'] ?>'">
                    <?= htmlspecialchars($sub['namsub']) ?>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <div class="products-grid">
        <?php if ($items): ?>
            <?php foreach ($items as $item): ?>
                <div class="product-card" data-item-id="<?= $item['itemid'] ?>">

                    <?php if (in_array($item['itemid'], $favIds)): ?>
                        <!-- Show heart only if item is favorited -->
                        <div class="heart">&#10084;</div>
                    <?php endif; ?>

                    <img src="./image/<?= $item['image'] ?>" alt="<?= htmlspecialchars($item['name']) ?>">
                    <div class="overlay">
                        <a href="item_details.php?id=<?= $item['itemid'] ?>">&#10132;</a>
                    </div>
                    <div class="product-info">
                        <h2><?= htmlspecialchars($item['name']) ?></h2>
                        <p>
                            <?php
                            $words = explode(' ', $item['description']);
                            if (count($words) > 6) {
                                $shortDesc = implode(' ', array_slice($words, 0, 6)) . '...';
                            } else {
                                $shortDesc = $item['description'];
                            }
                            echo htmlspecialchars($shortDesc);
                            ?>
                        </p>
                        <span>$<?= number_format($item['price'], 2) ?></span>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p style="text-align:center; font-size:1.2rem;">No items found.</p>
        <?php endif; ?>
    </div>


    <?php include("footer.php"); ?>
</body>

</html>