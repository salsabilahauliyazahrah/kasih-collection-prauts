document.addEventListener("DOMContentLoaded", function () {

    // Dark mode toggle
    const btn = document.getElementById("btn-theme");
    if (btn) {
        const icon = btn.querySelector(".theme-icon");
        btn.addEventListener("click", function () {
            document.body.classList.toggle("dark-mode");
            icon.textContent = document.body.classList.contains("dark-mode") ? "☀" : "☽";
        });
    }

    // Efek untuk Navbar scroll
    window.addEventListener("scroll", function () {
        const nav = document.getElementById("mainNav");
        if (!nav) return;

        if (window.scrollY > 60) nav.classList.add("scrolled");
        else nav.classList.remove("scrolled");
    });

    // Animasi produk saat di scroll
    const observer = new IntersectionObserver((entries) => {
        entries.forEach((e, i) => {
            if (e.isIntersecting) {
                setTimeout(() => e.target.classList.add("visible"), i * 80);
            }
        });
    }, { threshold: 0.1 });

    document.querySelectorAll(".product-col").forEach(el => observer.observe(el));

});