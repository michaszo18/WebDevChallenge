var pageHeader = document.querySelector('.page-header');
var scroll = 0;

window.addEventListener('scroll', function () {
    scroll = Math.floor(window.pageYOffset);
    if (scroll > 0) {
        pageHeader.classList.add('page-header--scrolled');
    } else {
        pageHeader.classList.remove('page-header--scrolled');
    }
});