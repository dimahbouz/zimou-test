import {createApp} from 'vue';
import './bootstrap';
import App from './App.vue';
import router from './router';
import stores from "./stores";
import {useUserStore} from "./stores/userStore";

import '@quasar/extras/material-icons/material-icons.css'
import 'quasar/src/css/index.sass'
import './css/app.scss';
import {LocalStorage, Notify, Quasar} from 'quasar';

const app = createApp(App);
app.use(stores);
app.use(router);
app.use(Quasar, {
    plugins: {Notify}
});

const userStore = useUserStore();
const accessToken = LocalStorage.getItem('at');
if (accessToken) {
    window.axios.defaults.headers.common['Authorization'] = 'Bearer ' + accessToken;
    await userStore.fetchConnectedUser();
}

router.beforeEach((to, from, next) => {
    if (
        !userStore.isAuth &&
        to.matched.some((route) => route.meta.requiresAuth)
    ) {
        next("/auth/login");
    } else if (
        userStore.isAuth &&
        to.matched.some((route) => route.meta.requiresNotAuth)
    ) {
        next("/");
    } else next();
});

app.mount('#app');
