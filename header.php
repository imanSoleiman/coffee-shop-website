<?php
require 'connection.php';

$profileImage = "default.png";
$cartCount = 0;
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $stmt = $pdo->prepare("SELECT profile_image FROM users WHERE userid = ?");
    $stmt->execute([$user_id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    $stmt = $pdo->prepare("SELECT SUM(quantity) as total_items FROM cart WHERE user_id = ?");
    $stmt->execute([$user_id]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $cartCount = $row['total_items'] ? $row['total_items'] : 0;
    if ($user && !empty($user['profile_image'])) {
        $profileImage = $user['profile_image'];
    }
} ?>

<Style>
    * {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
        font-family: "Roboto", sans-serif;
    }

    .navbar {
        background: white;
        height: auto;
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 1rem;
        z-index: 10000;
        width: 100%;
        position: fixed;

    }

    .navbar_menu {
        gap: 20px;
        display: flex;
        align-items: center;
        text-align: center;
        list-style: none;

    }


    .navbar_links {
        color: #000966ff;
        display: flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        padding: 0 15px;
        height: 100%;
        font-size: 16px;
        position: relative;
        cursor: pointer;
        transition: ease-in-out 0.3s;
        font-size: 16px;
        font-weight: 500;

    }


    .navbar_links:hover {
        color: #ea6118ff;
        transition: all 0.3s ease;
        transform: translateY(3px);
    }


    .header-container {
        width: 100%;
        position: fixed;
        height: 110px;
        z-index: 999;
        margin: 10px auto;
        padding: 0px 5%;
        transition: transform 0.4s ease, opacity 0.4s ease;

    }

    .header-container-wrapper {
        display: flex;
        flex-direction: column;
        width: 100%;
        align-items: center;


    }

    .original-nav-logo {
        width: 200px;
        height: 100px;

    }

    .original-nav-logo img {
        max-width: 100%;
        height: 100%;

    }

    .original-nav {
        border-radius: 10px;
        background-color: rgba(255, 255, 255, 0.73);
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
        width: 100%;
    }

    .original-nav-container {
        border-radius: 0 0 20px 20px;
        display: flex;
        justify-content: space-around;
        align-items: center;
        height: 70px;

    }

    .dots-grid {
        display: none;
        width: 80px;
        height: 100%;
        flex: 0 0 auto;
        transition: all 0.5s;
        border-radius: 0px 0px 10px 0px;
        cursor: pointer;
        transition: gap 0.2s ease-in-out;

    }

    .close-menu {
        display: none;
    }

    .dots-grid span {
        width: 5px;
        height: 5px;
        background: white;
        border-radius: 50%;
        display: none;
    }


    .dots-grid:hover {
        gap: 12px;
        background-color: rgba(52, 144, 243, 0.84);
    }

    .header-container.hidden {
        transform: translateY(-100%);
        opacity: 0;
    }


    .search-container {
        display: none;
    }

    .search-container form {
        display: flex;
        width: 100%;
        overflow: hidden;
        height: 70px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }



    .navbar-details {
        display: none;
    }

    .navbar-details-left,
    .navbar-details-right {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        justify-content: center;
        gap: 20px;
    }

    .nav-links {
        display: flex;

    }

    .flex {
        display: block;
    }

    .navbar-details-left p,
    .navbar-details-right p {
        font-size: 20px;
        color: #888888;
        margin-bottom: 14px;

    }

    .nav-info {
        display: flex;
        gap: 5px;
        justify-content: center;
    }

    .navbar-details-right a {
        text-decoration: none;
        color: black;
    }



    @media (max-width: 1300px) {
        .navbar_links {
            font-size: 14px;
        }

    }

    @media (max-width: 1250px) {
        .navbar_links {
            font-size: 13px;
        }

    }


    @media (max-width: 960px) {
        .top-nav {
            display: none;
        }

        .search-container {
            display: flex;
            justify-content: center;
            margin: 60px 0;
            width: 100%;

        }

        .original-nav-container {
            justify-content: space-between;
            padding: 0;
            height: 60px;


        }

        .original-nav {
            border-radius: 10px;
        }

        .flex {
            display: flex;
            justify-content: space-between;
            width: 100%;
        }

        .nav-links {
            position: fixed;
            top: 0%;
            right: -1000px;
            padding: 60px;
            border-radius: 0 0 10px 10px;
            gap: 20px;
            transition: right 0.4s ease;
            width: 90%;
            overflow: hidden;
            height: 100%;
            font-size: 20px;
            background-color: rgba(255, 255, 255, 0.88);
            backdrop-filter: blur(40px);
        }

        .navbar_menu {
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
            height: 100%;
            width: 100%;
            gap: 20px;
            overflow: auto;
        }

        .navbar_menu::-webkit-scrollbar {
            display: none;
        }

        .navbar_items {
            width: 100%;
            border-bottom: 1px solid #ddd;
        }

        .navbar_items a {
            width: 100%;
            font-size: 20px;
        }

        .navbar_links {
            padding: 15px;
            width: 100%;
            display: flex;
            justify-content: flex-start;
        }

        .navbar-details {
            display: flex;
            align-items: center;
            justify-content: space-between;
            width: 100%;
            margin: 30px 0px;
            padding: 30px 0px;
        }


        .dots-grid {
            background: #ff692dff;
            display: grid;
            grid-template-columns: auto auto auto;
            grid-template-rows: auto;
            align-content: center;
            justify-content: center;
            gap: 5px;

            border-radius: 0 10px 10px 0px;
            width: 60px;
        }

        .dots-grid span {
            display: inline-block;
        }

        .nav-links.active {
            display: block;
            right: 0;

        }

        .close-menu {
            display: flex;
            flex: 0 0 auto;
            width: 56px;
            height: 56px;
            background: #e5c9c9;
            justify-content: center;
            align-items: center;
            font-size: 26px;
            position: absolute;
            right: 16px;
            top: 16px;
            transition: all 0.3s ease-in-out;
        }


        .navbar_items {
            height: auto;
        }

    }


    @media (max-width: 520px) {
        .nav-links {
            width: 100% !important;
            padding: 30px;

        }

        .navbar-details {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            gap: 20px;

        }


    }

    .navbar_links i {
        margin-right: 8px;
        font-size: 18px;
    }


    .cart-icon {
        position: relative;
        width: 45px;
        height: 45px;
        border-radius: 50%;
        background-color: #f5e6d3;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
    }

    .cart-icon img {
        width: 22px;
        height: 22px;
        transition: transform 0.3s ease;
    }

    .cart-icon:hover {
        background-color: #ff692dff;
        transform: translateY(-3px);
    }

    .cart-icon:hover img {
        transform: scale(1.1);
    }


    .cart-count {
        position: absolute;
        top: -6px;
        right: -6px;
        background-color: #ff692dff;
        color: #fff;
        font-size: 11px;
        font-weight: 700;
        width: 20px;
        height: 20px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.25);
    }


    .navbar_button {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        padding: 12px 25px;
        border-radius: 30px;
        background-color: #f5e6d3;
        /* beige */
        color: #0766AD;

        font-weight: 600;
        text-decoration: none;
        overflow: hidden;
        transition: all 0.4s ease;
        font-family: 'Roboto', sans-serif;
        position: relative;
    }


    .navbar_button:hover {
        background-color: #ff692dff;
        color: white;
    }

    .arrow {
        display: inline-block;
        width: 10px;
        height: 10px;
        display: none;
        transform: translateY(-10px);
        transition: all 0.4s ease;
    }

    .navbar_button:hover .arrow {
        display: block;
        transition: all 0.4s ease;
        transform: translateY(0);

    }

    .profile-link i {
        font-size: 18px;
        margin-right: 6px;
    }

    .profile-avatar {
        display: flex;
        align-items: center;
        gap: 10px;
        text-decoration: none;
        color: #000966ff;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .profile-avatar img {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid #ddd;
        transition: all 0.3s ease;
    }

    .profile-avatar:hover img {
        border-color: #ff692dff;
    }

    .profile-avatar:hover {
        color: #ff692dff;
    }
</Style>

<nav>
    <div class="header-container">
        <div class="header-container-wrapper">
            <div class="original-nav">
                <div class="original-nav-container">

                    <div class="nav-links">
                        <div class="close-menu"><i class="fa-solid fa-xmark"></i></div>
                        <ul class="navbar_menu">
                            <li class="navbar_items"><a href="index.php" class="navbar_links">Home</a></li>
                            <li class="navbar_items"><a href="about_us.php" class="navbar_links">about us</a></li>
                            <li class="navbar_items">
                                <a href="shop.php" class="navbar_button">
                                    Shop Now
                                    <img src="./images/right-arrow.png" class="arrow" />
                                </a>
                            </li>
                        </ul>
                    </div>

                    <div class="original-nav-logo">
                        <a href="index.php">
                            <img src="./images/Joy.png" alt="joy logo" />
                        </a>
                    </div>

                    <div class="nav-links">
                        <ul class="navbar_menu">
                            <li class="navbar_items">
                                <a href="cart.php" class="navbar_links cart-icon">
                                    <img src="./images/shopping-cart (3).png" alt="Cart">
                                    <?php if ($cartCount > 0): ?>
                                        <span class="cart-count"><?= $cartCount ?></span>
                                    <?php endif; ?>
                                </a>
                            </li>


                            <a class="profile-avatar" href="<?php echo isset($_SESSION['user_id']) ? 'profile.php' : 'login.php'; ?>">
                                <img src="./image/<?php echo htmlspecialchars($profileImage); ?>" alt="Profile">
                            </a>

                        </ul>
                    </div>


                    <div class="dots-grid">
                        <span></span><span></span><span></span>
                        <span></span><span></span><span></span>
                        <span></span><span></span><span></span>
                    </div>

                </div>
            </div>
        </div>
    </div>
</nav>

<script>
    const dotsGrid = document.querySelector('.dots-grid');
    const navLinks = document.querySelector('.nav-links');
    const topNav = document.querySelector(".header-container");
    let lastScroll = 0;

    dotsGrid.addEventListener('click', () => {
        navLinks.classList.toggle('active');
        if (navLinks.classList.contains('active')) {
            document.body.style.overflow = 'hidden';
        } else {
            document.body.style.overflow = '';
        }
    });

    window.addEventListener("scroll", () => {
        const currentScroll = window.pageYOffset;
        if (!navLinks.classList.contains('active')) {
            if (currentScroll > lastScroll && currentScroll > 150) {
                topNav.classList.add("hidden");
            } else {
                topNav.classList.remove("hidden");
            }
        }

        lastScroll = currentScroll;
    });

    const nav = document.querySelector('.nav-links');
    const closeBtn = document.querySelector('.close-menu');
    const dots = document.querySelector('.dots-grid');
    dots.addEventListener('click', () => {
        nav.classList.add('active');
    });
    closeBtn.addEventListener('click', () => {
        nav.classList.remove('active');
    });
</script>