import {defineStore} from "pinia";
import {REGISTER_URL} from "../constants/urls";
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
    }
});
