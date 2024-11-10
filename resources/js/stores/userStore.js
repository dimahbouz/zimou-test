import {defineStore} from "pinia";
import {LOGGED_USER_URL, LOGIN_URL, LOGOUT_URL, REGISTER_URL} from "../constants/urls";
import {LocalStorage} from "quasar";

export const useUserStore = defineStore('userStore', {
    state: () => ({
        isAuth: false,
        user: null,
    }),
    actions: {
        async register(data) {
            await axios.post(REGISTER_URL, data)
                .then(({data}) => {
                    this.isAuth = true;
                    this.user = data.data;
                    LocalStorage.setItem('at', data.accessToken);
                    window.axios.defaults.headers.common['Authorization'] = 'Bearer ' + data.accessToken;
                })
                .catch(error => {
                    throw error;
                })
        },
        async login(data) {
            await axios.post(LOGIN_URL, data)
                .then(({data}) => {
                    this.isAuth = true;
                    this.user = data.data;
                    LocalStorage.setItem('at', data.accessToken);
                    window.axios.defaults.headers.common['Authorization'] = 'Bearer ' + data.accessToken;
                })
                .catch(error => {
                    throw error;
                })
        },
        async fetchConnectedUser() {
            if (LocalStorage.getItem('at')) {
                await axios.get(LOGGED_USER_URL)
                    .then(({data}) => {
                        this.isAuth = true;
                        this.user = data.data;
                    })
                    .catch(error => {
                        throw error;
                    })
            }
        },
        async logout() {
            if (LocalStorage.getItem('at')) {
                await axios.post(LOGOUT_URL)
                    .then(() => {
                        this.isAuth = false;
                        this.user = null;
                        LocalStorage.removeItem('at');
                        delete window.axios.defaults.headers.common['Authorization'];
                    })
                    .catch(error => {
                        throw error;
                    })
            }
        },
    }
});
