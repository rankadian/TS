<!DOCTYPE html>
<html>
<head>
    <!-- Sertakan semua CSS yang sama dengan landing page -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Black+Han+Sans&family=Urbanist:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta charset="utf-8" />
    <link rel="stylesheet" href="{{ asset('globals.css') }}" />
    <link rel="stylesheet" href="{{ asset('styleguide.css') }}" />
    <link rel="stylesheet" href="{{ asset('style.css') }}" />
    <!-- Bootstrap untuk accordion -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>FAQ - GRAD Journey</title>
</head>
<body>
    <div class="landing-page">
        <!-- Header yang sama dengan landing page -->
        <header class="header">
            <div class="frame-19">
                <img class="GRAD-JOURNEY-LOGO" src="{{ asset('img/GRAD JOURNEY LOGO 1.png') }}" />
                <div class="text-9">GRAD Journey</div>
            </div>
            <div class="frame-20">
                <button class="frame-21" onclick="window.location.href='/about'">
                    <span class="text-wrapper-8">About</span></button>
                <button class="frame-21" onclick="window.location.href='/faq'">
                    <span class="text-wrapper-8">F.A.Q</span></button>
                <button class="frame-21" onclick="window.location.href='/contact'">
                    <span class="text-wrapper-8">Contact</span></button>
            </div>
        </header>

        <!-- Konten FAQ -->
        <div class="faq-container" style="padding: 50px 10%; background: white;">
            <h1 style="font-family: 'Black Han Sans', sans-serif; font-size: 3rem; color: #1e3c72; margin-bottom: 30px;">Frequently Asked Questions</h1>
            
            <div class="accordion" id="faqAccordion">
                <!-- Question 1 -->
                <div class="accordion-item mb-3">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne">
                            What is a tracer study?
                        </button>
                    </h2>
                    <div id="collapseOne" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            A tracer study is a research method that tracks the career paths and professional development of graduates after they leave an educational institution.
                        </div>
                    </div>
                </div>

                <!-- Question 2 -->
                <div class="accordion-item mb-3">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo">
                            Who should participate in GRAD Journey?
                        </button>
                    </h2>
                    <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            All graduates of Politeknik Negeri Malang are encouraged to participate in GRAD Journey.
                        </div>
                    </div>
                </div>

                <!-- Tambahkan pertanyaan lain sesuai kebutuhan -->
            </div>
        </div>

        <!-- Footer yang sama dengan landing page -->
        <div class="container">
            <div class="sub-link-container">
                <p class="link">@2025 GRAD journey. All Rights Reserved.</p>
                <div class="link">Terms & Conditions</div>
            </div>
            <div class="social-icon">
                <div class="button"><img class="icon" src="{{ asset('img/icon.svg') }}" /></div>
                <div class="button"><img class="icon" src="{{ asset('img/icon2.svg') }}" /></div>
                <div class="button"><img class="icon" src="{{ asset('img/icon3.svg') }}" /></div>
                <div class="button"><img class="icon" src="{{ asset('img/icon4.svg') }}" /></div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>