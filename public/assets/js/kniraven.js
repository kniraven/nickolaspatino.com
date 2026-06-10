/*
    NickolasPatino.com
    Main site JavaScript

    Purpose:
    - Mobile navigation toggle
    - Small global UI behaviors for the main portfolio site

    Note:
    Project demos should use their own JavaScript files when possible.
*/

document.addEventListener("DOMContentLoaded", () => {
    initMobileNavigation();
});

function initMobileNavigation() {
    const toggle = document.querySelector("[data-nav-toggle]");
    const nav = document.querySelector(".site-nav");
    const navList = document.querySelector("#site-nav-list");

    if (!toggle || !nav || !navList) {
        return;
    }

    toggle.addEventListener("click", () => {
        const isOpen = nav.classList.toggle("is-open");
        toggle.setAttribute("aria-expanded", String(isOpen));
    });

    navList.addEventListener("click", (event) => {
        const clickedLink = event.target.closest("a");

        if (!clickedLink) {
            return;
        }

        closeMobileNavigation(nav, toggle);
    });

    document.addEventListener("keydown", (event) => {
        if (event.key !== "Escape") {
            return;
        }

        closeMobileNavigation(nav, toggle);
    });

    document.addEventListener("click", (event) => {
        const clickedInsideNav = nav.contains(event.target);
        const clickedToggle = toggle.contains(event.target);

        if (clickedInsideNav || clickedToggle) {
            return;
        }

        closeMobileNavigation(nav, toggle);
    });
}

function closeMobileNavigation(nav, toggle) {
    nav.classList.remove("is-open");
    toggle.setAttribute("aria-expanded", "false");
}