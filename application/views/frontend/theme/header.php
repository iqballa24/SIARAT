    <header>
        <nav class="nav">
            <div id="navbar" class="nav-container">
                <a href="javascript:void(0)" class="nav-logo">
                    <img class="img-fluid logo" src="<?= base_url('assets/img/vector/logo.svg'); ?>" alt="logo">
                    <span class="logo-text">LSP HCMI</span>
                </a>
                <ul class="nav-menus">
                    <div class="btn-cancel">
                        <p>&#10006;</p>
                    </div>
                    <?php $active = $this->uri->segment(1)?>
                    <li><a class="nav-item <?php if ($active == 'home' || $active == "") echo "active"; ?>"href="<?= site_url('home'); ?>">Beranda</a></li>
                    <li><a class="nav-item <?php if ($active == 'about') echo "active"; ?>" href="<?= site_url('about'); ?>">Tentang</a></li>
                    <li><a class="nav-item <?php if ($active == 'scheme') echo "active"; ?>" href="<?= site_url('scheme'); ?>">Skema</a></li>
                    <li><a class="nav-item <?php if ($active == 'gallery') echo "active"; ?>" href="<?= site_url('gallery'); ?>">Galeri</a></li>
                    <li><a class="nav-item <?php if ($active == 'contact') echo "active"; ?>" href="<?= site_url('contact'); ?>">Kontak</a></li>
                    <li><a onclick="openModalRegister()" class="button button-primary" href="javascript:void(0)">Daftar</a></li>
                </ul>
                <label id="btn-toggler" for="check">
                    <input type="checkbox" id="check"/> 
                    <span class="nav-span"></span>
                    <span class="nav-span"></span>
                    <span class="nav-span"></span>
                </label>
            </div>
        </nav>
    </header>