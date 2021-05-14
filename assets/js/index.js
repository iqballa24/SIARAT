window.onload = _ => {
    // Load preloader 
    function preloader() {
        const preloader          = document.getElementById('preloader');
        const precontent         = document.getElementById('precontent');
        preloader.style.height   = '0vh';
        precontent.style.display = 'none';
    };
    setTimeout(preloader, 500);
}

document.addEventListener('DOMContentLoaded', _ => {

    // triger action navbar on medium-small device
    const btn_toggler = document.querySelector("#btn-toggler");
    const navbar_menu = document.querySelector(".nav-menus");
    const btnCancel   = document.querySelector(".btn-cancel");

    btn_toggler.onclick = _ =>{
        navbar_menu.classList.add('show');
        document.body.classList.add('disabledScroll');
    };
    btnCancel.onclick = _ => {
        navbar_menu.classList.remove("show");
        document.body.classList.remove("disabledScroll");
    };

    let prevScrollpos = window.pageYOffset;

    window.onscroll = () => {
        const nav   = document.querySelector('#navbar');
        const logo  = document.querySelector('.logo-text');

        // change color navbar when scroll
        if(this.scrollY <= 10) {
            nav.className           = "nav-container"; 
            logo.style.color        = "#fff";
            btn_toggler.style.top   = "4.9rem";
            nav.style.paddingTop    = "4rem";

        }else{
            nav.className           = "nav-container scroll";
            logo.style.color        = "#CF2932";
            btn_toggler.style.top   = "3rem";
            nav.style.paddingTop    = "2rem";
        }    

        const btnToTop = document.querySelector("#goto-top");
        
        // show scroll to top button
        (this.scrollY > 800 ? 
            btnToTop.classList.add('show') : btnToTop.classList.remove('show')
        );    
        
        
        // Hide navbar & btnToTop when scroll to bottom on desktop device
        if($(window).width() >= 1024){
            // Hide navbar & btnToTop when scroll bottom
            let currentScrollPos = window.pageYOffset;
                if (prevScrollpos > currentScrollPos) {
                    document.getElementById("navbar").style.top = "0";
                    btnToTop.style.bottom = "-100px";
                } else {
                    document.getElementById("navbar").style.top = "-100px";
                    btnToTop.style.bottom = "46px";
                }
                prevScrollpos = currentScrollPos;
            };   
        }
        

    AOS.init();  

});

//Scroll down 
$(function() {
    $('.scroll-down').click (function() {
      $('html, body').animate({scrollTop: $('section#scroll-down').offset().top }, 500);
      return false;
    });
});

// Open modal calendar
function openModalCalendar() {
    document.getElementById("myModalCalendar").style.display = "block";
}

// Open modal calendar
function openModalStruktur() {
    document.getElementById("myModalStruktur").style.display = "block";
}

// Open modal register
function openModalRegister() {
    document.getElementById("myModalRegister").style.display = "block";
}

// Close modal
function closeModalCalendar() {
    document.getElementById("myModalCalendar").style.display = "none";
}

function closeModalRegister() {
    document.getElementById("myModalRegister").style.display = "none";
}

function closeModalStruktur() {
    document.getElementById("myModalStruktur").style.display = "none";
}

//  change width nav button when hover
const label = document.querySelector('.nav-container label');
const span1 = document.querySelector('.nav-span:nth-of-type(1)');
const span3 = document.querySelector('.nav-span:nth-of-type(3)');

label.addEventListener('mouseover', ()=> {
    span1.style.width ="100%";
    span3.style.width ="100%";
});

label.addEventListener('mouseout', ()=>{
    span1.style.width ="50%";
    span3.style.width ="75%";
});


