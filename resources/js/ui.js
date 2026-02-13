// Lightweight UI helpers for Tailwind-based drawer and modal interactions.

function toggleDrawer(open) {
    const drawer = document.querySelector("[data-drawer]");
    const backdrop = document.querySelector("[data-drawer-backdrop]");
    if (!drawer || !backdrop) return;

    const isOpen = open ?? drawer.classList.contains("translate-x-0");
    const nextState = open !== undefined ? open : !isOpen;

    drawer.classList.toggle("-translate-x-full", !nextState);
    drawer.classList.toggle("translate-x-0", nextState);
    backdrop.classList.toggle("hidden", !nextState);
}

function bindDrawer() {
    const toggleButtons = document.querySelectorAll("[data-drawer-toggle]");
    const closeButtons = document.querySelectorAll("[data-drawer-close]");
    const backdrop = document.querySelector("[data-drawer-backdrop]");

    toggleButtons.forEach((btn) =>
        btn.addEventListener("click", () => toggleDrawer()),
    );
    closeButtons.forEach((btn) =>
        btn.addEventListener("click", () => toggleDrawer(false)),
    );
    backdrop?.addEventListener("click", () => toggleDrawer(false));
}

function openModal(id) {
    const modal = document.getElementById(id);
    if (!modal) return;
    const backdrop = modal.querySelector(".modal-backdrop");
    const panel = modal.querySelector(".modal-panel");

    // Pastikan modal terlihat terlebih dahulu agar transisi bisa berjalan
    modal.classList.remove("hidden");

    requestAnimationFrame(() => {
        modal.classList.remove("opacity-0", "pointer-events-none");
        modal.classList.add("pointer-events-auto");

        if (backdrop) {
            backdrop.classList.remove("opacity-0");
        }

        if (panel) {
            panel.classList.remove("opacity-0", "translate-y-4", "scale-95");
            panel.classList.add("translate-y-0", "scale-100");
        }
    });
}

function closeModal(id) {
    const modal = document.getElementById(id);
    if (!modal) return;
    const backdrop = modal.querySelector(".modal-backdrop");
    const panel = modal.querySelector(".modal-panel");

    modal.classList.add("opacity-0", "pointer-events-none");
    modal.classList.remove("pointer-events-auto");

    if (backdrop) {
        backdrop.classList.add("opacity-0");
    }

    if (panel) {
        panel.classList.add("opacity-0", "translate-y-4", "scale-95");
        panel.classList.remove("translate-y-0", "scale-100");
    }

    // Tunggu durasi transisi sebelum benar-benar menyembunyikan elemen
    setTimeout(() => {
        modal.classList.add("hidden");
    }, 200);
}

function bindModals() {
    document.querySelectorAll("[data-modal-open]").forEach((trigger) => {
        trigger.addEventListener("click", () => {
            const target = trigger.getAttribute("data-modal-open");
            if (target) openModal(target);
        });
    });

    document.querySelectorAll("[data-modal-close]").forEach((btn) => {
        btn.addEventListener("click", () => {
            const target = btn.getAttribute("data-modal-close");
            if (target) closeModal(target);
        });
    });
}

export function initUiLayer() {
    bindDrawer();
    bindModals();
}

export { openModal, closeModal };
