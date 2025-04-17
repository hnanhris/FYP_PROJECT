<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/262086238a.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@700&display=swap" rel="stylesheet">
</head>
<body>

<?php include 'header.php'; ?>


<!-- Welcome Section -->
<section class="welcome-section">
    <div class="welcome-banner">
        <h1>Welcome to Zyza Ismail Boutique !</h1>
    </div>
</section>


<!-- Featured Products -->
<section class="most-viewed">
    <h2 class="section-title">Eid Collection</h2>
    <p class="section-subtitle">When it comes to style, there are choices galore at Zyza</p>
    
    <div class="slider-container">
        <button class="slider-btn prev-btn"><i class="fas fa-chevron-left"></i></button>
        
        <div class="viewed-grid">
          
            <div class="viewed-card">
                <div class="product-badge">New</div>
                <img src="assets/saffiya_kurung2.jpg" alt="Shawl Collection">
                <div class="viewed-info">
                    <h3>Saffiya Kurun</h3>
                    <p class="price">RM 89.00</p>
                </div>
            </div>
            
            <div class="viewed-card">
                <div class="product-badge sale">-20%</div>
                <img src="assets/saffiya_kurung3.jpg" alt="Shawl Collection">
                <div class="viewed-info">
                    <h3>Saffiya Kurung</h3>
                    <p class="price"><span class="original">RM 120.00</span> RM 96.00</p>
                </div>
            </div>
            
            <div class="viewed-card">
                <div class="product-badge">New</div>
                <img src="assets/saffiya_kurung4.jpg" alt="Shawl Collection">
                <div class="viewed-info">
                    <h3>Saffiya Kurung</h3>
                    <p class="price">RM 122.00</p>
                </div>
            </div>
            
            <div class="viewed-card">
                <div class="product-badge">New</div>
                <img src="assets/saffiya_kurung5.jpg" alt="Shawl Collection">
                <div class="viewed-info">
                    <h3>Chiffon Pallazo</h3>
                    <p class="price">RM 122.00</p>
                </div>
            </div>


        </div>
        
        <button class="slider-btn next-btn"><i class="fas fa-chevron-right"></i></button>
    </div>
    
    <div class="text-center">
        <a href="shop.php" class="btn-load-more">Load More</a>
    </div>
</section>

<!-- Category Banners -->
<section class="category-banners">
        <div class="banner-grid">
            <div class="category-banner">
                <img src="assets/blazer3.png" alt="Bag Collection">
                <div class="banner-content">
                    <h3>Handbag<br>Collection</h3>
                    <a href="shop.php?category=bags" class="btn-view">View collection ></a>
                </div>
            </div>
            
            <div class="category-banner">
                <img src="assets/mikayla-ruby.webp" alt="Accessories Collection">
                <div class="banner-content">
                    <h3>Accessories<br>Collection</h3>
                    <a href="shop.php?category=accessories" class="btn-view">View collection ></a>
                </div>
            </div>
        </div>
</section>

<!-- Hot Sales -->
<section class="most-viewed">
    <h2 class="section-title">Hot Sales</h2>
    <p class="section-subtitle">When it comes to style, there are choices galore at Zyza</p>
    
    <div class="slider-container">
        <button class="slider-btn prev-btn"><i class="fas fa-chevron-left"></i></button>
        
        <div class="viewed-grid">
            <div class="viewed-card">
                <div class="product-badge">New</div>
                <img src="assets/saffiya_kurung5.jpg" alt="Shawl Collection">
                <div class="viewed-info">
                    <h3>Saffiya Kurun</h3>
                    <p class="price">RM 89.00</p>
                </div>
            </div>
            
            <div class="viewed-card">
                <div class="product-badge sale">-20%</div>
                <img src="assets/saffiya_kurung3.jpg" alt="Shawl Collection">
                <div class="viewed-info">
                    <h3>Saffiya Kurung</h3>
                    <p class="price"><span class="original">RM 120.00</span> RM 96.00</p>
                </div>
            </div>
            
            <div class="viewed-card">
                <div class="product-badge">New</div>
                <img src="assets/saffiya_kurung4.jpg" alt="Shawl Collection">
                <div class="viewed-info">
                    <h3>Saffiya Kurung</h3>
                    <p class="price">RM 122.00</p>
                </div>
            </div>
            
            <div class="viewed-card">
                <div class="product-badge">New</div>
                <img src="assets/saffiya_kurung5.jpg" alt="Shawl Collection">
                <div class="viewed-info">
                    <h3>Chiffon Pallazo</h3>
                    <p class="price">RM 122.00</p>
                </div>

        </div>
        
        <button class="slider-btn next-btn"><i class="fas fa-chevron-right"></i></button>
    </div>
    
    <div class="text-center">
        <a href="shop.php" class="btn-load-more">Load More</a>
    </div>
