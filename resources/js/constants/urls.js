const BASE_URL = 'http://127.0.0.1:8000/api/v1/';
const REGISTER_URL = 'auth/register';
const LOGIN_URL = 'auth/login';
const LOGGED_USER_URL = 'user';
const LOGOUT_URL = 'auth/logout';
const INDEX_PACKAGES = '/packages'

export function formatUrl(urlString, params = {}, queries = {}) {
    for (const [key, value] of Object.entries(params)) {
        urlString = urlString.replace(`:${key}`, value);
    }
    let url = urlString;
    if (Object.keys(queries).length > 0) {
        const queryString = new URLSearchParams(queries).toString();
        url += url.includes('?') ? `&${queryString}` : `?${queryString}`;
    }
    return url;
}

export {
    BASE_URL,
    REGISTER_URL,
    LOGIN_URL,
    LOGGED_USER_URL,
    LOGOUT_URL,
    INDEX_PACKAGES,
}
