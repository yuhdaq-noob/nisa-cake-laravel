/**
 * Login page module.
 * Handles authentication form submission and user login.
 */

document.addEventListener("DOMContentLoaded", () => {
    const passEl = document.getElementById("passwordInput");
    if (passEl) passEl.focus();
});

const loginForm = document.getElementById("loginForm");
if (loginForm) {
    loginForm.addEventListener("submit", async function (e) {
        e.preventDefault();
        const btn = document.getElementById("btnLogin");
        const passInput = document.getElementById("passwordInput");
        const errorMsg = document.getElementById("errorMsg");
        const overlay = document.getElementById("loadingOverlay");

        passInput.classList.remove("error");
        if (errorMsg) errorMsg.style.opacity = "0";
        if (btn) {
            btn.innerText = "Verifying...";
            btn.disabled = true;
        }

        try {
            const formData = new FormData(this);
            const postUrl =
                document.body?.dataset?.loginPost ||
                window.loginPostRoute ||
                "/login";
            const response = await fetch(postUrl, {
                method: "POST",
                body: formData,
                headers: { "X-Requested-With": "XMLHttpRequest" },
            });
            const result = await response.json();

            if (response.ok) {
                if (overlay) {
                    overlay.style.opacity = "1";
                    overlay.style.pointerEvents = "all";
                }
                setTimeout(() => {
                    window.location.href = result.redirect;
                }, 1500);
            } else {
                throw new Error(result.message || "Login failed");
            }
        } catch (error) {
            if (btn) {
                btn.innerText = "Login";
                btn.disabled = false;
            }
            if (passInput) {
                passInput.classList.add("error");
                passInput.value = "";
                passInput.focus();
            }
            if (errorMsg) {
                errorMsg.innerText = error.message;
                errorMsg.style.opacity = "1";
            }
        }
    });
}