</section>

<!-- Explore Section -->
<section class="explore-section">
    <div class="container">
        <div class="explore-layout">
            <div class="explore-text">
                <h2>More to<br>Explore</h2>
                <p>Discover chic Muslimah designs and graceful pieces to elevate your wardrobe</p>
            </div>
            
            <div class="category-grid">
                <div class="category-card">
                    <div class="category-image">
                        <img src="assets/pashmina-kebarung4.webp" alt="Category 1">
                        <a href="shop.php?category=kurung" class="btn-shop">Shop now</a>
                    </div>
                    <div class="category-info">
                        <h3 class="category-name">KURUNG</h3>
                    </div>
                </div>
                
                <div class="category-card">
                    <div class="category-image">
                        <img src="assets/mikayla-f2.webp" alt="Category 2">
                        <a href="shop.php?category=blouse" class="btn-shop">Shop now</a>
                    </div>
                    <div class="category-info">
                        <h3 class="category-name">BLOUSE</h3>
                    </div>
                </div>

                <div class="category-card">
                    <div class="category-image">
                        <img src="assets/pallazo-featured.webp" alt="Category 3">
                        <a href="shop.php?category=pants" class="btn-shop">Shop now</a>
                    </div>
                    <div class="category-info">
                        <h3 class="category-name">PANTS</h3>
                    </div>
                </div>

                <div class="category-card">
                    <div class="category-image">
                        <img src="assets/skirtdenimjeans-featured.webp" alt="Category 4">
                        <a href="shop.php?category=skirts" class="btn-shop">Shop now</a>
                    </div>
                    <div class="category-info">
                        <h3 class="category-name">SKIRTS</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<!-- Footer -->
<?php include 'footer.php'; ?>

</body>
</html>



<style>
@font-face {
    font-family: 'Playlist Script';
    src: url('assets/playlist-script.otf') format('opentype');
    font-weight: normal;
    font-style: normal;
}

.container {
    max-width: 1500px;
    margin: 0 auto;
    padding: 0 20px;
}




/* Welcome Section */

.welcome-section {
    padding-top: 80px;
    margin-top: 70px;
    margin-left: 60px;
    margin-right: 60px;
}

.welcome-banner {
    background: #000;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 60px 20px;
    margin-bottom: 50px;
}

.welcome-banner h1 {
    color: white;
    font-family: 'Playlist Script', cursive;
    font-size: 54px;
    margin: 0;
    text-align: center;
    line-height: 1.2;
}







/* Most Viewed Products */
.most-viewed {
    padding: 30px 0;
    background: white;
    font-family: 'Glacial Indifference', sans-serif;
    margin-left: 60px;
    margin-right: 60px;
}

.section-subtitle {
    text-align: center;
    color: #666;
    margin-bottom: 40px;
    font-size: 14px;
}

.most-viewed .section-title {
    font-size: 26px;
    text-align: center;
}

.slider-container {
    position: relative;
    overflow: hidden;
    padding: 0 40px;
}

.viewed-grid {
    display: flex;
    gap: 30px;
    transition: transform 0.3s ease;
    overflow-x: hidden;
}

.viewed-card {
    flex: 0 0 calc(25% - 23px);
    position: relative;
    background: #f7f7f7;
    padding: 20px;
    text-align: center;
    transition: transform 0.3s ease;
}

.slider-btn {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    width: 40px;
    height: 40px;
    border: none;
    border-radius: 50%;
    background: white;
    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    cursor: pointer;
    z-index: 2;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
}

.slider-btn:hover {
    background: #f7f7f7;
    box-shadow: 0 3px 8px rgba(0,0,0,0.15);
}

.prev-btn {
    left: 0;
}

.next-btn {
    right: 0;
}

.slider-btn i {
    font-size: 16px;
    color: #333;
}

.slider-btn:disabled {
    opacity: 0.5;
    cursor: not-allowed;
}

.viewed-card img {
    width: 100%;
    height: auto;
    margin-bottom: 20px;
    transition: transform 0.3s ease;
}

.viewed-card:hover img {
    transform: scale(1.05);
}

.viewed-info h3 {
    font-size: 14px;
    margin-bottom: 10px;
    color: #333;
}

.price {
    font-size: 14px;
    color: #333;
}

