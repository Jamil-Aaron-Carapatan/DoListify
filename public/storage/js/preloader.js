window.addEventListener("load", function () {
    const quotes = [
        "Productivity is never an accident. It is always the result of a commitment to excellence.",
        "Great things are not done by impulse, but by a series of small things brought together.",
        "Teamwork divides the task and multiplies the success.",
        "Focus on being productive instead of busy.",
        "Plans are nothing; planning is everything.",
        "Success is the sum of small efforts, repeated day in and day out.",
        "The secret of getting ahead is getting started.",
        "The way to get started is to quit talking and begin doing.",
        "Do what the clock does instead than watching it. Keep going.",
        "It always seems impossible until it's done.",
    ];

    const randomQuote = quotes[Math.floor(Math.random() * quotes.length)];
    document.getElementById("motivational-quote").textContent = randomQuote;

    console.log("Page fully loaded");
    const preloader = document.getElementById("preloader");
    const minimumVisibleTime = 2000; // Minimum time (in milliseconds) for the preloader to stay visible
    const startTime = Date.now();

    function hidePreloader() {
        preloader.style.transition = "opacity 0.5s ease-out";
        preloader.style.opacity = "0";

        setTimeout(function () {
            preloader.style.display = "none";
            console.log("Preloader hidden");
        }, 500); // Matches the opacity transition duration
    }

    // Calculate elapsed time
    const elapsedTime = Date.now() - startTime;

    if (elapsedTime < minimumVisibleTime) {
        setTimeout(hidePreloader, minimumVisibleTime - elapsedTime);
    } else {
        hidePreloader();
    }
});

setTimeout(function () {
    const preloader = document.getElementById("preloader");
    if (preloader.style.display !== "none") {
        preloader.style.transition = "opacity 0.5s ease-out";
        preloader.style.opacity = "0";

        setTimeout(function () {
            preloader.style.display = "none";
        }, 500); // Matches the opacity transition duration
    }
}, 3000);
