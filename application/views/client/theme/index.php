<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- logo -->
    <link href="<?= base_url('assets\img\vector\logo.svg'); ?>" rel="icon">
    <link href="<?= base_url('assets\img\vector\logo.svg'); ?>" rel="apple-touch-icon">

    <!-- css -->
    <link rel="stylesheet" href="<?= base_url('assets/vendor/bootstrap/dist/css/bootstrap.min.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/main.css'); ?>">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <!-- js -->
    <script defer src="<?= base_url('assets/vendor/fontawesome-free/js/brands.js'); ?>"></script>
    <script defer src="<?= base_url('assets/vendor/fontawesome-free/js/solid.js'); ?>"></script>
    <script defer src="<?= base_url('assets/vendor/fontawesome-free/js/regular.js'); ?>"></script>
    <script defer src="<?= base_url('assets/vendor/fontawesome-free/js/fontawesome.js'); ?>"></script>
    <title>LSP HCMI</title>
</head>

<body>
    <!-- load header -->
    <?php $this->load->view('client/theme/header');; ?>

    <main>
        <!-- preloader -->
        <div id="preloader" class="preloader">
            <div id="precontent" class="preloader-content">
                <img src="<?= base_url('assets/img/Ripple-1.3s-211px.gif'); ?>" alt="preloader" width="85rem">
            </div>
        </div>

        <!-- Hero section -->
        <?php $active = $this->uri->segment(1)?>
        <section class="carousel-section <?php if ($active == 'contact') echo "d-none"; ?>">
            <div class="carousel-text">
                <h1>Lembaga Sertifikasi Profesi Human Capital Management Indonesia</h1>
                <a href="#" class="scroll-down" address="true"></a>
            </div>
        </section>

        <!-- Target btn scroll down -->
        <section id="scroll-down"></section>

        <!-- load main content -->
        <?php $this->load->view('client/'.$theme_page); ?>

        <!-- modal daftar -->
        <div id="myModalRegister" class="modal-daftar">
            <div class="modal-content">
                <span class="close cursor" onclick="closeModalRegister()">&times;</span>
                <div class="row text-center">
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-12 mb-5 sertifikasi-section">
                                <img class="fluid" src="<?= base_url('assets/img/vector/vector_certificate.svg'); ?>" alt="Sertifikasi LSP HCMI">
                            </div>
                            <div class="col-12">
                                <a href="https://forms.gle/3a3tkBiFQHPFEGLc7" class="button button-primary" target="_blank">Sertifikasi</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 pelatihan-section">
                        <div class="row">
                            <div class="col-12 mb-5">
                                <img class="fluid" src="<?= base_url('assets/img/vector/vector_education.svg'); ?>" alt="Pelatihan LSP HCMI">
                            </div>
                            <div class="col-12">
                                <a href="https://forms.gle/NLqUb8nmafUfxvLw9" class="button button-primary" target="_blank">Pelatihan</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Float button -->
        <a href="#" class="button-float" id="goto-top">
            <i class="fas fa-caret-up my-float"></i>
        </a>
    </main>

    <!-- load footer -->
    <?php $this->load->view('client/theme/footer');; ?>

    <!-- js -->
    <script src="<?= base_url('assets/vendor/jquery/dist/jquery.min.js'); ?>"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="<?= base_url('assets/js/index.js'); ?>"></script>
    <!-- Start of LiveChat (www.livechatinc.com) code -->
    <script>
        window.__lc = window.__lc || {};
        window.__lc.license = 12777132;
        ;(function(n,t,c){function i(n){return e._h?e._h.apply(null,n):e._q.push(n)}var e={_q:[],_h:null,_v:"2.0",on:function(){i(["on",c.call(arguments)])},once:function(){i(["once",c.call(arguments)])},off:function(){i(["off",c.call(arguments)])},get:function(){if(!e._h)throw new Error("[LiveChatWidget] You can't use getters before load.");return i(["get",c.call(arguments)])},call:function(){i(["call",c.call(arguments)])},init:function(){var n=t.createElement("script");n.async=!0,n.type="text/javascript",n.src="https://cdn.livechatinc.com/tracking.js",t.head.appendChild(n)}};!n.__lc.asyncInit&&e.init(),n.LiveChatWidget=n.LiveChatWidget||e}(window,document,[].slice))
    </script>
    <noscript><a href="https://www.livechatinc.com/chat-with/12777132/" rel="nofollow">Chat with us</a>, powered by <a href="https://www.livechatinc.com/?welcome" rel="noopener nofollow" target="_blank">LiveChat</a></noscript>
    <!-- End of LiveChat code -->



</body>

</html>