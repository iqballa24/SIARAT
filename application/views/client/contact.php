    <main>
        <!-- contact-section -->
        <section class="contact-section">
            <div class="contact-formBx">
                <form name="submit-to-google-sheet" action="">
                    <h1 class="h1-custom">Get in touch</h1>
                    <div class="inputBox">
                        <input type="text" name="nama" required>
                        <span>Full Name</span>
                    </div>
                    <div class="inputBox">
                        <input type="email" name="email" required>
                        <span>Email Address</span>
                    </div>
                    <div class="inputBox">
                        <textarea name="pesan" id="" cols="30" rows="10" required></textarea>
                        <span>Type Your Message Here...</span>
                    </div>
                        <button type="submit" class="button button-primary button-kirim">Submit</button>
                        <button type="submit" class="button button-primary button-loading d-none">
                            <span class="spinner-border spinner-border-md" role="status" aria-hidden="true"></span>
                            Loading...
                        </button>
                </form>
            </div>
            <div class="contact-imgBx">
                <!-- <img src="./assets/img/girl.png" alt=""> -->
                <img src="<?= base_url('assets/img/vector/pana.svg'); ?>" alt="">
            </div>
        </section>

        <!-- Message -->
        <div id="notif-info" class="notif-info">
            <i class="fas fa-info-circle"></i> Your message was delivered
        </div>

    </main>

    <script>
        const scriptURL = 'https://script.google.com/macros/s/AKfycbxgeknhjdnQ6Gb8PL1rRjBKrZC5Dp0r8_Jqr2Snb3fw2J0wD224qFCHe7jW52Hvd72C/exec'
        const form       = document.forms['submit-to-google-sheet']
        const btnKirim   = document.querySelector('.button-kirim');
        const btnLoading = document.querySelector('.button-loading');
      
        form.addEventListener('submit', e => {

            e.preventDefault()
            // When click submit, show loading button and hide submit button
            btnLoading.classList.toggle('d-none');
            btnKirim.classList.toggle('d-none');

            fetch(scriptURL, { method: 'POST', body: new FormData(form)})
                .then(response => {
                    console.log('Success!', response)
                    btnLoading.classList.toggle('d-none');
                    btnKirim.classList.toggle('d-none');
                    form.reset();
                    showMessage()
                })
                .catch(error => console.error('Error!', error.message))
        });

        function showMessage() {
            const notif = document.getElementById("notif-info");
            notif.classList.add("show");
            setTimeout( _ =>
                { 
                    notif.className = notif.className.replace("show", ""); 
                }, 3000);
        }
    </script>