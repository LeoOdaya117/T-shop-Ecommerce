@extends("layouts.default")
@section("title", "T-Shop - Home")

@section("content")
    <main class="container w-100 mb-3">
        
        <div class="container mt-5">
            
            <h1 class="text-center pt-3">Terms and Conditions</h1>
            <hr>
            <h2>1. Introduction</h2>
            <p>   Welcome to T-SHOP ("we," "our," "us"). By accessing or using our website (the "Site"), you agree to comply with and be bound by these Terms and Conditions. If you do not agree to these terms, you must not use our Site.</p>

            <h2>2. Use of the Site</h2>
            <h3>   2.1 Eligibility</h3>
            <p>      To use our Site, you must be at least 18 years old or have the consent of a legal guardian. By using the Site, you represent and warrant that you meet this requirement.</p>

            <h3>   2.2 Account Responsibility</h3>
            <p>      You are responsible for maintaining the confidentiality of your account information and password. You agree to notify us immediately of any unauthorized use of your account.</p>

            <h2>3. Product Information</h2>
            <h3>   3.1 Description</h3>
            <p>      We strive to provide accurate descriptions and images of our t-shirts. However, colors and designs may vary slightly due to screen settings or production variations.</p>

            <h3>   3.2 Availability</h3>
            <p>      All products are subject to availability. We reserve the right to limit the quantity of any product or discontinue any product at any time without notice.</p>

            <h2>4. Pricing and Payment</h2>
            <h3>   4.1 Pricing</h3>
            <p>      Prices displayed on our Site are in [Currency] and exclude taxes and shipping unless otherwise stated. We reserve the right to change prices at any time without prior notice.</p>

            <h3>   4.2 Payment</h3>
            <p>      Payments are processed securely through Stripe. By making a purchase, you agree to Stripe’s terms of service. We do not store your payment information.</p>

            <h2>5. Shipping and Delivery</h2>
            <h3>   5.1 Shipping Policy</h3>
            <p>      We ship to [list of locations you ship to]. Shipping costs and estimated delivery times are calculated at checkout.</p>

            <h3>   5.2 Delayed or Lost Shipments</h3>
            <p>      We are not responsible for delays caused by shipping carriers or customs. If your shipment is lost, please contact us for assistance.</p>

            <h2>6. Returns and Refunds</h2>
            <h3>   6.1 Return Policy</h3>
            <p>      We accept returns within [number of days] days of delivery for unworn, unwashed, and undamaged items. Please contact us at [email/contact information] to initiate a return.</p>

            <h3>   6.2 Refund Policy</h3>
            <p>      Refunds will be processed within [number of days] days of receiving the returned item. Shipping costs are non-refundable.</p>

            <h2>7. User Conduct</h2>
            <p>   You agree not to:</p>
            <ul>
                <li>      Use the Site for unlawful purposes.</li>
                <li>      Violate any applicable laws or regulations.</li>
                <li>      Interfere with or disrupt the Site’s functionality.</li>
            </ul>

            <h2>8. Intellectual Property</h2>
            <p>   All content on the Site, including text, images, logos, and designs, is the property of T-SHOP and protected by copyright laws. You may not reproduce, distribute, or create derivative works without our written consent.</p>

            <h2>9. Limitation of Liability</h2>
            <p>   We are not liable for any indirect, incidental, or consequential damages arising from your use of the Site or purchase of our products. Our total liability is limited to the amount paid for the products purchased.</p>

            <h2>10. Privacy Policy</h2>
            <p>   Your privacy is important to us. Please review our <a href="{{ route("privacy-policy") }}">Privacy Policy</a> to understand how we collect, use, and protect your personal information.</p>

            <h2>11. Changes to Terms</h2>
            <p>   We reserve the right to update these Terms and Conditions at any time without prior notice. Your continued use of the Site constitutes your acceptance of the updated terms.</p>

            <h2>12. Governing Law</h2>
            <p>   These Terms and Conditions are governed by and construed in accordance with the laws of [Your Jurisdiction]. Any disputes shall be resolved exclusively in the courts of [Your Jurisdiction].</p>

            <h2>13. Contact Us</h2>
            <p>   For questions or concerns about these Terms and Conditions, please contact us at:</p>
            <p>
                T-SHOP<br>
                   [Email Address]<br>
                   [Phone Number]<br>
                   [Physical Address]
            </p>

            <p>---<br>By using our Site, you acknowledge that you have read, understood, and agreed to these Terms and Conditions.</p>
        </div>

    </main>
@endsection()

