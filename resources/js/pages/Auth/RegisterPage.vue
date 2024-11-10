<template>
    <q-page class="flex flex-center" padding>
        <div class="row justify-center items-center">
            <div class="col-12 col-sm-8 col-md-6">
                <div class="row justify-center">
                    <div class="col-auto text-h3 text-bold q-pb-lg text-primary">
                        Zimou
                    </div>
                </div>
                <div class="row justify-center items-center">
                    <div class="col-12 q-pa-sm">
                        <q-input v-model="name" label="Name *" outlined required rounded/>
                    </div>
                    <div class="col-12 q-pa-sm">
                        <q-input v-model="email" label="Email *" outlined required rounded/>
                    </div>
                    <div class="col-12 q-pa-sm">
                        <q-input v-model="password" label="Password *" outlined required rounded type="password"/>
                    </div>
                    <div class="col-12 q-pa-sm">
                        <q-input v-model="password_confirmation" label="Password confirmation *" outlined required
                                 rounded type="password"/>
                    </div>
                    <div class="col-12 q-pa-sm">
                        <q-btn :loading="registerLoader" class="full-width" color="primary" label="Register" rounded
                               @click="register"/>
                    </div>
                </div>
                <div class="row justify-center q-pa-sm">
                    <div class="col-auto">
                        <q-btn flat label="I have an account" to="/auth/login"/>
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
    name: "RegisterPage"
});
const userStore = useUserStore();
const router = useRouter();
const $q = useQuasar();

const name = ref('');
const email = ref('');
const password = ref('');
const password_confirmation = ref('');
const registerLoader = ref(false);
const register = async () => {
    if (registerLoader.value) return;
    registerLoader.value = true;
    const user = {
        name: name.value,
        email: email.value,
        password: password.value,
        password_confirmation: password_confirmation.value
    };
    await userStore.register(user)
        .then(() => {
            $q.notify({
                type: "positive",
                message: "User registered successfully"
            });
            router.push('/');
        }).catch(() => {
            $q.notify({
                type: "negative",
                message: "Failed to register user"
            });
        }).finally(() => registerLoader.value = false);
};
</script>
