document.getElementById("backtoLogin").addEventListener("click", function (e) {
    e.preventDefault(); // Prevent default anchor behavior

    showModal(
        "You're about to head back to the Login page.",
        "Are you sure you want to leave this page?",
        function () {
            // On confirm, handle navigation with history management
            const targetUrl = "/DoListify/Login";

            // Push new state before navigation
            window.history.pushState({ page: "login" }, "", targetUrl);

            // Perform the navigation
            window.location.href = targetUrl;
        },
        function () {
            // On cancel, ensure we stay on current page
            console.log("User canceled navigation");
            window.history.pushState(null, null, window.location.href);
        }
    );
});
