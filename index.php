<?php
include("connection.php");

$stmtItems = $pdo->prepare("SELECT itemid, name, image FROM shop_items ORDER BY itemid DESC LIMIT 20");
$stmtItems->execute();
$items = $stmtItems->fetchAll(PDO::FETCH_ASSOC);
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Archivo+Black&family=Cabin:ital,wght@0,400..700;1,400..700&family=Edu+VIC+WA+NT+Hand:wght@400..700&family=Leckerli+One&family=Lexend+Deca:wght@100..900&family=Marck+Script&family=Merriweather:wght@600&family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Outfit:wght@100..900&family=Pacifico&family=Rubik:ital,wght@0,408;1,408&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Archivo+Black&family=Cabin:ital,wght@0,400..700;1,400..700&family=Edu+VIC+WA+NT+Hand:wght@400..700&family=Leckerli+One&family=Lexend+Deca:wght@100..900&family=Marck+Script&family=Merriweather:wght@600&family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Outfit:wght@100..900&family=Pacifico&family=Rubik:ital,wght@0,408;1,408&display=swap" rel="stylesheet">
    <title>Document</title>
</head>
<style>
    body {
        margin: 0;
        padding: 0;
    }

    #main {
        width: 100%;
        z-index: 1;
        height: auto;
    }

    #loader {
        position: absolute;
        width: 100%;
        height: 100vh;
        background-color: #0766AD;
        z-index: 9999;
    }

    .noscroll {
        overflow: hidden;
        height: 100vh;
        position: fixed;
        width: 100vw;
    }

    #loader #topheading {
        position: absolute;
        top: 30%;
        left: 50%;
        transform: translate(-50%, 0);
        text-align: center;
    }

    #topheading h5 {
        text-transform: uppercase;
        font-size: 10px;
        font-weight: 300;
        text-align: center;
        justify-content: center;
        color: white;

    }

    #loader h1 {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        font-size: 4vw;
        font-weight: 500;
        width: 100%;
        display: flex;
        color: white;
        font-family: "gilroy";
    }


    .reveal .parent {
        overflow-y: hidden;
        width: 100%;
        display: flex;
        justify-content: center;
        flex-wrap: wrap;
    }

    .reveal .parent .child {
        display: block;
        padding: 10px;

    }

    .parent .child span {
        display: inline-block;
    }

    #about {
        font-family: 'Archivo Black';
        color: #E36727;
        font-size: 60px;
    }

    #home {
        width: 100%;
        height: auto;
        background-color: white;
        padding-top: 200px;
    }

    .row {
        display: flex;
        align-items: center;
        padding: 0 5vw;
        padding-right: 10vw;
        line-height: 1;
        color: #333;
        justify-content: space-between;
        overflow-x: hidden;
    }

    .row h1 {
        font-size: 7vw;
        font-weight: 500;
    }

    .row #first {
        padding-top: 20px;

    }

    .font20 {
        font-family: "Edu VIC WA NT Hand";
        font-size: 15px;
    }


    .project-first-container {
        position: relative;
        width: 1500px;
        margin: auto;
        z-index: 2;
        height: 100%;


    }

    .p-container {
        position: absolute;
        bottom: 0;
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: space-evenly;
        margin: 0 20px;
    }

    .right-part {
        width: 38%;

        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        overflow: hidden;
    }

    .right-part img {
        width: 100%;
        height: 100%;
        object-fit: contain;
    }

    .left-part h1 {
        color: white;
        font-size: 2.9rem;
        text-transform: uppercase;
        overflow: hidden;
        text-shadow: 2px 2px 6px rgba(0, 0, 0, 0.45);


    }

    .left-part h1 span {
        display: inline-block;
        transform: translateY(100%);
    }



    .left-part p {
        color: white;
        font-size: 15px;
        margin: 10px 0px;

    }

    .left-part {
        margin-top: 50px;
        width: 40%;
    }

    .left-part a {
        width: 150px;
        height: 50px;
        margin-top: 10px;
        padding: 10px 20px;
        border-radius: 10px;
        display: inline-block;
        flex: 0 0 auto;
        text-transform: capitalize;
        font-size: 1rem;
        line-height: 1;
        color: #fff;
        border-radius: 8px;
        font-weight: 500;
        background-color: transparent;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        background-color: #ff6811ff;
        box-shadow: inset 0 0 0 0 black;
        transition: ease-in-out 0.5s;

    }

    .left-part a:hover {
        box-shadow: inset 300px 0 0 0 black;
        color: white;
    }

    .left-part.full-width {
        width: 100%;
        margin-bottom: 20px;
    }

    @media (max-width: 1400px) {
        .project-first-container {
            width: 1300px;
        }

        .left-part h1 {
            color: white;
            font-size: 2.5rem;
            text-transform: uppercase;

        }

    }

    @media (max-width: 1200px) {
        .project-first-container {
            max-width: 1000px;
        }

        .left-part {
            width: 50%;
        }

        .project-intro {
            height: 590px;
        }

    }

    @media (max-width: 992px) {
        .project-intro {
            padding-top: 120px;
        }

        .project-first-container {
            width: 800px;

        }

    }

    @media (max-width: 768px) {
        .p-container {

            position: relative;
            width: 90%;
            display: block;
            margin: 0 10px;
        }

        .project-first-container {
            width: 600px;
        }

        .left-part {
            width: 100%;
        }

        .right-part {
            width: 60%;
        }

        .left-part h1 {
            font-size: 32px;
        }

        .left-part p {
            font-size: 16px;
        }

        .left-part button {

            font-size: 14px;
        }


        .right-part {
            display: none;
        }



        .project-intro {
            background-image: url('./images/WhatsApp\ Image\ 2026-01-01\ at\ 11.14.11\ PM.jpeg') !important;
            width: 100%;
            height: 800px !important;
            position: relative;
            background-position: center center;
            background-size: cover;
            background-repeat: no-repeat;
            border-radius: 0px 0px 2px 20px;
            overflow: hidden;

        }
    }

    @media (max-width: 560px) {

        .left-part {
            width: 80%;
        }

        .right-part {
            width: 300px;
        }

        .left-part h1 {
            font-size: 25px;
        }

        .left-part p {
            font-size: 16px;
        }

        .left-part a {
            width: 120px;
            font-size: 12px;
            height: 40px;
        }
    }

    @media (max-width: 330px) {
        .right-part {
            width: 100%;
        }
    }

    .word {
        position: relative;
    }

    .line-mask {
        position: absolute;
        top: 0;
        right: 0;
        background-color: #0d0d0d;
        opacity: 0.8;
        height: 100%;
        width: 100%;
        z-index: 2;
    }

    .project-intro {
        background-image: url('./images/WhatsApp\ Image\ 2026-01-01\ at\ 11.02.14\ PM.jpeg');
        width: 100%;
        height: 800px !important;
        position: relative;
        background-position: center center;
        background-size: cover;
        background-repeat: no-repeat;
        border-radius: 0px 0px 2px 20px;
        overflow: hidden;

    }

    .item-joy-locations {
        position: relative;
        overflow: hidden;
        padding: 20px;
        padding-top: 150px;
        margin-bottom: 30px;

    }

    .item-joy-header {
        max-width: 1300px;
        margin: auto;
    }

    .item-header-container {
        display: flex;
        align-items: end;
        gap: 15px;
        justify-content: space-between;
    }

    .item-left {
        width: 55%;
        margin-right: 20px;
    }

    .item-left h3 {
        text-transform: uppercase;
        font-size: 70px;
        font-weight: 600;
        color: #000;
        letter-spacing: -2px;
        line-height: 0.9;
        margin-bottom: 0;

    }

    .item-left h6 {
        color: gary;
        font-size: 16px;
        font-family: "Roboto", sans-serif;
        font-weight: 500;
    }

    .right-joy {
        max-width: 500px;
        font-weight: 400;
        line-height: 28px;
        font-size: 18px;
        color: #000;
        margin-bottom: 0px;
    }

    .joy-slider-structure {
        margin: 50px -150px;
    }


    .joy-slider-wrapper {
        display: flex;
        position: relative;
        height: 100%;
        width: 100%;
        z-index: 1;
    }

    .news-slider-wrapper {
        display: flex;
        position: relative;
        height: 100%;
        width: 100%;
        z-index: 1;
    }

    .item-single-slider {
        height: 220px;
        flex-shrink: 0;
        width: 220px;
        cursor: grab;
        border-radius: 20%;
        box-shadow: 0 10px 25px rgba(75, 74, 73, 0.15);
        transition-property: transform;
        display: block;
        margin-right: 50px;
    }

    .item-single-container {
        height: 100%;
        width: 100%;
        border-radius: 16px;
        position: relative;
        z-index: 1;
        overflow: hidden;
        touch-action: pan-x;
        cursor: grab;
        -webkit-user-select: none;
        user-select: none;
    }

    .item-single-container img {
        height: 100%;
        width: 100%;
        padding: 10px;
        object-fit: cover;
        padding: 50px;
        max-width: 100%;
        vertical-align: middle;
        box-sizing: border-box;
    }

    .item-single-container h4 {
        position: absolute;
        bottom: 30px;
        text-align: center;
        left: 0;
        color: #ffa04cff;
        width: 100%;
        font-size: 15px;
        font-family: "Teko", sans-serif;
        padding: 0 10px;
        z-index: 1;
        text-transform: uppercase;
    }


    .about-us {
        width: 100%;
        padding: 100px 0;
        background-color: #f8f6f2;
    }

    .about-container {
        max-width: 1200px;
        margin: auto;
        display: flex;
        align-items: center;
        gap: 60px;
        padding: 0 20px;
    }

    .about-image {
        width: 50%;
        overflow: hidden;
        border-radius: 20px;
    }

    .about-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.6s ease;
    }

    .about-image:hover img {
        transform: scale(1.05);
    }

    .about-content {
        width: 50%;
    }

    .about-tag {
        display: inline-block;
        font-size: 13px;
        font-weight: 600;
        letter-spacing: 1px;
        color: #9c7a4b;
        margin-bottom: 15px;
        text-transform: uppercase;
    }

    .about-content h2 {
        font-size: 42px;
        font-weight: 600;
        color: #000000ff;
        margin-bottom: 20px;
    }

    .about-content p {
        font-size: 17px;
        line-height: 1.7;
        color: #555;
        margin-bottom: 18px;
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

    /* RESPONSIVE */
    @media (max-width: 900px) {
        .about-container {
            flex-direction: column;
        }

        .about-image,
        .about-content {
            width: 100%;
        }

        .about-content h2 {
            font-size: 32px;
        }
    }

    .free-gift-section {
        width: 100%;
        padding: 90px 0;
        background: white;
    }

    .free-gift-container {
        max-width: 1200px;
        margin: auto;
        padding: 0 20px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 60px;
    }

    .free-gift-content {
        width: 55%;
    }

    .gift-tag {
        display: inline-block;
        font-size: 13px;
        font-weight: 600;
        letter-spacing: 1px;
        color: #9c7a4b;
        margin-bottom: 15px;
        text-transform: uppercase;
    }

    .free-gift-content h2 {
        font-size: 42px;
        color: #2e2e2e;
        margin-bottom: 20px;
    }

    .free-gift-content p {
        font-size: 17px;
        line-height: 1.7;
        color: #555;
        margin-bottom: 25px;
    }

    .gift-rules {
        list-style: none;
        padding: 0;
        margin-bottom: 30px;
    }

    .gift-rules li {
        font-size: 16px;
        color: #444;
        margin-bottom: 10px;
    }

    .gift-btn {
        display: inline-block;
        padding: 15px 38px;
        border-radius: 30px;
        background-color: #0766AD;
        color: #fff;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.35s ease;
    }

    .gift-btn:hover {
        background-color: #054d84;
        transform: translateY(-3px);
        box-shadow: 0 12px 25px rgba(0, 0, 0, 0.15);
    }

    .free-gift-image {
        width: 45%;
    }

    .free-gift-image img {
        width: 100%;
        max-width: 420px;
        display: block;
    }

    @media (max-width: 900px) {
        .free-gift-container {
            flex-direction: column;
            text-align: center;
        }

        .free-gift-content,
        .free-gift-image {
            width: 100%;
        }

        .free-gift-content h2 {
            font-size: 32px;
        }
    }
</style>

<body>
    <?php include 'header.php' ?>
    <div id=main>
        <div id="loader">
            <div id="topheading">

            </div>
            <h1 class="reveal"><span id="about">JOY </span> <span class="font20"> BEIRUT</span> </h1>
        </div>
    </div>
    <section class="project-intro" id="home">

        <div class="project-first-container">
            <div class="p-container">

                <div class="left-part">
                    <div class="heading">
                        <h1><span class="create">Deleicious Coffee</span></h1>
                        <h1><span class="create">and desserts</span></h1>
                        <h1><span class="create">made </span></h1>
                        <h1><span class="create">To brighten your day </span></h1>
                    </div>

                    <p>At Joy Coffee Beirut, enjoy exceptional coffee, delicious desserts and cakes, beautiful flowers, and stylish hoodies."</p>
                    <a id="scrollBtn">shop now </a>
                </div>

                <div class="right-part">
                    <img src="./images/PNG image.png" alt="Project Right Image">
                </div>

            </div>
        </div>
    </section>



    <div class="item-joy-locations">
        <div class="item-joy-header">
            <div class="item-header-container">
                <div class="item-left">
                    <h6> shop now </h6>
                    <h3 class="highlight-letters red">discover our Latest items </h3>
                </div>
                <p class="right-joy">
                    Discover our thoughtfully curated selection of items, where every detail is chosen with care. From delicious coffee and handcrafted desserts to elegant flowers, cakes, and stylish hoodies, each piece is designed to bring joy, quality, and beauty into your everyday moments.
                </p>
            </div>
        </div>

        <div class="joy-slider-structure">
            <div class="joy-slider-container">
                <div class="joy-slider-wrapper">
                    <?php if ($items): ?>
                        <?php foreach ($items as $item): ?>
                            <div class="item-single-slider">
                                <div class="item-single-container">
                                    <img src="./image/<?= $item['image'] ?>" alt="<?= htmlspecialchars($item['name']) ?>">
                                    <h4><?= htmlspecialchars($item['name']) ?></h4>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>No items found.</p>
                    <?php endif; ?>
                </div>

            </div>

        </div>
        <a href="shop.php" class="about-btn">shop now</a>
    </div>
    <section class="about-us">
        <div class="about-container">
            <div class="about-image">
                <img src="./images/515033693_17896099014254010_2020368866982923931_n.jpg" alt="About Joy Beirut">
            </div>
            <div class="about-content">
                <span class="about-tag">About Us</span>
                <h2>More Than Coffee, It’s a Lifestyle</h2>
                <p>
                    Joy Beirut is a creative concept where passion meets quality. We bring together
                    premium coffee, handcrafted desserts, elegant flowers, delicious cakes, and
                    thoughtfully designed lifestyle items — all under one roof.
                </p>
                <p>
                    Every detail is carefully selected to create moments of comfort, beauty, and joy.
                    Whether you’re here for a cup of coffee or a meaningful gift, Joy Beirut is where
                    everyday experiences feel special.
                </p>

                <a href="./structure.php" class="about-btn">Discover More</a>
            </div>

        </div>
    </section>

    <section class="free-gift-section">
        <div class="free-gift-container">

            <div class="free-gift-content">
                <span class="gift-tag">Special Offer</span>
                <h2>Get a Free Gift on Your Order</h2>
                <p>
                    As a thank you for being part of Joy Beirut, logged-in customers
                    receive a complimentary gift with every order of <strong>$30 or more</strong>.
                    Discover our curated items and enjoy something extra on us.
                </p>

                <ul class="gift-rules">
                    <li>✔ Login to your account</li>
                    <li>✔ Spend $30 or more</li>
                    <li>✔ Receive a free surprise gift</li>
                </ul>

                <a href="./login.php" class="gift-btn">Login & Discover</a>
            </div>

            <div class="free-gift-image">
                <img src="./images/547206093_17904338919254010_3702293719692060981_n (1).jpg" alt="Free Gift">
            </div>

        </div>
    </section>


    <?php include("footer.php") ?>
</body>

<script src=" https://cdnjs.cloudflare.com/ajax/libs/gsap/3.13.0/gsap.min.js" integrity="sha512-NcZdtrT77bJr4STcmsGAESr06BYGE8woZdSdEgqnpyqac7sugNO+Tr4bGwGF3MsnEkGKhU2KL2xh6Ec+BqsaHA==" crossorigin="anonymous" referrerpolicy="no-referrer">
</script>
<script
    src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.1/gsap.min.js"
    integrity="sha512-qF6akR/fsZAB4Co1QDDnUXWnaQseLGXoniuSuSlPQK6+aWhlMZcHzkasCSlnWoe+TJuudlka1/IQ01Dnhgq95g=="
    crossorigin="anonymous"
    referrerpolicy="no-referrer"></script>
<script
    src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.1/ScrollTrigger.min.js"
    integrity="sha512-IHDCHrefnBT3vOCsvdkMvJF/MCPz/nBauQLzJkupa4Gn4tYg5a6VGyzIrjo6QAUy3We5HFOZUlkUpP0dkgE60A=="
    crossorigin="anonymous"
    referrerpolicy="no-referrer"></script>
<script>
    //animate loading pagge 
    window.addEventListener("load", function() {
        function revealToSpan() {
            document.querySelectorAll(".reveal").forEach(function(elem) {
                var parent = document.createElement("span");
                var child = document.createElement("span");

                parent.classList.add("parent");
                child.classList.add("child");

                child.innerHTML = elem.innerHTML;
                parent.appendChild(child);

                elem.innerHTML = "";
                elem.appendChild(parent);
            });
        }

        function valueSetters() {
            gsap.set("#home .parent .child", {
                y: "100%"
            });
            gsap.set(".right-part img", {
                x: 200,
                opacity: 0
            });
        }

        function loaderAnimation() {
            document.body.classList.add('noscroll');

            const tl = gsap.timeline({
                onComplete: animateHomepage
            });

            tl.from("#loader .child span", {
                    x: 100,
                    duration: 2,
                    stagger: 0.2,
                    ease: "power3.inOut"
                })
                .to("#loader .parent .child", {
                    y: "-110%",
                    duration: 1,
                    ease: "circ.inOut"
                })
                .to("#loader", {
                    height: 0,
                    duration: 1,
                    ease: "circ.inOut"
                })
                .set("#loader", {
                    display: "none"
                })
                .add(() => document.body.classList.remove('noscroll'));
        }

        function animateHomepage() {
            const tl = gsap.timeline();
            tl.to(".left-part .create", {
                y: "0%",
                duration: 0.6,
                stagger: 0.2,
                ease: "power3.out"
            });

            tl.to(".right-part img", {
                x: 0,
                opacity: 1,
                duration: 1.5,
                ease: "power3.out"
            }, "-=1");
        }
        revealToSpan();
        valueSetters();
        loaderAnimation();

    });

    //animate slider 
    const wrapper = document.querySelector(".joy-slider-wrapper");
    const slides = gsap.utils.toArray(".item-single-slider");
    const slideCount = slides.length;
    const slideWidth = slides[0].offsetWidth + 50; // width + gap
    wrapper.innerHTML += wrapper.innerHTML;
    const allSlides = gsap.utils.toArray(".item-single-slider");
    let sliderIndex = 0;
    let autoSlide;

    function nextSlide() {
        sliderIndex++;
        gsap.to(wrapper, {
            x: -slideWidth * sliderIndex,
            duration: 0.8,
            ease: "power2.inOut",
            onComplete: () => {
                if (sliderIndex >= slideCount) {
                    sliderIndex = 0;
                    gsap.set(wrapper, {
                        x: 0
                    });
                }
            }
        });
    }

    function startAutoSlide() {
        clearInterval(autoSlide);
        autoSlide = setInterval(nextSlide, 3000);
    }
    startAutoSlide();
    Draggable.create(wrapper, {
        type: "x",
        inertia: true,
        edgeResistance: 0.9,
        bounds: {
            minX: -slideWidth * slideCount,
            maxX: 0
        },
        onRelease() {
            sliderIndex = Math.round(-this.x / slideWidth) % slideCount;
            if (sliderIndex < 0) sliderIndex += slideCount; // handle negative index
            gsap.to(wrapper, {
                x: -slideWidth * sliderIndex,
                duration: 0.5,
                ease: "power2.out"
            });
        }
    });

    gsap.registerPlugin(ScrollTrigger);
    gsap.to(".logo-image", {
        y: "0%", // slide into original position
        opacity: 1,
        duration: 1,
        scrollTrigger: {
            trigger: ".footer-container-first", // start when this container is near viewport
            start: "top 80%", // adjust scroll start
            end: "top 60%",
            scrub: true // smooth scroll animation
        }
    });
</script>


</html>