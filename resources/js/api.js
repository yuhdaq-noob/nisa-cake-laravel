import axios from "axios";

// FIXME: PERHITUNGAN

/**
 * Set global auth token: saves to localStorage and applies to axios headers.
 */
export function setAuthToken(token) {
    if (token) {
        localStorage.setItem("auth_token", token);
        axios.defaults.headers.common["Authorization"] = `Bearer ${token}`;
    } else {
        localStorage.removeItem("auth_token");
        delete axios.defaults.headers.common["Authorization"];
    }
}

export function getAuthHeaders() {
    const token = localStorage.getItem("auth_token");
    return token ? { Authorization: `Bearer ${token}` } : {};
}

/**
 * Login via API and persist token for subsequent requests.
 */
export async function apiLogin(username, password) {
    const response = await axios.post("/api/login", { username, password });
    const token = response?.data?.token;
    if (!token) throw new Error("Token tidak diterima dari server");
    setAuthToken(token);
    return response.data;
}

/**
 * Logout via API and clear local token.
 */
export async function apiLogout() {
    try {
        await axios.post("/api/logout");
    } finally {
        setAuthToken(null);
    }
}

// Expose helpers globally for simple usage in legacy scripts/templates
if (typeof window !== "undefined") {
    window.apiLogin = apiLogin;
    window.apiLogout = apiLogout;
    window.setAuthToken = setAuthToken;
    window.getAuthHeaders = getAuthHeaders;
}
