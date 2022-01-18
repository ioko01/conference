"use strict";

window.addEventListener("load", function() {
    try {
        //preloading
        const loading = document.getElementById("loading");
        loading.style.opacity = 0;
        setTimeout(function() {
            loading.classList.add("hidden");
        }, 900);
        document.getElementById("page").classList.toggle("hidden");

        //navbar sticky
        document.addEventListener("scroll", function() {
            try {
                //navbar sticky top on 400
                const navbar = document.querySelector(".navbar");
                document.scrollingElement.scrollTop > 400 ?
                    navbar.classList.add("nav-sticky") :
                    navbar.classList.remove("nav-sticky");

                // button to top
                const buttonToTop = document.querySelector(".btn-to-top");
                if (document.scrollingElement.scrollTop > 100) {
                    buttonToTop.style.bottom = "20px";
                } else {
                    buttonToTop.style.bottom = "-100px";
                }
            } catch (error) {
                throw error;
            }
        });
    } catch (error) {
        throw error;
    }
});