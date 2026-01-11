import "./bootstrap";

import Alpine from "alpinejs";

window.Alpine = Alpine;

Alpine.data("smartHeader", () => ({
    scrolled: false,
    init() {
        const onScroll = () => {
            this.scrolled = window.scrollY > 8;
        };

        onScroll();
        window.addEventListener("scroll", onScroll, { passive: true });
    },
}));

Alpine.data("readingProgress", () => ({
    progress: 0,
    init() {
        const articleEl = this.$refs.article;
        if (!articleEl) return;

        const update = () => {
            const rect = articleEl.getBoundingClientRect();
            const articleTop = window.scrollY + rect.top;
            const articleHeight = articleEl.offsetHeight;
            const windowHeight = window.innerHeight;
            const scrollTop = window.scrollY;

            const scrollableHeight = Math.max(1, articleHeight - windowHeight);
            const scrolledFromArticle = scrollTop - articleTop + windowHeight;

            this.progress = Math.max(
                0,
                Math.min(100, (scrolledFromArticle / scrollableHeight) * 100)
            );
        };

        let raf = 0;
        const scheduleUpdate = () => {
            if (raf) return;
            raf = window.requestAnimationFrame(() => {
                raf = 0;
                update();
            });
        };

        update();
        window.addEventListener("scroll", scheduleUpdate, { passive: true });
        window.addEventListener("resize", scheduleUpdate, { passive: true });
    },
}));

Alpine.start();

document.addEventListener("submit", async (event) => {
    const form = event.target;
    if (!(form instanceof HTMLFormElement)) return;

    if (!form.hasAttribute("data-newsletter-form")) return;
    event.preventDefault();

    const messageEl = form.querySelector("[data-newsletter-message]");
    if (messageEl) messageEl.textContent = "";

    const csrf = document
        .querySelector('meta[name="csrf-token"]')
        ?.getAttribute("content");
    const formData = new FormData(form);

    try {
        const response = await fetch(form.action, {
            method: "POST",
            headers: {
                Accept: "application/json",
                ...(csrf ? { "X-CSRF-TOKEN": csrf } : {}),
            },
            body: formData,
        });

        const payload = await response.json().catch(() => null);

        if (!response.ok) {
            const errorMessage =
                payload?.message || "Something went wrong. Please try again.";
            if (messageEl) messageEl.textContent = errorMessage;
            return;
        }

        if (messageEl)
            messageEl.textContent =
                payload?.message ||
                "Thank you! Please check your email to verify subscription.";
        form.reset();
    } catch (e) {
        if (messageEl)
            messageEl.textContent = "Network error. Please try again.";
    }
});
