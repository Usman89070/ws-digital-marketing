<?php 
// Form Submission Logic
$email_sent = false;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = strip_tags(trim($_POST["name"]));
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $phone = strip_tags(trim($_POST["phone"]));
    $service = strip_tags(trim($_POST["service"]));
    $message = trim($_POST["message"]);

    $to = "info@wsdigital.com.au";
    $subject = "New Growth Plan Request from " . $name;
    
    $email_content = "Name: $name\n";
    $email_content .= "Email: $email\n";
    $email_content .= "Phone: $phone\n";
    $email_content .= "Service: $service\n\n";
    $email_content .= "Message:\n$message\n";

    $headers = "From: $name <$email>";

    if (mail($to, $subject, $email_content, $headers)) {
        $email_sent = true;
    }
}
include 'header.php'; 
?>

    <!-- CONTACT HERO SECTION -->
    <section class="hero" style="padding-bottom: clamp(40px, 8vw, 80px);">
        <div class="container hero-content">
            <span class="eyebrow fade-up">GET IN TOUCH</span>
            <h1 class="fade-up">LET'S DISCUSS YOUR <br><span class="text-gradient">GROWTH STRATEGY.</span></h1>
            <p class="hero-subtitle fade-up">Ready to scale your business and dominate your market? Reach out to our team today for a zero-obligation growth audit and consultation.</p>
        </div>
    </section>

    <!-- CONTACT SECTION (Form & Info Cards Grid) -->
    <section class="agency-section fade-up" style="background: #ffffff; padding-top: 10px; padding-bottom: 100px;">
        <div class="container">
            
            <?php if ($email_sent): ?>
                <div style="background: #D1E7DD; color: #0F5132; padding: 20px; border-radius: 12px; margin-bottom: 40px; text-align: center; font-weight: 600; border: 1px solid #badbcc;">
                    <i class="fa-solid fa-circle-check" style="margin-right: 8px;"></i> Thank you! Your message has been successfully sent. We will get back to you shortly.
                </div>
            <?php endif; ?>

            <div class="contact-grid" style="display: grid; grid-template-columns: 1fr 1.2fr; gap: clamp(30px, 5vw, 60px); align-items: start;">
                
                <!-- Left Column: Contact Details & Info -->
                <div style="background: var(--bg-secondary); padding: clamp(30px, 5vw, 45px); border-radius: 20px; border: 1px solid var(--border-light); height: 100%; display: flex; flex-direction: column; justify-content: space-between; box-shadow: var(--shadow-sm);">
                    <div>
                        <span class="eyebrow">CONTACT INFORMATION</span>
                        <h2 style="font-size: clamp(1.8rem, 3vw, 2.4rem); color: var(--navy); font-weight: 800; margin-bottom: 15px; line-height: 1.2;">We’re Here To Help You Scale</h2>
                        <p style="color: var(--text-muted); font-size: 0.95rem; line-height: 1.7; margin-bottom: 35px;">Have questions about our SEO, Google Ads, or custom web design services? Drop us a message or give us a call directly.</p>
                        
                        <ul style="list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 22px;">
                            <li style="display: flex; align-items: flex-start; gap: 15px;">
                                <div style="width: 45px; height: 45px; background: rgba(0, 242, 254, 0.1); border: 1px solid rgba(0, 242, 254, 0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: var(--cyan-neon); font-size: 1.1rem; flex-shrink: 0;">
                                    <i class="fa-solid fa-phone"></i>
                                </div>
                                <div>
                                    <h5 style="font-size: 0.75rem; text-transform: uppercase; color: var(--text-muted); font-weight: 700; margin-bottom: 2px; letter-spacing: 1px;">Call Us</h5>
                                    <a href="tel:1300123456" style="color: var(--navy); font-weight: 700; font-size: 1.05rem; text-decoration: none; transition: color 0.3s;">1300 123 456</a>
                                </div>
                            </li>
                            
                            <li style="display: flex; align-items: flex-start; gap: 15px;">
                                <div style="width: 45px; height: 45px; background: rgba(0, 242, 254, 0.1); border: 1px solid rgba(0, 242, 254, 0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: var(--cyan-neon); font-size: 1.1rem; flex-shrink: 0;">
                                    <i class="fa-solid fa-envelope"></i>
                                </div>
                                <div>
                                    <h5 style="font-size: 0.75rem; text-transform: uppercase; color: var(--text-muted); font-weight: 700; margin-bottom: 2px; letter-spacing: 1px;">Email Us</h5>
                                    <a href="mailto:info@wsdigital.com.au" style="color: var(--navy); font-weight: 700; font-size: 1.05rem; text-decoration: none; transition: color 0.3s; word-break: break-all;">info@wsdigital.com.au</a>
                                </div>
                            </li>
                            
                            <li style="display: flex; align-items: flex-start; gap: 15px;">
                                <div style="width: 45px; height: 45px; background: rgba(0, 242, 254, 0.1); border: 1px solid rgba(0, 242, 254, 0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: var(--cyan-neon); font-size: 1.1rem; flex-shrink: 0;">
                                    <i class="fa-solid fa-location-dot"></i>
                                </div>
                                <div>
                                    <h5 style="font-size: 0.75rem; text-transform: uppercase; color: var(--text-muted); font-weight: 700; margin-bottom: 2px; letter-spacing: 1px;">Office Location</h5>
                                    <p style="color: var(--navy); font-weight: 600; font-size: 0.95rem; line-height: 1.5;">Level 32, Sydney, NSW 2000, Australia</p>
                                </div>
                            </li>
                        </ul>
                    </div>

                    <div style="margin-top: 35px; border-top: 1px solid var(--border-light); padding-top: 20px;">
                        <h5 style="font-size: 0.8rem; text-transform: uppercase; color: var(--text-muted); font-weight: 700; margin-bottom: 12px; letter-spacing: 1px;">Follow Our Socials</h5>
                        <div class="social-links" style="display: flex; gap: 10px;">
                            <a href="#" style="width: 38px; height: 38px; border-radius: 50%; background: var(--navy); display: flex; align-items: center; justify-content: center; color: #fff; text-decoration: none; transition: var(--transition-smooth);"><i class="fa-brands fa-facebook-f"></i></a>
                            <a href="#" style="width: 38px; height: 38px; border-radius: 50%; background: var(--navy); display: flex; align-items: center; justify-content: center; color: #fff; text-decoration: none; transition: var(--transition-smooth);"><i class="fa-brands fa-instagram"></i></a>
                            <a href="#" style="width: 38px; height: 38px; border-radius: 50%; background: var(--navy); display: flex; align-items: center; justify-content: center; color: #fff; text-decoration: none; transition: var(--transition-smooth);"><i class="fa-brands fa-linkedin-in"></i></a>
                            <a href="#" style="width: 38px; height: 38px; border-radius: 50%; background: var(--navy); display: flex; align-items: center; justify-content: center; color: #fff; text-decoration: none; transition: var(--transition-smooth);"><i class="fa-brands fa-x-twitter"></i></a>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Interactive Contact Form -->
                <div style="background: #ffffff; padding: clamp(30px, 5vw, 45px); border-radius: 20px; border: 1px solid var(--border-light); box-shadow: var(--shadow-md);">
                    <span class="eyebrow">SEND US A MESSAGE</span>
                    <h2 style="font-size: clamp(1.8rem, 3vw, 2.4rem); color: var(--navy); font-weight: 800; margin-bottom: 25px;">Request Your Free Growth Plan</h2>
                    
                    <form action="contact.php" method="POST" style="display: flex; flex-direction: column; gap: 18px;">
                        <div class="form-row" style="display: grid; grid-template-columns: 1fr 1fr; gap: 18px;">
                            <div style="display: flex; flex-direction: column; gap: 6px;">
                                <label style="font-size: 0.8rem; font-weight: 700; color: var(--navy); text-transform: uppercase;">Your Name *</label>
                                <input type="text" name="name" placeholder="John Smith" required style="padding: 14px; border-radius: 8px; border: 1px solid var(--border-light); font-size: 0.95rem; outline: none; background: var(--bg-secondary); width: 100%;">
                            </div>
                            <div style="display: flex; flex-direction: column; gap: 6px;">
                                <label style="font-size: 0.8rem; font-weight: 700; color: var(--navy); text-transform: uppercase;">Email Address *</label>
                                <input type="email" name="email" placeholder="john@example.com" required style="padding: 14px; border-radius: 8px; border: 1px solid var(--border-light); font-size: 0.95rem; outline: none; background: var(--bg-secondary); width: 100%;">
                            </div>
                        </div>

                        <div class="form-row" style="display: grid; grid-template-columns: 1fr 1fr; gap: 18px;">
                            <div style="display: flex; flex-direction: column; gap: 6px;">
                                <label style="font-size: 0.8rem; font-weight: 700; color: var(--navy); text-transform: uppercase;">Phone Number</label>
                                <input type="tel" name="phone" placeholder="0400 000 000" style="padding: 14px; border-radius: 8px; border: 1px solid var(--border-light); font-size: 0.95rem; outline: none; background: var(--bg-secondary); width: 100%;">
                            </div>
                            <div style="display: flex; flex-direction: column; gap: 6px;">
                                <label style="font-size: 0.8rem; font-weight: 700; color: var(--navy); text-transform: uppercase;">Service Needed</label>
                                <select name="service" style="padding: 14px; border-radius: 8px; border: 1px solid var(--border-light); font-size: 0.95rem; outline: none; background: var(--bg-secondary); color: var(--navy); width: 100%;">
                                    <option value="Search Engine Optimization">Search Engine Optimization</option>
                                    <option value="E-commerce">E-commerce Solutions</option>
                                    <option value="Website Development">Website Development & Design</option>
                                    <option value="Social Media">Social Media Marketing</option>
                                    <option value="PPC Advertising">PPC & Google Ads</option>
                                </select>
                            </div>
                        </div>

                        <div style="display: flex; flex-direction: column; gap: 6px;">
                            <label style="font-size: 0.8rem; font-weight: 700; color: var(--navy); text-transform: uppercase;">Tell Us About Your Project *</label>
                            <textarea name="message" rows="4" placeholder="Share your goals, current challenges, or what you'd like to achieve..." required style="padding: 14px; border-radius: 8px; border: 1px solid var(--border-light); font-size: 0.95rem; outline: none; background: var(--bg-secondary); resize: vertical; width: 100%;"></textarea>
                        </div>

                        <button type="submit" class="btn-primary" style="width: 100%; padding: 16px; font-size: 1rem; margin-top: 5px; cursor: pointer;">SUBMIT GROWTH REQUEST <i class="fa-solid fa-arrow-right" style="margin-left: 5px;"></i></button>
                    </form>
                </div>

            </div>
        </div>
    </section>

    <!-- Inline Responsive Styling for Contact Page Grid & Form Rows -->
    <style>
        @media(max-width: 1024px) {
            .contact-grid {
                grid-template-columns: 1fr !important;
                gap: 40px !important;
            }
        }
        @media(max-width: 576px) {
            .form-row {
                grid-template-columns: 1fr !important;
            }
        }
    </style>

<?php include 'footer.php'; ?>