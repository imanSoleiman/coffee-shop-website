<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Joy – Who We Are</title>
    <link rel="stylesheet" href="joy.css">
</head>
<style>
    :root {
        --orange: #F47C20;
        --blue: #1E4DB7;
        --beige: #ffffffff;
        --dark: #1A1A1A;
        --gray: #6B6B6B;
        --light-gray: #E6E6E6;
    }

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: "Inter", Arial, sans-serif;
    }

    body {
        background-color: var(--beige);
        color: var(--dark);
        line-height: 1.6;
    }

    #home {
        padding-top: 120px;
        text-align: center;
    }

    .row {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 12px;
    }

    #first {
        font-size: clamp(32px, 4vw, 56px);
        font-weight: 600;
        color: var(--blue);
    }

    #special {
        font-size: clamp(42px, 6vw, 96px);
        font-weight: 700;
        color: var(--orange);
    }

    #home h1:last-child {
        color: var(--blue);
    }

    #home img {
        width: 32px;
        opacity: 0.8;
    }

    .who-we-are-section {
        max-width: 100%;
        background-color: #f4ede0ff;
        ;
        padding: 100px 50px;
    }

    .who-we-are-header {
        max-width: 900px;
        padding-bottom: 30px;
    }

    .who-we-are-header h4 {
        font-size: 14px;
        letter-spacing: 1px;
        text-transform: uppercase;
        color: var(--orange);
        margin-bottom: 10px;
    }

    .who-we-are-header h2 {
        font-size: clamp(32px, 4vw, 48px);
        font-weight: 600;
        color: var(--blue);
    }

    .line {
        width: 80px;
        height: 3px;
        background: var(--orange);
        margin: 30px 0 50px;
    }

    .about-us {
        padding: 0 20px;
    }

    #imagery {
        display: flex;
        gap: 60px;
        align-items: center;
    }

    #imagelef {
        flex: 1;
    }

    #imagelef h3 {
        font-weight: 400;
        font-size: 18px;
        color: var(--gray);
        max-width: 520px;
    }

    #imgrig {
        flex: 1;
        position: relative;
        height: 360px;
    }

    .imgcntr {
        width: 230px;
        height: 320px;
        background-size: cover;
        background-position: center;
        position: absolute;
        border-radius: 16px;
        box-shadow: 0 25px 50px rgba(30, 77, 183, 0.2);
    }

    .imgcntr:nth-child(1) {
        top: 0;
        left: 40px;
        transform: rotate(-6deg);
    }

    .imgcntr:nth-child(2) {
        top: 40px;
        left: 300px;
        transform: rotate(-10deg);
    }

    .our-story {
        padding: 100px 20px;
    }

    .our-story-header {
        max-width: 900px;
        margin: auto;
        text-align: center;
        margin-bottom: 60px;
    }

    .class-header-container p {
        color: var(--orange);
        letter-spacing: 1px;
        text-transform: uppercase;
        font-size: 14px;
        margin-bottom: 10px;
    }

    .class-header-container h2 {
        font-size: clamp(40px, 6vw, 80px);
        font-weight: 700;
        color: var(--blue);
        margin-bottom: 30px;
    }

    .our-story-par {
        font-size: 18px;
        color: var(--gray);
    }

    .our-story-cardContent {
        display: grid;
        grid-template-columns: 1fr 1fr;
        background: #ffffff;
        align-items: center;
        justify-content: center;
        padding: 40px;
        width: 70%;
        gap: 30px;
        margin-bottom: 50px;
        box-shadow: 0 20px 50px rgba(0, 0, 0, 0.06);
    }

    .image-left-story {
        height: 320px;
        overflow: hidden;
        border-radius: 14px;
    }

    .image-left-story img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .our-story-singleCard {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .our-story-left {
        display: flex;
        flex-direction: column;
        justify-content: center;
        gap: 12px;
    }

    .image-heading {
        font-size: 36px;
        font-weight: 600;
        color: var(--blue);
    }

    .our-story-left p {
        font-size: 17px;
        color: var(--gray);
    }

    .card-number {
        color: var(--orange);
        font-weight: 600;
    }

    #vision {
        position: relative;
        height: 80vh;
        background: linear-gradient(135deg, var(--blue), #162f73);
        color: #fff;
        overflow: hidden;
    }

    #top,
    #bottom {
        position: absolute;
        width: 100%;
        text-align: center;
    }

    #top {
        top: -30px;
    }

    #bottom {
        bottom: -30px;
    }

    #top-h1,
    #bottom-h1 {
        font-size: 16vw;
        opacity: 0.08;
    }

    #top-h1 span,
    #bottom-h1 span {
        color: var(--orange);
    }

    .content {
        height: 100%;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        text-align: center;
        padding: 20px;
    }

    .content h4 {
        color: var(--orange);
        letter-spacing: 2px;
        text-transform: uppercase;
        margin-bottom: 16px;
    }

    .content h3 {
        max-width: 600px;
        font-size: clamp(18px, 2.5vw, 24px);
        font-weight: 400;
    }