.original {
    text-decoration: line-through;
    color: #999;
    margin-right: 10px;
}

.btn-load-more {
    display: inline-block;
    background: #333;
    color: white;
    padding: 8px 30px;
    text-decoration: none;
    font-size: 13px;
    text-transform: uppercase;
    letter-spacing: 1px;
    transition: all 0.3s ease;
    margin-top: 18px;
}

.btn-load-more:hover {
    background: #666;
    transform: translateY(-2px);
}





/* Product Section */

.product-section .section-title {
    font-family: 'Glacial Indifference', sans-serif;
    font-weight: bold;
    text-align: center;
    align-items: center;
    margin-left: 520px;
    margin-bottom: 40px;
    font-size: 10px;
    letter-spacing: 1px;
}

.product-slider {
    position: relative;
    padding: 0 40px;
}

.product-slider-container {
    display: flex;
    overflow-x: hidden;
    scroll-behavior: smooth;
    gap: 20px;
    padding: 20px 0;
    margin-left: 40px;
    margin-right: 40px;
}

.product-card {
    flex: 0 0 calc(25% - 15px);
    background: #f7f7f7;
    overflow: hidden;
    transition: transform 0.3s ease;
}

.product-card:hover {
    transform: translateY(-5px);
}

.product-image {
    position: relative;
    aspect-ratio: 1;
    overflow: hidden;
    display: flex;
    align-items: flex-end;
    justify-content: center;
    padding-bottom: 20px;
}

.product-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.btn-shop {
    position: center;
    bottom: 20px;
    background: rgba(255, 255, 255, 0.9);
    color: #333;
    padding: 8px 25px;
    border-radius: 20px;
    text-decoration: none;
    font-size: 14px;
    transition: all 0.3s ease;
    opacity: 0;
    transform: translateY(10px);
}

.product-card:hover .btn-shop {
    opacity: 1;
    transform: translateY(0);
}

.product-info {
    padding: 15px;
    text-align: center;
}

.product-name {
    font-size: 15px;
    color: black;
    margin-bottom: 5px;
}

.product-price {
    color: black;
    font-size: 13px;
}





/* Explore Section */

.explore-section {
  margin-top: 40px;
    padding: 30px 0;
    background: #f7f7f7;
    margin-bottom: 40px;
}

.explore-layout {
    display: grid;
    grid-template-columns: 300px 1fr;
    gap: 40px;
    align-items: start;
}

.explore-text {
    position: sticky;
    top: 100px;
}

.explore-text h2 {
    font-size: 36px;
    margin-bottom: 20px;
    line-height: 1.2;
}

.explore-text .display-4 {
    font-size: 48px;
    font-weight: bold;
}

.explore-text p {
    color: #666;
    line-height: 1.6;
}


.category-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 20px;
}

.category-card {
    background: white;
    overflow: hidden;
    border-radius: 10px;
    transition: transform 0.3s ease;
}

.category-card:hover {
    transform: translateY(-5px);
}

.category-image {
    position: relative;
    aspect-ratio: 3/4;
    background: #e6f3ff;
    overflow: hidden;
}

.category-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.category-wave {
    position: absolute;
    bottom: 0;
    left: 0;
    width: 100%;
    height: 30%;
    background: linear-gradient(180deg, transparent 0%, rgba(146, 176, 0, 0.8) 100%);
    clip-path: polygon(0 40%, 100% 0%, 100% 100%, 0% 100%);
}

.category-info {
    padding: 12px;
    text-align: center;
}

.category-name {
    font-size: 16px;
    font-weight: bold;
    margin: 0;
    color: #333;
}

.btn-shop {
    position: absolute;
    bottom: 20px;
    left: 50%;
    transform: translateX(-50%);
    background: rgba(255, 255, 255, 0.9);
    color: #333;
    padding: 8px 25px;
    border-radius: 20px;
    text-decoration: none;
    font-size: 14px;
    transition: all 0.3s ease;
    z-index: 1;
}

.btn-shop:hover {
    background: white;
    transform: translateX(-50%) translateY(-2px);
}

.slider-btn {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    width: 40px;
    height: 40px;
    border: none;
    border-radius: 50%;
    background: white;
    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 1;
    transition: all 0.3s ease;
}

.slider-btn:hover {
    background: #f7f7f7;
}

.slider-btn.prev {
    left: 0;
}

.slider-btn.next {
    right: 0;
}

.slider-btn i {
    color: #333;
    font-size: 16px;
}

.featured-collection {
    padding: 80px 0;
    background: white;
    font-family: 'Glacial Indifference', sans-serif;
}





