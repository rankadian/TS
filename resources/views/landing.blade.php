<!DOCTYPE html>
<html>
    <head>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Black+Han+Sans&family=Urbanist:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta charset="utf-8" />
        <link rel="stylesheet" href="globals.css" />
        <link rel="stylesheet" href="styleguide.css" />
        <link rel="stylesheet" href="style.css" />
     <script src="https://cdn.jsdelivr.net/npm/three@0.132.2/build/three.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/three@0.132.2/examples/js/controls/OrbitControls.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/three@0.132.2/examples/js/loaders/GLTFLoader.min.js"></script>
    <script src="js/robot-viewer.js" defer></script>
    <script src="js/script.js" defer></script>
    </head>
    <body>
        <div class="landing-page">
            <div class="div">
                <div class="overlap">
                    <div class="group">
                        <div class="overlap-group">
                            <div class="BLUE-WAVE"><img class="blue-wave" src="img/blue wave 1.png" /></div>
                            <div class="blue-WAVE-wrapper"><img class="blue-WAVE" src="img/blue WAVE 2.png" /></div>
                            <div class="frame">
                                <div class="frame-2">
                                    <p class="what-is-GRAD-journey">What is <br />GRAD Journey ?</p>
                                    <p class="what-are-the">What Are the <br />Objectives of GRAD Journey ?</p>
                                </div>
                                <div class="frame-3">
                                    <div class="frame-4"></div>
                                    <img class="circle" src="img/circle_13977398 2.png" />
                                    <div class="frame-5"></div>
                                    <img class="circle" src="img/circle_13977398 1.png" />
                                    <div class="frame-6"></div>
                                </div>
                                <div class="frame-7">
                                    <p class="text">
                                        GRAD Journey is a tracer study platform designed to collect and analyze the career trajectories of
                                        Politeknik Negeri Malang alumni. This system enables the institution to assess curriculum relevance,
                                        the quality of its graduates, and to foster stronger alumni relations.
                                    </p>
                                    <p class="text-wrapper">
                                        GRAD Journey aims to gather comprehensive data on the professional journeys of alumni, including
                                        their employment, further studies, and career progression. This data is crucial for evaluating and
                                        improving the curriculum, ensuring that academic programs meet industry standards. Additionally, the
                                        platform helps maintain strong relationships between alumni and the campus community, encouraging
                                        collaboration and future contributions.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="overlap-wrapper">
                        <div class="overlap-2">
                            <div class="GREY-WAVE"><img class="WAVE-BACKGROUND" src="img/WAVE BACKGROUND 2.png" /></div>
                            <div class="frame-8">
                                <div class="frame-9">
                                    <img class="img" src="img/graduation_4270377.png" />
                                    <div class="text-wrapper-2">Alumni Tracking</div>
                                    <p class="p">Easily Update Your Career Progress and Stay Connected</p>
                                </div>
                                <div class="frame-10">
                                    <div class="text-wrapper-3">Interactive Survey</div>
                                    <p class="text-2">Simple and responsive Tracer Study forms</p>
                                    <img class="img" src="img/survey_7026654.png" />
                                </div>
                                <div class="frame-11">
                                    <p class="text-wrapper-4">Real - Time Data Dasboard</p>
                                    <p class="text-3">Visual Insight for institutions based on alumni outcomes</p>
                                    <img class="img" src="img/real-time_6283154.png" />
                                </div>
                                <div class="frame-11">
                                    <div class="data-export">Data Export &amp; Reporting</div>
                                    <p class="text-3">Export data in various formats for academic or research purposes.</p>
                                    <img class="file-transfer" src="img/file-transfer_14636212.png" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="frame-12">
                        <div class="frame-wrapper">
                            <div class="frame-13">
                                <img class="LOGIN-VECTOR" src="img/LOGIN VECTOR.png" />
                                <p class="text-4">Graduates are required to log in through email verification.</p>
                            </div>
                        </div>
                        <div class="div-wrapper">
                            <div class="frame-13">
                                <p class="text-5">Administrators are able to download reports or view graphical results</p>
                                <img class="ADMIN-VECTOR" src="img/ADMIN VECTOR.png" />
                            </div>
                        </div>
                        <div class="frame-14">
                            <div class="frame-13">
                                <div class="overlap-group-2">
                                    <p class="text-6">The system automatically collects and analyzes the data</p>
                                    <img class="DATA-COLECTION" src="img/DATA COLECTION VECTOR.png" />
                                </div>
                            </div>
                        </div>
                        <div class="frame-15">
                            <div class="frame-13">
                                <img class="COMPLETE-TRACER" src="img/COMPLETE TRACER STUDY VECTOR.png" />
                                <p class="text-7">Graduates are requested to fill out the Tracer Study survey</p>
                            </div>
                        </div>
                    </div>
                    <div class="groub">
                        <div class="overlap-3">
                            <div class="WAVE-BACKGROUND-wrapper">
                                <img class="WAVE-BACKGROUND-2" src="img/WAVE BACKGROUND 3.png" />
                            </div>
                            <div class="frame-16">
                                <div id="robot-container" style="position: absolute; width: 600px; height: 600px; top: 300px; left: 1200px; z-index: 10;">
                                <div id="viewer" style="width: 100%; height: 100%;"></div>
                                </div>
                                <div class="frame-17">
                                    <p class="heading">
                                        <span class="span">Welcome To <br /></span>
                                        <span class="text-wrapper-5">GRAD</span>
                                        <span class="text-wrapper-6">&nbsp;</span>
                                        <span class="text-wrapper-7">Journey</span>
                                    </p>
                                    <p class="paragraph">
                                        The alumni tracer study system of Politeknik Negeri Malang to trace the career paths and
                                        contributions of graduates to improve the quality of education.
                                    </p>
                                </div>
                                <button class="frame-18" onclick="window.location.href='/login'">
                                  <div class="text-8">Log in</div>
                                </button>
                            </div>
                            <header class="header">
                                <div class="frame-19">
                                    <img class="GRAD-JOURNEY-LOGO" src="img/GRAD JOURNEY LOGO 1.png" />
                                    <div class="text-9">GRAD Journey</div>
                                </div>
                                <div class="frame-20">
                                    <div class="frame-21"><div class="text-wrapper-8">About</div></div>
                                    <div class="frame-21"><div class="text-wrapper-8">F.A.Q</div></div>
                                    <div class="frame-21"><div class="text-wrapper-8">Contact</div></div>
                                </div>
                            </header>
                        </div>
                    </div>
                </div>
                <div class="container">
                    <div class="sub-link-container">
                        <p class="link">@2025 GRAD journey. All Rights Reserved.</p>
                        <div class="link">Terms &amp; Conditions</div>
                    </div>
                    <div class="social-icon">
                        <div class="button"><img class="icon" src="img/icon.svg" /></div>
                        <div class="button"><img class="icon" src="img/icon2.svg" /></div>
                        <div class="button"><img class="icon" src="img/icon3.svg" /></div>
                        <div class="button"><img class="icon" src="img/icon4.svg" /></div>
                    </div>
                </div>
                <div class="group-2">
                    <div class="text-wrapper-9">Home</div>
                    <div class="frame-22">
                        <div class="column">
                            <div class="text-wrapper-10">Contact Us</div>
                            <div class="link-container">
                                <div class="link-2">Politeknik Negeri Malang</div>
                                <div class="link-3">Email :<br />info@gradJourney.id</div>
                            </div>
                        </div>
                        <div class="link-3">Phone :<br />087760409688</div>
                    </div>
                    <div class="link-container-2">
                        <div class="link-2">Hero Section</div>
                        <div class="link-4">Features</div>
                        <div class="link-4">FAQ’s</div>
                    </div>
                    <div class="frame-23">
                        <img class="chatgpt-image-may" src="img/ChatGPT Image May 22, 2025, 02_37_47 AM (1) 1.png" />
                        <div class="text-10">GRAD Journey</div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
