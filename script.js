
// Set the event date
const eventDate = new Date('March 25, 2025 00:00:00').getTime();

// Function to update the countdown
function updateCountdown() {
    const now = new Date().getTime();
    const timeLeft = eventDate - now;

    // Calculate days, hours, minutes, and seconds
    const days = Math.floor(timeLeft / (1000 * 60 * 60 * 24));
    const hours = Math.floor((timeLeft % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    const minutes = Math.floor((timeLeft % (1000 * 60 * 60)) / (1000 * 60));
    const seconds = Math.floor((timeLeft % (1000 * 60)) / 1000);

    // Update the countdown elements
    document.getElementById('days').innerText = days;
    document.getElementById('hours').innerText = hours;
    document.getElementById('minutes').innerText = minutes;
    document.getElementById('seconds').innerText = seconds;

    // Stop the countdown when the event date is reached
    if (timeLeft < 0) {
        clearInterval(countdownInterval);
        document.querySelector('.countdown').innerText = "Event Started!";
    }
}

// Update the countdown every second
const countdownInterval = setInterval(updateCountdown, 1000);

//------------------------------------------------------------------------------------------------
// Function to animate the statistics count
function animateStats(id, endValue) {
    const element = document.getElementById(id);
    let startValue = 0;
    const duration = 1500; // Animation duration in milliseconds
    const increment = Math.ceil(endValue / (duration / 30));

    const counter = setInterval(() => {
        startValue += increment;
        if (startValue >= endValue) {
            element.innerText = endValue;
            clearInterval(counter);
        } else {
            element.innerText = startValue;
        }
    }, 30);
}

// Animate the statistics when the page loads
window.addEventListener('load', () => {
    animateStats('stat-projects', 180);
    animateStats('stat-speakers', 10);
    animateStats('stat-participants', 12);
    animateStats('stat-workshops', 12);
});


//------------------------------------------------------------------------------------------------
