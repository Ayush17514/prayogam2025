particlesJS("particles-js", {
  particles: {
    number: { value: 130, density: { enable: true, value_area: 700 } },
    color: { value: "#C5C5C6" },
    shape: { type: "circle" },
    opacity: { value: 0.5, random: true },
    size: { value: 3, random: true },
    move: { enable: true, speed: 1, direction: "none" }
  }
});



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
// Function to open the modal
function openModal() {
    document.getElementById('registrationModal').style.display = 'block';
}

// Function to close the modal
function closeModal() {
    document.getElementById('registrationModal').style.display = 'none';
    resetForms();
}

// Function to show the Visitor form
function showVisitorForm() {
    document.getElementById('visitorForm').classList.remove('hidden');
    document.getElementById('participantForm').classList.add('hidden');
}

// Function to show the Participant form
function showParticipantForm() {
    document.getElementById('participantForm').classList.remove('hidden');
    document.getElementById('visitorForm').classList.add('hidden');
}

// Function to reset forms when closing the modal
function resetForms() {
    document.getElementById('visitorForm').classList.add('hidden');
    document.getElementById('participantForm').classList.add('hidden');
}

// Close the modal when clicking outside of it
window.onclick = function (event) {
    const modal = document.getElementById('registrationModal');
    if (event.target === modal) {
        closeModal();
    }
};
//------------------------------------------------------------------------------------------------
//
         document.querySelectorAll('.faq-question').forEach(question => {
            question.addEventListener('click', () => {
                const faq = question.parentElement;
                faq.classList.toggle('open');
            });
        });