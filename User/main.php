<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Six Flags – Attractions</title>

<style>
/*COLORS (THEME)*/
:root {
  --sky-light: #E3F4FF;
  --white: #ffffff;
  --yellow-light: #FFF8CC;
  --red-main: #D80000;
  --yellow-main: #FFD700;
  --navy: #162258;
  --text-dark: #222;

 
  --purple-main: #7A3EF0; 
}


/* Reset all margins & paddings + consistent box model */
* { margin: 0; padding: 0; box-sizing: border-box; }
/* Global Page Style */
body {
    font-family: 'Arial', sans-serif;
    background: var(--sky-light);
    color: var(--black);
    overflow-x: hidden;
}

/* HEADER */
.header {
    position: fixed; /* Stays at the top while scrolling */
    top: 0;
    width: 100%;
    background: rgba(255,255,255,0.85);
    backdrop-filter: blur(10px);
    border-bottom: 2px solid var(--yellow-main);
    z-index: 1000; /* Always above all sections */
}
/* Header Container Layout */
.nav-container {
    max-width: 1400px;
    margin: auto;
    padding: 20px 30px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}
/* Six Flags Logo */
.logo-img {
    height: 60px;
}

.nav-menu {
    display: flex;
    gap: 20px;
    list-style: none;
}
.nav-menu a {
    text-decoration: none;
    color: var(--text-dark);
    font-weight: 700;
    padding-bottom: 3px;
    border-bottom: 2px solid transparent;
    transition: 0.2s ease;
}
/* Hover Underline Animation */
.nav-menu a:hover {
    border-bottom: 2px solid var(--red-main);
}

/* RIGHT LOGOS */
.right-logos {
    display: flex;
    align-items: center;
    gap: 15px;
}
.right-logos img {
    height: 60px;
    object-fit: contain;
}

/* HERO */
.hero {
    height: 100vh;
    background: url('/web/image/hero-bg.png') center/cover no-repeat;
    display: flex;
    justify-content: center;
    align-items: center;
    padding-top: 120px; /* Space for fixed navbar */
    text-align: center;
    position: relative;
}
/* Space for fixed navbar */
.hero::before {
    content: "";
    position: absolute;
    inset: 0;
    background: rgba(0,0,0,0.45);
}

/* Hero text content */
.hero h1, .hero p {
    position: relative;
    color: white;
}

.hero h1 {
    font-size: 70px;
    font-weight: bold;
    margin-bottom: 15px;
}

.hero p {
    font-size: 20px;
}

