<template>
    <q-layout view="hhh lpr fff">
        <q-header elevated>
            <q-toolbar>
                <q-toolbar-title>
                    <q-btn
                        flat
                        label="Zimou"
                        no-caps
                        padding="xs lg"
                        size="lg"
                        to="/"
                    />
                </q-toolbar-title>
                <div>
                    <q-btn :label="userStore.user.name" flat icon="person">
                        <q-menu>
                            <q-card style="min-width: 250px;">
                                <q-card-section>
                                    <div class="text-h4">{{ userStore.user.name }}</div>
                                    <div class="text-subtitle2 text-grey-7">{{ userStore.user.email }}</div>
                                </q-card-section>
                                <q-card-actions align="right">
                                    <q-btn :loading="logoutLoader" dense flat icon="logout" label="logout"
                                           @click="logout"/>
                                </q-card-actions>
                            </q-card>

                        </q-menu>
                    </q-btn>
                </div>
            </q-toolbar>
        </q-header>

        <q-page-container>
            <router-view/>
        </q-page-container>
    </q-layout>
</template>

<script setup>
import {ref} from "vue";
import {useRouter} from "vue-router";
import {useUserStore} from "../stores/userStore";

defineOptions({
    name: "MainLayout",
});

const router = useRouter();
const userStore = useUserStore();

const logoutLoader = ref(false);
const logout = async () => {
    logoutLoader.value = true;
    await userStore.logout()
        .then(() => router.push('/auth/login'))
        .finally(() => logoutLoader.value = false);
}
</script>