/* Collection Grid */

.collection-grid {
    display: grid;
    grid-template-columns: 2fr 1fr;
    gap: 30px;
}

.collection-main {
    position: relative;
    border-radius: 5px;
    overflow: hidden;
    aspect-ratio: 16/9;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
}

.collection-main img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.collection-content {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    padding: 40px;
    background: linear-gradient(0deg, rgba(0,0,0,0.7) 0%, transparent 100%);
    color: white;
}

.collection-content h2 {
    font-size: 32px;
    line-height: 1.2;
    margin-bottom: 10px;
    text-transform: uppercase;
    letter-spacing: 1px;
}

.collection-content h2 span {
    font-size: 48px;
    font-weight: bold;
    display: block;
}

.collection-content p {
    font-size: 14px;
    margin-bottom: 20px;
    opacity: 0.9;
    letter-spacing: 0.5px;
}

.btn-collection {
    display: inline-block;
    background: white;
    color: #333;
    padding: 12px 30px;
    border-radius: 25px;
    text-decoration: none;
    font-size: 13px;
    text-transform: uppercase;
    letter-spacing: 1px;
    transition: all 0.3s ease;
}

.btn-collection:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0,0,0,0.2);
    color: #666;
}






/* Category Banners */
.category-banners {
  margin-right: 60px;
  margin-left: 60px;
    padding: 40px 50px 80px;
    background: white;
}

.banner-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 30px;
}

.category-banner {
    position: relative;
    overflow: hidden;
    aspect-ratio: 16/9;
}

.category-banner img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.category-banner:hover img {
    transform: scale(1.05);
}

.banner-content {
    position: absolute;
    top: 50%;
    left: 40px;
    transform: translateY(-50%);
    color: white;
}

.banner-content h3 {
    font-size: 28px;
    line-height: 1.2;
    margin-bottom: 15px;
    text-transform: uppercase;
    letter-spacing: 1px;
}

.btn-view {
    color: white;
    text-decoration: none;
    font-size: 14px;
    text-transform: uppercase;
    letter-spacing: 1px;
    transition: opacity 0.3s ease;
}

.btn-view:hover {
    opacity: 0.8;
}

.product-badge {
    position: absolute;
    top: 20px;
    left: 20px;
    background: #333;
    color: white;
    padding: 5px 10px;
    font-size: 12px;
    text-transform: uppercase;
    letter-spacing: 1px;
    z-index: 1;
}

.product-badge.sale {
    background: #ff4444;
}

.viewed-card:hover {
    transform: translateY(-5px);
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const slider = document.querySelector('.product-slider-container');
    const prevBtn = document.querySelector('.slider-btn.prev');
    const nextBtn = document.querySelector('.slider-btn.next');
    
    let scrollAmount = 0;
    const cardWidth = slider.querySelector('.product-card').offsetWidth + 20; // width + gap
    
    prevBtn.addEventListener('click', () => {
        scrollAmount = Math.max(scrollAmount - cardWidth, 0);
        slider.scrollTo({
            left: scrollAmount,
            behavior: 'smooth'
        });
    });
    
    nextBtn.addEventListener('click', () => {
        scrollAmount = Math.min(scrollAmount + cardWidth, slider.scrollWidth - slider.clientWidth);
        slider.scrollTo({
            left: scrollAmount,
            behavior: 'smooth'
        });
    });
});
</script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const slider = document.querySelector('.viewed-grid');
    const prevBtn = document.querySelector('.prev-btn');
    const nextBtn = document.querySelector('.next-btn');
    const cards = document.querySelectorAll('.viewed-card');
    
    let currentIndex = 0;
    const cardWidth = cards[0].offsetWidth + 30; // Including gap
    const maxIndex = cards.length - 4; // Show 4 cards at a time
    
    function updateSliderPosition() {
        slider.style.transform = `translateX(-${currentIndex * cardWidth}px)`;
        
        // Update button states
        prevBtn.disabled = currentIndex === 0;
        nextBtn.disabled = currentIndex >= maxIndex;
    }
    
    prevBtn.addEventListener('click', () => {
        if (currentIndex > 0) {
            currentIndex--;
            updateSliderPosition();
        }
    });
    
    nextBtn.addEventListener('click', () => {
        if (currentIndex < maxIndex) {
            currentIndex++;
            updateSliderPosition();
        }
    });
    
    // Initial button state
    updateSliderPosition();
    
    // Update on window resize
    window.addEventListener('resize', updateSliderPosition);
});
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>