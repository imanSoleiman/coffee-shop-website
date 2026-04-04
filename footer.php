<style>
    .footer-container {
        background-color: #0766AD;
        margin-left: 12px;
        margin-right: 12px;
        border-radius: 16px;
    }

    .footer-container-first {
        max-width: 1240px;
        margin: 0 auto;

    }

    .footer-container-first-grid {
        display: grid;
        grid-template-columns: 2fr 1.3fr 2fr 1.8fr;
        gap: 50px 95px;
        padding-top: 90px;
        padding-bottom: 50px;
    }

    .logo-image {
        width: 190px;
        transition: transform 0.5s ease-out;

    }

    .logo-image img {
        max-width: 100%;
    }

    ul {
        list-style: none;
    }

    a {
        text-decoration: none;
        color: beige;
    }

    .logo-container-wrapper {
        overflow: hidden;
        height: 150px;
        position: relative;
    }

    .footer-container-first-grid h4 {
        font-size: 16px;
        opacity: 0.64;
        margin-bottom: 28px;
        color: rgb(0, 0, 0);
        text-transform: capitalize;
    }

    .footer-services-list {
        width: 100%;
        position: relative;
        overflow: visible;
    }

    .footer-services-list li {
        position: relative;
        margin-bottom: 5px;
    }

    .footer-services-list li a {
        display: inline-block;
        position: relative;
        transition: color 0.2s ease, transform 0.2s ease;
        font-size: 20px;
        font-family: "Roboto", sans-serif;
        ;
        text-transform: capitalize;
        font-weight: 400;
        padding-left: 0px;
        line-height: 1;
        position: relative;
        z-index: 1;
        color: beige;
        margin-bottom: 10px;
    }

    .footer-services-list li a:hover {
        color: orangered;
        transform: translateX(10px);
    }

    .footer-services-list li a .circle {
        width: 7px;
        height: 7px;
        border-radius: 50%;
        background: red;
        position: absolute;
        left: -16px;
        top: 50%;
        transform: translateY(-50%) scale(0);
        opacity: 0;
        transition: opacity 0.2s ease, transform 0.2s ease;
    }

    .footer-services-list li a:hover .circle {
        transform: translateY(-50%) scale(1);
        opacity: 1;
    }

    .useful-links li {
        margin-bottom: 5px;
        font-weight: 500;

    }

    .useful-links li a:hover {
        transition: ease-in-out 0.2s;
    }

    .useful-links li a:hover {
        color: orangered;
    }

    .get_in_touch_content {
        display: flex;
        gap: 5px;
        align-items: center;
    }


    .footer-container-second {
        padding: 55px;
        border-top: 1px solid rgba(0, 0, 0, 0.2);
        border-bottom: 1px solid rgba(0, 0, 0, 0.2);
        position: relative;
    }

    .footer-container-second-content {
        max-width: 1240px;
        margin: 20px;
        padding: 10px;
    }

    .footer-container-second-content p {
        margin-right: 50px;
    }

    .footer-go-top {
        position: absolute;
        top: 0px;
        height: 100%;
        display: flex;
        align-items: center;
        right: 0px;
        border-left: 1px solid rgba(0, 0, 0, 0.2);

    }

    .footer-got-top-btn {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        padding: 10px;
        cursor: pointer;

    }

    .text-wrapper {
        display: flex;
        justify-content: flex-start;
        overflow: hidden;
    }

    .text-wrapper h1 {
        font-size: 60px;
        letter-spacing: 1px;
        animation: move-text 6000ms linear infinite;
        white-space: nowrap;
        padding: 0 2rem;
        text-transform: uppercase;
    }

    @keyframes move-text {
        0% {
            transform: translateX(0);
        }

        100% {
            transform: translateX(-100%);
        }
    }

    .text-slider,
    .last-section {
        padding: 55px 0px;
        border-bottom: 1px solid rgba(0, 0, 0, 0.2);
    }

    .last-section-container {
        display: flex;
        justify-content: space-around;
        margin: 20px;

    }

    .last-section-right {
        display: flex;
        gap: 20px;
    }

    @media screen and (max-width: 960px) {
        .footer-container-first-grid {
            display: grid;
            grid-template-columns: none;
            grid-template-rows: 0.5fr 1fr 1fr 1fr;
            gap: 50px 95px;
            padding-top: 10px;
            padding-bottom: 0px;
            padding: 50px;
        }

        .text-wrapper h1 {
            font-size: 30px;
            letter-spacing: 1px;
            animation: move-text 6000ms linear infinite;
            white-space: nowrap;
            padding: 0 2rem;
            text-transform: uppercase;
        }

        .text-slider {
            padding: 10px 5px;
        }

        .footer-container-second {
            padding: 20px;
        }

        .last-section-container {
            display: flex;
            justify-content: space-around;
            flex-direction: column;
            margin: 20px;
            gap: 10px;
        }
    }

    @media screen and (max-width:500px) {
        .footer-container-second {
            padding: 3px;
        }

        .last-section-right p {
            font-size: 12px;
        }

        .footer-container-first-grid {
            padding: 20px;
            padding-top: 50px;
        }

    }
</style>

<div class="footer-container">
    <div class="footer-container-first">
        <div class="footer-container-first-grid">

            <div class="logo-container-wrapper">
                <div class="logo-image">
                    <a href="./index.php">
                        <img src="./images/Joy.png">
                    </a>
                </div>
            </div>


            <div class="useful-links">
                <h4>Useful Links</h4>
                <ul>
                    <li>
                        <a href="./index.php">Home</a>
                    </li>


                    <li>
                        <a href="./projects.php">Projects</a>
                    </li>

                    <li>
                        <a href="./news.php">News</a>
                    </li>


                </ul>
            </div>

            <div class="footer-services">
                <h4>Our Services</h4>
                <ul class="footer-services-list">
                    <li><a href="#"><span class="circle"></span> Specialty Coffee</a></li>
                    <li><a href="#"><span class="circle"></span> Fresh Flowers</a></li>
                    <li><a href="about.php"><span class="circle"></span> Custom Gift Boxes</a></li>
                </ul>
            </div>


            <div class="get_in_touch">
                <h4>Get in Touch</h4>

                <ul>
                    <li class="footer-info">
                        <a class="get_in_touch_content" href="mailto:joy@example.com">
                            <i class="fa-regular fa-envelope"></i> joy@example.com
                        </a>
                    </li>

                    <li class="footer-info">
                        <a class="get_in_touch_content" href="tel:+9712839">
                            <i class="fa-solid fa-phone-volume"></i> +971 2839
                        </a>
                    </li>

                    <li class="footer-info get_in_touch_content">
                        <i class="fa-regular fa-clock"></i> Mon - Fri: 9:00 AM - 6:00 PM
                    </li>
                </ul>
            </div>


        </div>
    </div>


    <div class="last-section">
        <div class="last-section-text">
            <div class="last-section-container">
                <div>
                    <p>©2025, joy Beirute. All Rights Reserved.</p>
                </div>

                <div class="last-section-right">
                    <p>Privacy Policy</p>
                    <p>Terms and condition</p>
                    <p>Terms and condition</p>
                </div>
            </div>
        </div>
    </div>
</div>
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
    gsap.fromTo(
        ".logo-image", {
            y: "150%",
            opacity: 0
        }, {
            y: "0%",
            opacity: 1,
            duration: 1,
            ease: "power3.out",
            scrollTrigger: {
                trigger: ".footer-container-first",
                start: "top 80%",
                end: "top 60%",
                scrub: true
            }
        }
    );
</script>