/*  ATTRACTIONS */
.carousel-section {
    padding: 80px 20px 120px;
    text-align: center;
    background: linear-gradient(135deg, #FFF4C2, #FFDDEA, #EEDCFF);
    background-size: 300% 300%;
    animation: softGradient 12s ease infinite; /* Animated Gradient */
    position: relative;
}
/* Background animation */
@keyframes softGradient {
    0% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
    100% { background-position: 0% 50%; }
}
/* Section Title */
.carousel-title {
    font-size: 50px;
    color: var(--navy) !important;
    margin-bottom: 0px;
    font-weight: 900;
}

/* Main carousel 3D container */
.carousel-container {
    width: 100%;
    max-width: 1600px;
    margin: auto;
    height: 520px;
    position: relative;
}
/* Each carousel card wrapper */
.carousel-item {
    position: absolute;
    width: 350px;
    height: 350px;
    left: 50%;
    top: 50%;
    transform-style: preserve-3d;
    transition: 0.6s;
    cursor: pointer;
    transform: translate(-50%, -50%);
}


/* Attraction Card Style */
.card {
    width: 100%;
    height: 100%;
    border-radius: 20px;
    background: white;
    border: 3px solid var(--yellow-main);
    padding: 20px;
    overflow: hidden;
    box-shadow: 0px 0px 0px rgba(0,0,0,0);
    transition: 0.3s ease;
}
/* Card Hover Effect */
.card:hover {
    transform: scale(1.03);
    box-shadow: 0px 12px 35px rgba(0,0,0,0.28);
}

.card img {
    width: 100%;
    height: 220px;
    object-fit: cover;
    border-radius: 15px;
    margin-bottom: 20px;
}

.card-title {
    font-size: 22px;
    font-weight: 800;
    color: var(--navy) !important;
    margin-bottom: 10px;
}


.card-desc {
    font-size: 14px;
    color: #333;
}


.carousel-arrow {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    width: 60px;
    height: 60px;
    border-radius: 50%;
    background: var(--navy);
    border: 3px solid var(--yellow-main);
    color: white;
    font-size: 32px;
    cursor: pointer;
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 9999;
}

#arrowLeft { left: 30px; }
#arrowRight { right: 30px; }


/*  BOOK NOW */
.book-banner {
    display: flex;
    width: 100%;
    overflow: hidden;
    margin-top: 0px;
}

.book-left { width: 50%; }
.book-left img {
    width: 100%;
    height: 450px;
    object-fit: cover;
}

.book-right {
    width: 50%;
    background: var(--yellow-main);
    padding: 80px 60px;
    transform: skewX(-8deg);/* Slanted box */
    display: flex;
    flex-direction: column;
    justify-content: center;
}
.book-right-content { transform: skewX(8deg); }
/* Book Now Title */
.book-right h2 {
    font-size: 48px;
    font-weight:900;
    margin-bottom: 10px;
    color: black;
}

.book-right p {
    font-size: 18px;
    max-width: 500px;
    color: #222;
    margin-bottom: 30px;
}

.book-btn {
    background: var(--navy);
    padding: 18px 45px;
    color: white;
    font-size: 20px;
    border-radius: 40px;
    border: none;
    cursor: pointer;
    font-weight: bold;
    text-decoration: none;
}
.book-btn:hover { background: black; }
</style>
</head>

<body>

<!-- HEADER (MODIFIED) -->
<header class="header">
    <nav class="nav-container">

        <img src="/web/image/sixflags.png" class="logo-img">

        <ul class="nav-menu">
            <li><a href="#home">Home</a></li>
            <li><a href="#rides">Rides</a></li>
            <li><a href="#book">Book</a></li>
            <li><a href="#contact" style="font-weight:700;">Contact</a></li>
        </ul>
  <!-- Right-side Logos -->
        <div class="right-logos">
            <img src="/web/image/qiddiya.png">
            <img src="/web/image/vision2030.png">
        </div>

    </nav>
</header>

<!-- HERO -->
<section class="hero" id="home">
    <div>
        <h1>Welcome to Six Flags</h1>
        <p>Experience the thrill & unforgettable moments.</p>
    </div>
</section>

<!-- ATTRACTIONS -->
<section class="carousel-section" id="rides">
    <h2 class="carousel-title">Our Attractions</h2>

    <button id="arrowLeft" class="carousel-arrow">❮</button>
    <button id="arrowRight" class="carousel-arrow">❯</button>

    <div class="carousel-container">
        <div id="carousel" class="carousel"></div>
    </div>
</section>

<!-- BOOK NOW -->
<section class="book-banner" id="book">
    <div class="book-left">
        <img src="/web/image/boy.png">
    </div>

    <div class="book-right">
        <div class="book-right-content">
            <h2>Book Now</h2>
            <p>Get ready for the thrill — your adventure starts now!  
               Don’t miss the excitement </p>

            <a class="book-btn" href="home.php">Start Booking</a>
        </div>
    </div>
</section>

<!-- CONTACT -->
<section class="contact-section" id="contact" style="
    padding:120px 30px; 
    background: linear-gradient(to bottom, #E3F4FF 0%, #ffffff 40%, #FFF8CC 100%);
">
    <h2 class="section-title" style="
        font-size:45px;
        text-align:center;
        color:var(--navy);
        margin-bottom:10px;
        font-weight:900;
    ">Contact Us</h2>

    <p class="section-subtitle" style="
        text-align:center;
        color:#555;
        margin-bottom:50px;
        font-size:18px;
    ">
        Have questions? We’re here to help — feel free to reach out anytime!
    </p>

    <div class="contact-container" style="
        max-width:1100px;
        margin:auto;
        display:grid;
        grid-template-columns: 1fr 1fr;
        gap:40px;
    ">

        <!-- LEFT -->
        <div>
            <div class="info-item" style="
                background:var(--sky-light);
                padding:20px;
                border-radius:15px;
                border:2px solid var(--yellow-main);
                display:flex;
                align-items:center;
                margin-bottom:20px;
            ">
                <div class="icon" style="
                    width:55px;
                    height:55px;
                    border-radius:50%;
                    background:var(--navy);
                    display:flex;
                    justify-content:center;
                    align-items:center;
                    color:white;
                    font-size:24px;
                    margin-right:15px;
                ">📍</div>
                <p style="font-size:17px;">Riyadh, Saudi Arabia</p>
            </div>

            <div class="info-item" style="
                background:var(--sky-light);
                padding:20px;
                border-radius:15px;
                border:2px solid var(--yellow-main);
                display:flex;
                align-items:center;
                margin-bottom:20px;
            ">
                <div class="icon" style="
                    width:55px;
                    height:55px;
                    border-radius:50%;
                    background:var(--navy);
                    display:flex;
                    justify-content:center;
                    align-items:center;
                    color:white;
                    font-size:24px;
                    margin-right:15px;
                ">📧</div>
                <p style="font-size:17px;">support@sixflags.com</p>
            </div>

            <div class="info-item" style="
                background:var(--sky-light);
                padding:20px;
                border-radius:15px;
                border:2px solid var(--yellow-main);
                display:flex;
                align-items:center;
            ">
                <div class="icon" style="
                    width:55px;
                    height:55px;
                    border-radius:50%;
                    background:var(--navy);
                    display:flex;
                    justify-content:center;
                    align-items:center;
                    color:white;
                    font-size:24px;
                    margin-right:15px;
                ">📞</div>
                <p style="font-size:17px;">+966 555 123 456</p>
            </div>
        </div>

        <!-- RIGHT -->
        <form class="contact-form" style="width:100%;">
            <input type="text" placeholder="Full Name" required style="
                width:100%;
                padding:15px;
                margin-bottom:20px;
                border-radius:10px;
                border:2px solid var(--yellow-main);
                font-size:16px;
            ">

            <input type="email" placeholder="Email Address" required style="
                width:100%;
                padding:15px;
                margin-bottom:20px;
                border-radius:10px;
                border:2px solid var(--yellow-main);
                font-size:16px;
            ">

            <textarea rows="5" placeholder="Your Message" required style="
                width:100%;
                padding:15px;
                margin-bottom:20px;
                border-radius:10px;
                border:2px solid var(--yellow-main);
                font-size:16px;
            "></textarea>

            <button style="
                width:100%;
                padding:16px;
                background:var(--navy);
                border:3px solid var(--yellow-main);
                color:white;
                font-size:20px;
                font-weight:bold;
                border-radius:10px;
                cursor:pointer;
            ">Send Message</button>
        </form>

    </div>
</section>

<!-- JAVASCRIPT (ADDED) -->
<script>
/* Array of rides shown in the 3D carousel */
const rides = [
    { title: "Steam Racer", img: "/web/image/Iron_Rattler.png", desc: "The iconic steampunk coaster of Qiddiya." },
    { title: "Orbital Spin", img: "/web/image/Gyrospin.png", desc: "A thrilling spinning experience with neon lights." },
    { title: "Falcon Loop", img: "/web/image/Spitfire.jpg", desc: "A high-speed coaster with insane drops." },
    { title: "Carousel Kids", img: "/web/image/Arabian_Carousel.jpg", desc: "A gentle and fun ride for families." }
];

const carousel = document.getElementById("carousel");
let index = 0;
/* Build the carousel cards dynamically */
function buildCarousel() {
    rides.forEach(ride => {
        const item = document.createElement("div");
        item.className = "carousel-item";
        item.innerHTML = `
            <div class="card">
                <img src="${ride.img}">
                <div class="card-title">${ride.title}</div>
                <div class="card-desc">${ride.desc}</div>
            </div>`;
        carousel.appendChild(item);
    });

    updateCarousel();
}
/* Controls the 3D animation of each card */
function updateCarousel() {
    const items = document.querySelectorAll(".carousel-item");

    items.forEach((item, i) => {
        const offset = (i - index + rides.length) % rides.length;
 /* Center card (main focus) */
        if (offset === 0) {
            item.style.transform = "translate(-50%, -50%) translateZ(0) scale(1)";
            item.style.opacity = "1";
        }
        else if (offset === 1 || offset === rides.length - 1) { /* Left & Right Cards */
            const side = offset === 1 ? 1 : -1;
            item.style.transform =
              `translate(-50%, -50%) translateX(${side * 350}px) translateZ(-200px) scale(0.8) rotateY(${side * 20}deg)`;
            item.style.opacity = "0.8";
        }
        else {
            item.style.transform = "translate(-50%, -50%) translateZ(-500px) scale(0.5)";  /* Cards at back (hidden) */
            item.style.opacity = "0";
        }
    });
}


buildCarousel();
/* Auto slide every 4 seconds */
setInterval(() => {
    index = (index + 1) % rides.length;
    updateCarousel();
}, 4000);

document.getElementById("arrowLeft").onclick = () => {
    index = (index - 1 + rides.length) % rides.length;
    updateCarousel();
};

document.getElementById("arrowRight").onclick = () => {
    index = (index + 1) % rides.length;
    updateCarousel();
};
</script>
<!-- FOOTER -->
<footer style="
    background: var(--navy);
    color: white;
    padding: 20px 0;
    text-align: center;
    
    border-top: 3px solid var(--yellow-main);
">
    <footer>
    <p>©  Six Flags Qiddiya. All Rights Reserved. — <?php echo date("Y"); ?></p>
</footer>
</footer>

</body>
</html>
