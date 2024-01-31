//Navbar
const nav = document.querySelector("nav");
const toggleNav = document.getElementById('nav-toggle');
const buttonRegister = document.getElementById('nav-btn-register');
const buttonLogin = document.getElementById('nav-btn-login');
const searchBar = document.getElementById('nav-search');


toggleNav.addEventListener("click", function (e){
   //Le boutton de changement de la barre de nav est presse
   nav.classList.toggle('nav-open');


   if (window.screen.width <= 715){
        buttonRegister.classList.remove("btn-white-primary");
        buttonRegister.classList.add("btn-primary");

        buttonLogin.classList.remove("btn-white-secondary");
        buttonLogin.classList.add("btn-secondary");
   } else {
       buttonLogin.classList.add('btn-white-secondary');
       buttonLogin.classList.remove('btn-secondary');

       buttonRegister.classList.add('btn-white-primary');
       buttonRegister.classList.remove('btn-primary');
   }
});

searchBar.addEventListener("keyup", function(e){
    e.preventDefault();

    //Si la touche espace est pressé
    if (e.keyCode == 13){
        document.getElementById('nav-form-search').submit();
    }
});

//Submenu
const submenuContainers = document.querySelectorAll('.submenu-container');
submenuContainers.forEach((submenu)=>{
    submenu.querySelector("a").addEventListener("click", function(e){
        e.preventDefault();
        submenu.classList.toggle("submenu-open");
    });
});

//Rangeinput min max
function moveProgress(container){
    const progress = container.querySelector('div:first-child > div'), ranges = container.querySelectorAll('input');
    progress.style.left = (ranges[0].value / ranges[0].max) * 100 + '%';
    progress.style.right = 100 - (ranges[1].value / ranges[1].max) * 100 + '%';
}
document.querySelectorAll('.form-range-min-max').forEach((range)=>{
    const rangeInput = range.querySelectorAll('input'),
        progress = range.querySelector('div:first-child > div');

    moveProgress(range);

    rangeInput.forEach((input)=>{
       input.addEventListener('input', function(e){
           e.preventDefault();
           moveProgress(range);
       })
    });
});

//Modal
document.querySelectorAll('.un-modal').forEach((modal)=>{
    modal.querySelectorAll('.un-modal-btn-close').forEach((close)=>{
        close.addEventListener('click', function(e){
            e.preventDefault();
            modal.classList.remove('un-modal-open');
        });
    });
});
document.querySelectorAll('.un-modal-show[data-modal]').forEach((modalTrigger)=>{
    modalTrigger.addEventListener('click', function(e){
        e.preventDefault();
        document.getElementById(modalTrigger.dataset.modal).classList.add('un-modal-open');
    });
});
function closeModal(modal){
    modal.classList.remove('un-modal-open');
}
function openModal(modal){
    modal.classList.add('un-modal-open');
}