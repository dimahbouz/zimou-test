<template>
    <q-page class="flex flex-center" padding>
        <div class="row justify-center items-center">
            <div class="col-12 col-sm-8">
                <div>
                    <div class="row justify-center">
                        <div class="col-auto text-h3 text-bold q-pb-lg text-primary">
                            Zimou
                        </div>
                    </div>
                    <div class="row justify-center items-center">
                        <div class="col-12 q-pa-sm">
                            <q-input v-model="email" :error="errors.indexOf('email') >= 0" error-message="This field is required"
                                     label="Email *" outlined required rounded/>
                        </div>
                        <div class="col-12 q-pa-sm">
                            <q-input v-model="password" :error="errors.indexOf('password') >= 0" error-message="This field is required"
                                     label="Password *" outlined required rounded type="password"/>
                        </div>
                        <div class="col-12 q-pa-sm">
                            <q-btn :loading="loginLoader" class="full-width" color="primary" label="Login" rounded
                                   @click="login"/>
                        </div>
                    </div>
                    <div class="row justify-center items-center q-pa-sm">
                        <div class="col-auto">
                            <q-btn flat label="Create an account" to="/auth/register"/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </q-page>
</template>

<script setup>
import {useQuasar} from 'quasar';
import {ref} from 'vue';
import {useUserStore} from '../../stores/userStore';
import {useRouter} from 'vue-router';

defineOptions({
    name: "LoginPage"
});
const userStore = useUserStore();
const router = useRouter();
const $q = useQuasar();

const email = ref('');
const password = ref('');
const loginLoader = ref(false);
const errors = ref([]);
const login = async () => {
    if (loginLoader.value) return;
    errors.value = [];
    if (email.value === '') errors.value.push('email');
    if (password.value === '') errors.value.push('password');
    if (errors.value.length > 0) return;
    loginLoader.value = true;
    const user = {
        email: email.value,
        password: password.value,
    };
    await userStore.login(user)
        .then(() => {
            $q.notify({
                type: "positive",
                message: "User logged in successfully"
            });
            router.push('/');
        }).catch(() => {
            $q.notify({
                type: "negative",
                message: "Failed to log user"
            });
        }).finally(() => loginLoader.value = false);
};
</script>
