
    // Function to animate counting effect
    function animateCount(target, start = 0, end, duration = 2000) {
    let startTime = null;
    const step = (timestamp) => {
    if (!startTime) startTime = timestamp;
    const progress = timestamp - startTime;
    const percentage = Math.min(progress / duration, 1);
    const currentCount = Math.floor(start + percentage * (end - start));
    document.getElementById(target).innerText = currentCount;
    if (percentage < 1) {
    requestAnimationFrame(step);
}
};
    requestAnimationFrame(step);
}

    // Set your target counts and call the animateCount function
    animateCount("patientsCount", 0, 15000, 2500); // Start from 0 and add up to 15000
    animateCount("countriesCount", 0, 15, 2500); // Start from 0 and add up to 10
    // Call the animateCount function for other metrics if needed

        $(document).ready(function () {
        // Function to slide testimonials
        function slideTestimonials() {
            const testimonialsContainer = $(".testimonials-container");
            const testimonialCards = $(".testimonial-card");
            const cardWidth = testimonialCards.outerWidth();
            const numTestimonials = testimonialCards.length;
            const slideDuration = 60000; // Slide duration in milliseconds

            const containerWidth = 1200; // Set the desired width for the container
            testimonialsContainer.css("width", containerWidth + "px");
            testimonialsContainer.css("overflow", "hidden"); // Hide overflowing cards

            testimonialsContainer.css("width", cardWidth * numTestimonials * 2 + "px"); // Set container width to show multiple sets of cards

            let slideCount = 0;

            // function animateSlide() {
            //     if (slideCount < numTestimonials) {
            //         testimonialsContainer.animate(
            //             {
            //                 marginLeft: -cardWidth,
            //             },
            //             slideDuration,
            //             function () {
            //                 testimonialsContainer.css("margin-left", 0);
            //                 testimonialsContainer.append(testimonialCards.first());
            //                 slideCount++;
            //                 animateSlide();
            //             }
            //         );
            //     } else {
            //         slideCount = 0; // Reset slideCount after all cards have slid
            //         testimonialsContainer.css("margin-left", 0); // Reset the position to show the first set of cards
            //         animateSlide();
            //     }
            // }
            //
            // animateSlide();
        }

        // Call the slideTestimonials function on page load
        slideTestimonials();
    });

    $(document).ready(function() {
        // Function to handle navbar link highlighting
        function highlightNavbarLinks() {
            var scrollPosition = $(document).scrollTop();
            $('section').each(function() {
                var top = $(this).offset().top - 100;
                var bottom = top + $(this).outerHeight();
                var id = $(this).attr('id');
                if (scrollPosition >= top && scrollPosition <= bottom) {
                    $('.navbar a').removeClass('active');
                    $('.navbar a[href="#' + id + '"]').addClass('active');
                }
            });

            // Special handling for "Home" and "Services" links
            if (scrollPosition < $('#about').offset().top - 100) {
                $('.navbar a').removeClass('active');
                $('.navbar a[href="index.php"]').addClass('active');
            } else if (
                scrollPosition >= $('#services').offset().top - 100 &&
                scrollPosition < $('#testimonials').offset().top - 100
            ) {
                $('.navbar a').removeClass('active');
                $('.navbar a[href="#services"]').addClass('active');
            }
        }

        // Function for smooth scrolling to the clicked section
        $('.navbar a').on('click', function(e) {
            e.preventDefault();
            var target = $(this).attr('href');
            var offset = $(target).offset().top;
            $('html, body').animate({
                scrollTop: offset - 80
            }, 600); // Adjust the animation speed as needed
        });

        // Call the function on page load and on scroll
        highlightNavbarLinks();
        $(document).scroll(function() {
            highlightNavbarLinks();
        });
    });