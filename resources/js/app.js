import "./bootstrap";

import Alpine from "alpinejs";

window.Alpine = Alpine;

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
