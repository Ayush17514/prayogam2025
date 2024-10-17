document.getElementById("menu-icon").addEventListener("click", function() {
    const navbar = document.getElementById("navbar");
    navbar.classList.toggle("visible");
});

document.getElementById("registration-form").addEventListener("submit", function(event) {
    event.preventDefault();
    alert("Thank you for registering, " + document.getElementById("name").value + "!");
    this.reset(); // Reset the form after submission
});
document.getElementById("menu-icon").addEventListener("click", function() {
    const navbar = document.getElementById("navbar");
    navbar.classList.toggle("visible");
});

document.getElementById("registration-form").addEventListener("submit", function(event) {
    event.preventDefault();
    alert("Thank you for registering, " + document.getElementById("name").value + "!");
    this.reset(); // Reset the form after submission
});


// Countdown Timer
const eventDate = new Date("2025-02-28T10:00:00").getTime(); // Set your event date and time here

const countdownElement = document.getElementById("countdown");

const countdownInterval = setInterval(function() {
    const now = new Date().getTime();
    const distance = eventDate - now;

    const days = Math.floor(distance / (1000 * 60 * 60 * 24));
    const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
    const seconds = Math.floor((distance % (1000 * 60)) / 1000);

    countdownElement.innerHTML = `${days}d ${hours}h ${minutes}m ${seconds}s`;

    if (distance < 0) {
        clearInterval(countdownInterval);
        countdownElement.innerHTML = "Event has started!";
    }
}, 1000);


const track = document.querySelector('.carousel-track');
const items = document.querySelectorAll('.carousel-item');
const nextButton = document.querySelector('.next');
const prevButton = document.querySelector('.prev');
let currentIndex = 0;

// Update the track position
function updateCarousel() {
    const itemWidth = items[0].getBoundingClientRect().width;
    const offset = -currentIndex * itemWidth;
    track.style.transform = `translateX(${offset}px)`;
}

// Next button functionality
nextButton.addEventListener('click', () => {
    const totalItems = items.length;
    const itemsToShow = window.innerWidth < 600 ? 1 : 2;

    currentIndex = (currentIndex + itemsToShow) % totalItems;
    updateCarousel();
});

// Previous button functionality
prevButton.addEventListener('click', () => {
    const totalItems = items.length;
    const itemsToShow = window.innerWidth < 600 ? 1 : 2;

    currentIndex = (currentIndex - itemsToShow + totalItems) % totalItems;
    updateCarousel();
});

// Initialize the carousel
updateCarousel();


