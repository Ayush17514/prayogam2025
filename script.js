
// Set the event date
const eventDate = new Date('March 28, 2025 00:00:00').getTime();

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
//registration
 function openModal() {
            document.getElementById('registrationModal').style.display = 'flex';
        }

        // Close Modal
        function closeModal() {
            document.getElementById('registrationModal').style.display = 'none';
        }

        // Close modal when clicking outside the form
        window.onclick = function(event) {
            const modal = document.getElementById('registrationModal');
            if (event.target === modal) {
                closeModal();
            }
        }