import "./bootstrap";

// Import shared utilities (auth, formatting, validation)
import "./utils.js";
// Import API helper to ensure login/logout token utilities are bundled.
import "./api.js";
// Page-specific scripts are loaded per-page via Blade @vite to avoid double-loading
import { initUiLayer } from "./ui.js";

document.addEventListener("DOMContentLoaded", () => {
    initUiLayer();
});
