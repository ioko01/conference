"use strict";

// Remove the transition class
const animate = document.querySelectorAll(".animate");
animate.forEach((_, index) => {
    const classAnimated = animate[index].classList[1];
    animate[index].classList.remove(classAnimated);

    // Create the observer, same as before:
    const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting) {
                animate[index].classList.add(classAnimated);
                return;
            }
            // animate[index].classList.remove(classAnimated);
        });
    });

    observer.observe(animate[index]);
});
