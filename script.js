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


// Initialize the starting index of the center speaker
let currentIndex = 0;

// Define an array of speaker objects, each containing image source, name, and title
const speakers = [
    { img: "pratishrawat.jpe", name: "Mr.Pratish Rawat", title: "HoD FCE DEpartment" },
    { img: "president.webp", name: "Dr. Suresh Chandra Padhy", title: "President" },
    { img: "chairperson.webp", name: "Ar. Shashikant Singhi", title: "Role/Title 3" }
];

/**
 * Renders the speaker cards in the carousel.
 * The middle speaker card is highlighted by adding the 'active' class.
 */
function renderSpeakers() {
    // Select the track container in the HTML
    const track = document.getElementById("speaker-track");

    // Map through each speaker in the array, creating an HTML template for each card
    // Set the 'active' class on the middle card (index 1) for emphasis
    track.innerHTML = speakers.map((speaker, index) => `
        <div class="speaker-card ${index === 1 ? 'active' : ''}">
            <img src="${speaker.img}" alt="${speaker.name}">
            <h3>${speaker.name}</h3>
            <p>${speaker.title}</p>
        </div>
    `).join(''); // Use join('') to combine all cards into a single HTML string
}

/**
 * Updates the slide to move to the next speaker.
 * This function shifts the array to keep the carousel looping infinitely.
 */
function updateSlide() {
    // Increment the index to move to the next speaker
    currentIndex = (currentIndex + 1) % speakers.length;

    // Remove the first speaker from the array and push it to the end,
    // creating a "rotating" effect for an infinite loop
    speakers.push(speakers.shift());

    // Re-render the speakers to reflect the updated order
    renderSpeakers();
}

// Set an interval to automatically update the slide every 3 seconds
// This creates an automatic slideshow effect
setInterval(updateSlide, 3000);

// Initial rendering of the speaker cards when the page loads
renderSpeakers();
