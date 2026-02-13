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
    modal.classList.remove("hidden", "opacity-0", "pointer-events-none");
}

function closeModal(id) {
    const modal = document.getElementById(id);
    if (!modal) return;
    modal.classList.add("hidden");
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
