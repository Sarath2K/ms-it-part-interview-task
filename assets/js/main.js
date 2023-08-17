function isMobile() {
    return window.innerWidth <= 768;
}

function updateCarouselImages() {
    const carouselItems = document.querySelectorAll('#carouselBanners .carousel-inner .carousel-item img');

    if (isMobile()) {
        carouselItems[0].src = 'https://www.beyoung.in/api/catalog/home-19-7-23/Combo-home-page-banner-mobile-banner1009.jpg';
        carouselItems[1].src = 'https://www.beyoung.in/api/catalog/home-19-7-23/Pyjama-pants-home-page-banner-mobile-view.jpg-1208.jpg';
    } else {
        carouselItems[0].src = './assets/img/banner-1.jpg';
        carouselItems[1].src = './assets/img/banner-2.jpg';
    }
}

window.addEventListener('resize', updateCarouselImages);
updateCarouselImages();

// Big Saving zone
const nextButton = document.querySelector('[data-bs-slide="next"]');
nextButton.addEventListener('click', () => {
    const carousel = new bootstrap.Carousel(document.getElementById('carouselCard'));
    carousel.next();
});
