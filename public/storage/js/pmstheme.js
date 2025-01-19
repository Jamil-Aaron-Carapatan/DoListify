const mobileSearchBar = document.getElementById("mobileSearchBar");
const sidebar = document.getElementById("sidebar");
const mainContent = document.getElementById("main-content");
const mobileSearchToggle = document.getElementById("mobileSearchToggle");
const burgerButton = document.getElementById("burger");

burgerButton.addEventListener("click", () => {
    if (sidebar.classList.contains("-translate-x-full")) {
        sidebar.classList.remove("-translate-x-full");
        sidebar.classList.add("ml-[12px]");
    } else {
        sidebar.classList.add("-translate-x-full");
        sidebar.classList.remove("ml-[12px]");
    }
});
mobileSearchToggle.addEventListener("click", () => {
    const searchBarHeight = mobileSearchBar.scrollHeight;
    if (mobileSearchBar.classList.contains("max-h-0")) {
        mobileSearchBar.classList.remove("max-h-0");
        mobileSearchBar.classList.add("max-h-40"); // Adjust max height
        sidebar.style.top = `calc(72px + ${searchBarHeight}px)`;
        sidebar.style.minHeight = `calc(100vh - ${searchBarHeight + 82}px)`;
        mainContent.style.minHeight = `calc(100vh - ${searchBarHeight + 82}px)`;
    } else {
        mobileSearchBar.classList.add("max-h-0");
        mobileSearchBar.classList.remove("max-h-40");
        sidebar.style.top = "72px";
        sidebar.style.height = "calc(100vh - 82px)";
        sidebar.style.height = "calc(100vh - 82px)";
    }
});
window.addEventListener("resize", () => {
    if (window.innerWidth >= 1024) {
        mobileSearchBar.classList.add("max-h-0");
        mobileSearchBar.classList.remove("max-h-40");
        sidebar.style.top = "72px";
        sidebar.style.height = "calc(100vh-82px)";
    } else {
        sidebar.classList.remove("ml-[12px]");
    }
});

$(document).ready(function () {
    const currentUrl = window.location.href;

    $(".nav-item").each(function () {
        const menuItemHref = $(this).attr("href");
        const menuItemLabel = $(this).find("span").text(); // Get the label for title

        // Add 'active' class to the matching menu item
        if (menuItemHref && currentUrl.includes(menuItemHref)) {
            $(this).addClass("active");
        }
    });

    // Update the active link and title dynamically on click
    $(".nav-item").on("click", function (event) {
        const targetUrl = $(this).attr("href");
        const menuItemLabel = $(this).find("span").text();

        // Update the active link
        $(".nav-item").removeClass("active");
        $(this).addClass("active");
    });
});

document.getElementById("logout-button").addEventListener("click", function (e) {
    e.preventDefault(); // Prevent default anchor behavior

    showModal(
        "You're about to log out.",
        "Are you sure you want to log out of your account?",
        function () {
            document.getElementById("logout-form").submit();
        },
        function () {
            console.log("User canceled logout");
        }
    );
});