</style>

<body>
    <?php include("header.php"); ?>
    <div id="home">
        <div class="row" id="abouthead">
            <h1 id="first">Joy Coffee & Flowers</h1>
        </div>

        <div class="row">
            <img src="images/down-arrow.svg" alt="">
            <h1 id="special">Delivering</h1>
            <h1>Happiness</h1>
        </div>
    </div>
    <div class="who-we-are-section">
        <div class="who-we-are-header">
            <h4 class="highlight-letters">Who We Are</h4>
            <h2 class="highlight-letters">A Place for Joy</h2>
        </div>

        <div class="line"></div>

        <div class="about-us">
            <div id="imagery">
                <div id="imagelef">
                    <h3>
                        Joy is a thoughtfully curated café experience where specialty coffee, handcrafted desserts, and fresh flowers come together in harmony. Every cup is brewed with care using high-quality beans, every dessert is made by hand with attention to flavor and detail, and every floral arrangement is selected to add beauty and warmth to the space.

                        Designed as a place to pause, connect, and enjoy life’s simple pleasures, Joy offers a welcoming atmosphere where comfort meets creativity — turning everyday moments into joyful experiences
                    </h3>
                </div>

                <div id="imgrig">
                    <div class="imgcntr" style="background-image:url('./images/470001127_9146164548780947_1248115848634969634_n.jpg')"></div>
                    <div class="imgcntr" style="background-image:url('./images/503490837_2135428306957696_5895900800098717767_n.jpg')"></div>

                </div>
            </div>
        </div>
    </div>

    <div class="our-story">
        <div class="our-story-header">
            <div class="class-header-container">
                <p class="highlight-letters">Our Story</p>
                <h2 class="highlight-letters">Joy Moments</h2>
                <p class="our-story-par">
                    Every detail at Joy is crafted with love — from the aroma of coffee
                    to the freshness of flowers.
                </p>
            </div>
        </div>

        <div class="our-story-card-wrapper">

            <div class="our-story-singleCard">
                <h6><span class="card-number">01</span><span>Coffee</span></h6>
                <div class="our-story-cardContent">
                    <div class="image-left-story">
                        <img src="./images/496674114_17889289788254010_8422959851609208659_n.jpg" alt="">
                    </div>
                    <div class="our-story-left">
                        <h4 class="image-heading">Fresh Coffee</h4>
                        <p>Expertly brewed coffee made from premium beans, carefully selected and freshly roasted to deliver a rich, smooth flavor in every cup. At our shop, we create a cozy and welcoming space where you can relax, meet friends, or work while enjoying high-quality coffee prepared by skilled baristas who care about every detail..</p>
                    </div>
                </div>
            </div>

            <div class="our-story-singleCard">
                <h6><span class="card-number">02</span><span>Flowers</span></h6>
                <div class="our-story-cardContent">
                    <div class="image-left-story">
                        <img src="./images/561538130_17907759801254010_8665665837009064581_n.jpg" alt="">
                    </div>
                    <div class="our-story-left">
                        <h4 class="image-heading">Fresh Flowers</h4>
                        <p>Handpicked flowers, thoughtfully arranged to brighten every moment with natural beauty and charm.</p>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <?php include("footer.php"); ?>
</body>

</html>