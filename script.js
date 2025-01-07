
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

// Get the modal
const modal = document.getElementById("registrationModal");

// Get the button that opens the modal
const openModalBtn = document.getElementById("openModalBtn");

// Get the <span> element that closes the modal
const closeModalBtn = document.getElementsByClassName("close-btn")[0];

// When the user clicks the button, open the modal
openModalBtn.onclick = function () {
  modal.style.display = "block";
}

// When the user clicks on <span> (x), close the modal
closeModalBtn.onclick = function () {
  modal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function (event) {
  if (event.target === modal) {
    modal.style.display = "none";
  }
}

// Handle form submission (for example, send data to server or process it)
const registrationForm = document.getElementById("registrationForm");

registrationForm.onsubmit = async function (e) {
  e.preventDefault(); // Prevent the default form submission behavior

  const username = document.getElementById("username").value;
  const email = document.getElementById("email").value;

  // Make a POST request to your serverless function for registration
  try {
    const response = await fetch("/api/register", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({
        username: username,
        email: email,
      }),
    });

    const data = await response.json();

    if (response.ok) {
      alert("Registration successful!");
      modal.style.display = "none"; // Close the modal on success
    } else {
      alert("Error: " + data.message);
    }
  } catch (error) {
    console.error("Error during registration:", error);
    alert("An error occurred. Please try again.");
  }
};
