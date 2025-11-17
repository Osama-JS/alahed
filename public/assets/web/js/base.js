$(document).ready(function () {
    //- conference swiper
    if ($(".conference-swiper").length) {
        var swiper = new Swiper(".conference-swiper", {
            navigation: {
                nextEl: ".conference-swiper .custom-swiper-next",
                prevEl: ".conference-swiper .custom-swiper-prev",
            },
            spaceBetween: 16,
            slidesPerView: 1,
            loop: false, // Disable looping
            initialSlide: 0, // Start from the first slide
            breakpoints: {
                768: {
                    slidesPerView: 2,
                    spaceBetween: 32,
                },
            },
            on: {
                // Swiper events to handle navigation state
                slideChange: function () {
                    var nextButton = document.querySelector(
                        ".custom-swiper-next"
                    );
                    var prevButton = document.querySelector(
                        ".custom-swiper-prev"
                    );

                    // Disable "next" button when on the last slide
                    if (swiper.isEnd) {
                        nextButton.classList.add("disabled"); // Add disabled class
                    } else {
                        nextButton.classList.remove("disabled"); // Enable if not last
                    }

                    // Disable "prev" button when on the first slide
                    if (swiper.isBeginning) {
                        prevButton.classList.add("disabled"); // Add disabled class
                    } else {
                        prevButton.classList.remove("disabled"); // Enable if not first
                    }
                },
            },
        });
    }
    //- speakers swiper
    if ($(".speakers-swiper").length) {
        var swiper = new Swiper(".speakers-swiper", {
            navigation: {
                nextEl: ".speakers-swiper .custom-swiper-next",
                prevEl: ".speakers-swiper .custom-swiper-prev",
            },
            slidesPerView: "auto",
        });
    }

    //- gates swiper
    if ($(".gates-swiper").length) {
        var swiper = new Swiper(".gates-swiper", {
            navigation: {
                nextEl: ".gates-swiper .custom-swiper-next",
                prevEl: ".gates-swiper .custom-swiper-prev",
            },
            slidesPerView: "auto",
        });
    }

    //- sponsors nav swiper
    if ($(".sponsors-swiper-nav").length) {
        var swiper = new Swiper(".sponsors-swiper-nav", {
            slidesPerView: "auto",
            spaceBetween: 16,
            freeMode: true,
            navigation: {
                nextEl: ".sponsors-swiper-nav .custom-swiper-next",
                prevEl: ".sponsors-swiper-nav .custom-swiper-prev",
            },
        });
    }

    //- sponsors swiper
    if ($(".sponsors-swiper").length) {
        var sponsorsSwiper;
        var sponsorsSwiperConfig = {
            loop: true,
            autoplay: {
                delay: 1500,
            },
            // freeMode: true,
            slidesPerView: "auto",
            // spaceBetween: 16,
            // breakpoints: {
            //     768: {
            //         slidesPerView: 3,
            //     }
            // }
        };

        // Initialize Swiper
        function initializeSwiper() {
            sponsorsSwiper = new Swiper(
                ".sponsors-swiper",
                sponsorsSwiperConfig
            );
        }

        initializeSwiper();

        const navItems = document.querySelectorAll(
            ".sponsors-swiper-nav .swiper-slide span"
        );
        const allSlides = document.querySelectorAll(
            ".sponsors-swiper .swiper-slide"
        );

        navItems.forEach((navItem) => {
            navItem.addEventListener("click", function () {
                // Remove active class from all nav items
                navItems.forEach((item) => item.classList.remove("active"));
                // Add active class to the clicked nav item
                this.classList.add("active");

                const target = this.getAttribute("data-target");

                // Destroy Swiper instance before modifying slides
                sponsorsSwiper.destroy(true, true);

                // Remove all slides from the DOM
                const swiperWrapper = document.querySelector(
                    ".sponsors-swiper .swiper-wrapper"
                );
                swiperWrapper.innerHTML = "";

                // Filter slides based on the selected category and append only visible slides
                allSlides.forEach((slide) => {
                    const slideTarget = slide.getAttribute("data-target");
                    if (slideTarget === target || target === "all") {
                        slide.style.display = "flex"; // Show relevant slides
                        swiperWrapper.appendChild(slide); // Append visible slides
                    }
                });

                // Reinitialize Swiper with the updated slides
                initializeSwiper();
            });
        });
    }

    document.querySelectorAll(".accordion-header").forEach((header) => {
        header.addEventListener("click", () => {
            const accordionItem = header.parentElement;
            const accordionContent = header.nextElementSibling;

            // Collapse all other accordion items and reset their icons
            document.querySelectorAll(".accordion-item").forEach((item) => {
                if (item !== accordionItem) {
                    item.classList.remove("active");
                    item.querySelector(
                        ".accordion-content"
                    ).style.maxHeight = 0;
                    item.querySelector(".icon").textContent = "+";
                }
            });

            // Toggle active class for the clicked accordion item
            accordionItem.classList.toggle("active");

            // Expand or collapse the content
            if (accordionItem.classList.contains("active")) {
                accordionContent.style.maxHeight =
                    accordionContent.scrollHeight + "px";
                header.querySelector(".icon").textContent = "-"; // Change to '-' when expanded
            } else {
                accordionContent.style.maxHeight = 0;
                header.querySelector(".icon").textContent = "+"; // Change back to '+' when collapsed
            }
        });
    });

    // Open the first accordion item by default
    const firstAccordion = document.querySelector(".accordion-item.active");
    if (firstAccordion) {
        const firstContent = firstAccordion.querySelector(".accordion-content");
        firstContent.style.maxHeight = firstContent.scrollHeight + "px";
        firstAccordion.querySelector(".icon").textContent = "-"; // Ensure the first one has '-' by default
    }

    // Set the countdown target date (5 November 2024)
    const targetDate = new Date("November 5, 2024 00:00:00").getTime();

    function updateCountdown() {
        const now = new Date().getTime();
        const timeLeft = targetDate - now;

        // Calculate days, hours, minutes, and seconds
        const days = Math.floor(timeLeft / (1000 * 60 * 60 * 24));
        const hours = Math.floor(
            (timeLeft % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60)
        );
        const minutes = Math.floor((timeLeft % (1000 * 60 * 60)) / (1000 * 60));
        const seconds = Math.floor((timeLeft % (1000 * 60)) / 1000);

        // Update the HTML elements with animation
        updateWithAnimation("days", days);
        updateWithAnimation("hours", hours < 10 ? "0" + hours : hours);
        updateWithAnimation("minutes", minutes < 10 ? "0" + minutes : minutes);
        updateWithAnimation("seconds", seconds < 10 ? "0" + seconds : seconds);

        // If the countdown is finished, stop updating
        if (timeLeft < 0) {
            clearInterval(countdownInterval);
            document.getElementById("days").innerText = "00";
            document.getElementById("hours").innerText = "00";
            document.getElementById("minutes").innerText = "00";
            document.getElementById("seconds").innerText = "00";

            // Hide the element with the class .intro-content-date
            const introContentDate = document.querySelector(
                ".intro-content-date"
            );
            introContentDate.style.display = "none";
        }
    }

    function updateWithAnimation(id, value) {
        const element = document.getElementById(id);
        if (element.innerText !== value.toString()) {
            element.classList.remove("flip"); // Reset animation
            void element.offsetWidth; // Trigger reflow to restart animation
            element.innerText = value; // Update value
            element.classList.add("flip"); // Apply flip animation
        }
    }

    // Update the countdown every second
    const countdownInterval = setInterval(updateCountdown, 1000);

    // Initialize the countdown display
    updateCountdown();

    document.addEventListener("scroll", function () {
        const scrollPosition = window.scrollY || window.pageYOffset;
        const ctaHolder = document.querySelector(".nav_cta_holder");

        if (scrollPosition > 110) {
            ctaHolder.classList.add("show");
        } else {
            ctaHolder.classList.remove("show");
        }
    });
 

    
});

    
    
