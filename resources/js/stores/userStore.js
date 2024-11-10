import {defineStore} from "pinia";

export const useUserStore = defineStore('userStore', {
    state: () => ({
        isAuth: false,
        user: null,
    }),
    actions: {}
});
