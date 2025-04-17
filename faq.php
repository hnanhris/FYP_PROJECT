<?php include 'header.php'; ?>

<!-- Main Content -->
<div class="container" style="margin-top: 100px; min-height: 70vh;">
    <div class="row justify-content-center py-5">
        <div class="col-lg-8">
            <h1 class="text-center mb-5">Frequently Asked Questions</h1>

            <div class="accordion" id="faqAccordion">
                <!-- Shipping -->
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#shipping">
                            Shipping Information
                        </button>
                    </h2>
                    <div id="shipping" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            <p><strong>How long does shipping take?</strong><br>
                            Domestic orders typically take 3-5 business days. International shipping may take 7-14 business days.</p>
                            
                            <p><strong>Do you ship internationally?</strong><br>
                            Yes, we ship to most countries worldwide.</p>
                        </div>
                    </div>
                </div>

                <!-- Returns -->
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#returns">
                            Returns & Exchanges
                        </button>
                    </h2>
                    <div id="returns" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            <p><strong>What is your return policy?</strong><br>
                            We accept returns within 14 days of delivery. Items must be unworn with original tags.</p>
                            
                            <p><strong>How do I initiate a return?</strong><br>
                            Log into your account and go to your orders to start the return process.</p>
                        </div>
                    </div>
                </div>

                <!-- Sizing -->
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sizing">
                            Sizing & Fit
                        </button>
                    </h2>
                    <div id="sizing" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            <p><strong>How do I find my size?</strong><br>
                            Check our size guide on each product page for detailed measurements.</p>
                            
                            <p><strong>Do your items run true to size?</strong><br>
                            Most items run true to size, but we recommend checking the specific product reviews.</p>
                        </div>
                    </div>
                </div>

                <!-- Payment -->
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#payment">
                            Payment & Security
                        </button>
                    </h2>
                    <div id="payment" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            <p><strong>What payment methods do you accept?</strong><br>
                            We accept all major credit cards, PayPal, and bank transfers.</p>
                            
                            <p><strong>Is my payment information secure?</strong><br>
                            Yes, we use industry-standard SSL encryption to protect your data.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-center mt-5">
                <p>Can't find what you're looking for?</p>
                <a href="contact.php" class="btn btn-primary">Contact Us</a>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
