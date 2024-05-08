// Toggle Button Functionality
const toggleBtns = document.querySelectorAll('.toggle-btn');
toggleBtns.forEach(function(toggleBtn) {
    toggleBtn.addEventListener('click', function() {
        this.nextElementSibling.classList.toggle('hidden');
    });
});

// Carousel Functionality
document.querySelector('#counselorCarousel .carousel-control.prev').addEventListener('click', function() {
    var activeItem = document.querySelector('#counselorCarousel .carousel-item.active');
    activeItem.classList.remove('active');
    if (activeItem.previousElementSibling) {
        activeItem.previousElementSibling.classList.add('active');
    } else {
        document.querySelector('#counselorCarousel .carousel-item:last-child').classList.add('active');
    }
});
document.querySelector('#counselorCarousel .carousel-control.next').addEventListener('click', function() {
    var activeItem = document.querySelector('#counselorCarousel .carousel-item.active');
    activeItem.classList.remove('active');
    if (activeItem.nextElementSibling) {
        activeItem.nextElementSibling.classList.add('active');
    } else {
        document.querySelector('#counselorCarousel .carousel-item:first-child').classList.add('active');
    }
});