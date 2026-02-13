import "./bootstrap";

// Import shared utilities (auth, formatting, validation)
import "./utils.js";
// Import API helper to ensure login/logout token utilities are bundled.
import "./api.js";
// Import page-specific scripts (modules are defensive and check DOM)
import "./login.js";
import "./gudang.js";
import "./kasir.js";
import "./laporan.js";
