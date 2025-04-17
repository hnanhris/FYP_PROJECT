<footer class="footer">
    <div class="footer-container">
        <!-- About Section -->
        <div class="footer-section">
            <h5 class="footer-title">About</h5>
            <ul class="footer-links">
                <li><a href="about.php">About Us</a></li>
                <li><a href="terms.php">Terms & Conditions</a></li>
                <li><a href="contact.php">Contact Us</a></li>
            </ul>
        </div>

        <!-- Customer Service Section -->
        <div class="footer-section">
            <h5 class="footer-title">Customer Service</h5>
            <ul class="footer-links">
                <li><a href="faq.php">FAQ</a></li>
                <li><a href="privacy-policy.php">Privacy Policy</a></li>
                <li><a href="track-order.php">Track Order</a></li>
            </ul>
        </div>

        <!-- Follow Us Section -->
        <div class="footer-section">
            <h5 class="footer-title">Follow Us</h5>
            <ul class="footer-links">
                <li>
                    <a href="https://www.facebook.com/ZyzaHQ/">
                        <i class="bi bi-facebook"></i> Facebook
                    </a>
                </li>
                <li>
                    <a href="https://shopee.com.my/zyzahq">
                        <i class="bi bi-shop"></i> Shopee
                    </a>
                </li>
                <li>
                    <a href="https://www.tiktok.com/@zyzahq">
                        <i class="bi bi-tiktok"></i> TikTok
                    </a>
                </li>
            </ul>
        </div>
    </div>
</footer>

<style>
.footer {
    background: black;
    color: white;
    padding: 60px 0;
    font-family: 'Glacial Indifference', sans-serif;
}

.footer-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
    display: flex;
    justify-content: center;
    gap: 60px;
}

.footer-section {
    flex: 0 1 200px;
}

.footer-title {
    text-transform: uppercase;
    font-size: 14px;
    margin-bottom: 20px;
    font-weight: bold;
}

.footer-links {
    list-style: none;
    padding: 0;
    margin: 0;
}

.footer-links li {
    margin-bottom: 12px;
}

.footer-links a {
    color: white;
    text-decoration: none;
    font-size: 13px;
    transition: color 0.3s ease;
}

.footer-links a:hover {
    color: #999;
}

.footer-links i {
    margin-right: 8px;
}

@media (max-width: 768px) {
    .footer-container {
        flex-direction: column;
        text-align: center;
        gap: 40px;
    }

    .footer-section {
        flex: none;
    }
}
</style>
