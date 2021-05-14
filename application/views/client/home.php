    <main>  
        <!-- About section -->
        <section id="about-section" class="about-section">
            <div class="container">
                <div class="row flex-column-reverse flex-lg-row">
                    <div class="col-lg-9 align-self-center about-text">
                        <h1 class="h1-custom">Tentang LSP HCMI</h1>
                        <p class="mt-5">LSP HCMI adalah LSP Pihak 3 yang akan melayani seluruh karyawan BUMN dan BUMD juga karyawan swasta atau siapa saja yang membutuhkan sertifikasi bidang SDM / Human Capital</p>
                        <a class="button button-secondary mt-5" href="<?= site_url('about'); ?>">Selengkapnya</a>
                    </div>
                    <div class="col-lg-3 about-img text-center">
                        <img class="fluid" src="<?= base_url('assets/img/vector/logo-lsp.svg'); ?>" alt="logo LSP HCMI" style="max-width: 20rem;">
                    </div>
                </div>
            </div>
        </section>

        <!-- Skema section -->
        <div class="skema-section">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6">
                        <img class="fluid text-center" src="<?= base_url('assets/img/vector/card-skema.svg'); ?>" alt="skema sertifikasi">
                    </div>
                    <div class="col-lg-6 align-self-center skema-text">
                        <h1 class="h1-custom mb-5">Skema Sertifikasi</h1>
                        <p>LSP HCMI mengacu pada skema sertifikasi berdasarkan paket kompetensi atau klaster. LSP HCMI memiliki 3 skema kompetensi yg mengacu pada SKKNI (<a href="<?= base_url('assets/pdf/SKKNI 2020-149.pdf.pdf'); ?>" style="text-decoration: none; color: #CF2932;" target="_blank">SKKNI No.149 Tahun 2020</a>, <a href="<?= base_url('assets/pdf/SKKNI No.072 Th.2019-Hubungan Industrial New.pdf'); ?>" style="text-decoration: none; color: #CF2932;" target="_blank">SKKNI No. 72 Tahun 2019</a>) yaitu skema perencanaan human capital, skema pengembangan human capital, dan skema pengelolaan hubungan industrial.</p>
                        <a class="button button-secondary mt-5" href="<?=  site_url('scheme'); ?>">Selengkapnya</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- peserta-section -->
        <section class="peserta-section">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 align-self-center">
                        <h1 class="h1-custom mb-5">Peserta <br> Uji kompetensi</h1>
                        <div class="overflow-y">
                            <div class="card card-peserta">
                                <div class="row card-body">
                                    <div class="col-2 icon">
                                        <i class="far fa-user" style="font-size: 1.6rem;"></i>
                                    </div>
                                    <div class="col-10 align-self-center">
                                        <p class="mt-auto mb-auto">BOD -1 s/d BOD -3</p>
                                    </div>
                                </div>
                            </div>
                            <div class="card card-peserta">
                                <div class="row card-body">
                                    <div class="col-2 icon">
                                        <i class="far fa-user" style="font-size: 1.6rem;"></i>
                                    </div>
                                    <div class="col-10 align-self-center">
                                        <p class="mt-auto mb-auto">Staff HRD</p>
                                    </div>
                                </div>
                            </div>
                            <div class="card card-peserta">
                                <div class="row card-body">
                                    <div class="col-2 icon">
                                        <i class="far fa-user" style="font-size: 1.6rem;"></i>
                                    </div>
                                    <div class="col-10 align-self-center">
                                        <p class="mt-auto mb-auto">Manajer</p>
                                    </div>
                                </div>
                            </div>
                            <div class="card card-peserta">
                                <div class="row card-body">
                                    <div class="col-2 icon">
                                        <i class="far fa-user" style="font-size: 1.6rem;"></i>
                                    </div>
                                    <div class="col-10 align-self-center">
                                        <p class="mt-auto mb-auto">Kepala Divisi</p>
                                    </div>
                                </div>
                            </div>
                            <div class="card card-peserta">
                                <div class="row card-body">
                                    <div class="col-2 icon align-self-center">
                                        <i class="far fa-user" style="font-size: 1.6rem;"></i>
                                    </div>
                                    <div class="col-10">
                                        <p class="mt-auto mb-auto">Setiap orang yang ingin memiliki sertifikasi kompetensi HC</p>
                                    </div>
                                </div>
                            </div>
                            <div class="card card-peserta">
                                <div class="row card-body">
                                    <div class="col-2 icon align-self-center">
                                        <i class="far fa-user" style="font-size: 1.6rem;"></i>
                                    </div>
                                    <div class="col-10">
                                        <p class="mt-auto mb-auto">BUMN, BUMD dan perusahaan swasta</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 right-side">
                        <img class="fluid" src="<?= base_url('assets/img/vector/img-competens.svg'); ?>" alt="peserta kompetensi">
                    </div>
                </div>
            </div>
        </section>

        <!-- step section -->
        <section class="step-section text-center">
            <div class="container">
                <div class="row">
                    <div class="col-12 mb-5">
                        <h1 class="h1-custom">3 Tahap Mudah Untuk Mendaftar</h1>
                    </div>
                    <div class="col-12">
                        <div class="row">
                            <div class="col-lg-4 step-box">
                                <object class="step-icon" type="image/svg+xml" data="<?= base_url('assets/img/vector/icon-unduh.svg'); ?>"></object>
                                <h1>Unduh Form APL 01 & APL02</h1>
                                <p>Unduh sesuai dengan skema<br> yang ingin di ambil</p>
                            </div>
                            <div class="col-lg-4 step-box">
                                <object class="step-icon" type="image/svg+xml" data="<?= base_url('assets/img/vector/icon-berkas.svg'); ?>"></object>
                                <h1>Melengkapi Berkas</h1>
                                <p>Lengkapi berkas syarat <br> pendaftaran</p>
                            </div>
                            <div class="col-lg-4 step-box">
                                <object class="step-icon" type="image/svg+xml" data="<?= base_url('assets/img/vector/icon-daftar.svg'); ?>"></object>
                                <h1>Klik button daftar</h1>
                                <p>Klik button daftar yang <br> terdapat di kanan atas</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- schedule section -->
        <section class="schedule-section">
            <div class="container">
                <div class="row">
                    <div class="col-12 mb-5 text-center">
                        <h1 class="mb-5">Jadwal Uji kompetensi</h1>
                        <img class="schedule-calendar" src="<?= base_url('assets/img/calendar.jpg'); ?>" alt="jadwal uji kompetensi" onclick="openModalCalendar()" style="cursor: zoom-in;">
                    </div>  
                    <div class="col-12 mb-5">
                        <h1 class="mb-5">Syarat Berkas Pendaftaran</h1>
                        <ul class="list-syarat">
                            <li class="list-item">Sertifikat yang Relevan / Surat atau Program Penghargaan / SK.Jabatan / Rekomendasi Pimpinan</li>
                            <li class="list-item">CV</li>
                            <li class="list-item">Ijazah</li>
                            <li class="list-item">Bukti hasil kerja : produk / dokumen yang pernah dibuat</li>
                            <li class="list-item">Pas foto 3x4 (4 lembar background merah)</li>
                            <li class="list-item">KTP</li>
                            <li class="list-item">Bahan presentasi sesuai dengan skema masing-masing (Refer : silahkan unduh <a
                                href="<?= base_url('assets/pdf/SKKNI.zip'); ?>">SKKNI</a>)</li>
                        </ul>
                    </div>
                    <div class="col-12">
                        <h1 id="apl" class="mb-5 text-center">Dokumen APL 01 & APL 02</h1>
                        <div class="row">
                            <div class="col-md-4 text-center">
                              <a class="button button-skema" href="<?= base_url('assets/pdf/SKEMA PERENCANAAN HC.docx'); ?>" download target="__blank">Unduh Skema
                                Perencanaan Human <br class="d-none d-xl-block">Capital</a>
                            </div>
                            <div class="col-md-4 text-center">
                              <a class="button button-skema" href="<?= base_url('assets/pdf/SKEMA PENGEMBANGAN HC.docx'); ?>" download target="__blank">Unduh Skema
                                Pengembangan Human Capital</a>
                            </div>
                            <div class="col-md-4 text-center">
                              <a class="button button-skema" href="<?= base_url('assets/pdf/SKEMA PENGELOLAAN HUBUNGAN INDUSTRIAL.docx'); ?>" download
                                target="__blank">Unduh Skema Pengelolaan Hubungan Industrial</a>
                            </div>
                          </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- law section -->
        <section class="law-section text-center">
            <div class="container">
                <div class="raw">
                    <div class="col mb-5">
                        <h1 class="h1-custom">
                            Dasar Hukum
                        </h1>
                    </div>
                    <div class="col">
                        <div class="row">
                            <div class="col-lg-4 col-md-6">
                                <div class="card card-law">
                                    <img class="fluid" src="<?= base_url('assets/img/vector/codicon_law.svg'); ?>" class="card-img-top" alt="hukum" width="80rem" style="margin-left: auto; margin-right: auto;">
                                    <div class="card-body">
                                      <p class="card-text">UU No.3 th.2003 
                                        tentang ketenagakerjaan. </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6">
                                <div class="card card-law">
                                    <img class="fluid" src="<?= base_url('assets/img/vector/codicon_law.svg'); ?>" class="card-img-top" alt="hukum" width="80rem" style="margin-left: auto; margin-right: auto;">
                                    <div class="card-body">
                                      <p class="card-text">PP RI no.23 th.2004 tentang BNSP.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6">
                                <div class="card card-law">
                                    <img class="fluid" src="<?= base_url('assets/img/vector/codicon_law.svg'); ?>" class="card-img-top" alt="hukum" width="80rem" style="margin-left: auto; margin-right: auto;">
                                    <div class="card-body">
                                      <p class="card-text">PP RI no.31 th.2006 tentang sistem pelatihan kerja nasional.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6">
                                <div class="card card-law">
                                    <img class="img-fluid" src="<?= base_url('assets/img/vector/codicon_law.svg'); ?>" class="card-img-top" alt="hukum" width="80rem" style="margin-left: auto; margin-right: auto;">
                                    <div class="card-body">
                                      <p class="card-text">Peraturan Presiden Republik Indonesia no.8 th.2012 tentang kerangka kualifikasi Nasional Indonesia.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6">
                                <div class="card card-law">
                                    <img class="fluid" src="<?= base_url('assets/img/vector/codicon_law.svg'); ?>" class="card-img-top" alt="hukum" width="80rem" style="margin-left: auto; margin-right: auto;">
                                    <div class="card-body">
                                      <p class="card-text">Peraturan Menteri Tenaga Kerja dan Transmigrasi Republik Indonesia no.5 th.2012 tentang Sistem Standarisasi Kompetensi Kerja Nasional.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- komitmen section -->
        <section class="komitmen-section text-center">
            <div class="container">
                <div class="row">
                    <div class="col-12 mb-5">
                        <h1 class="h1-custom">Komitmen Manajemen</h1>
                    </div>
                    <div class="col-12">
                        <p>LSP HCMI mempunyai berkomitmen terhadap ketidakberpihakan, mengelola konflik kepentingan, dan menjamin obyektivitas kegiatan sertifikasi profesi serta mendukung terwujudnya proses sertifikasi yg jujur, profesional, dan peduli pada kompetensi insani</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- galery section -->
        <section class="galery-section text-center">
            <div class="container">
                <h1 class="h1-custom mb-5">Dokumentasi Kegiatan</h1>
                <div class="row mb-5">
                    <div class="col-lg-5 mb-5" style="overflow: hidden;">
                        <img class="fluid img-hover__zoom-colorize" src="<?= base_url('assets/img/pelatihan 3 1.jpg'); ?>" alt="">
                    </div>
                    <div class="col-lg-7">
                        <div class="row">
                            <div class="col-lg-12 mb-5" style="overflow: hidden;">
                                <img class="fluid img-hover__zoom-colorize" src="<?= base_url('assets/img/ujikom 16 1.jpg'); ?>" alt="">
                            </div>
                            <div class="col-lg-12 mb-5" style="overflow: hidden;">
                                <img class="fluid img-hover__zoom-colorize" src="<?= base_url('assets/img/pelatihan 4 1.jpg'); ?>" alt="">
                            </div>
                        </div>
                    </div>
                    <div class="col-12" style="overflow: hidden;">
                        <img class="fluid img-hover__zoom-colorize" src="<?= base_url('assets/img/ujikom 6 1.jpg'); ?>" alt="">
                    </div>
                </div>
                <a href="<?= site_url('gallery'); ?>">
                    <p class="galery-p">See more</p>
                </a>
            </div>
        </section>

        <!-- modal calendar -->
        <div id="myModalCalendar" class="modal-box">
            <span class="close cursor" onclick="closeModalCalendar()">&times;</span>
            <div class="modal-content">
                <img src="<?= base_url('assets/img/calendar.jpg'); ?>" alt="calendar" style="width: 100%;">
            </div>
        </div>

    </main>