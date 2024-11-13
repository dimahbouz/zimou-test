<template>
    <q-page padding>
        <div class="row justify-center q-pa-md text-h4">Welcome {{ userStore.user.name }}</div>
        <dashboardLoader v-if="loader"/>
        <div v-else class="row justify-center items-center">
            <div class="col-12 col-sm-4 q-pa-sm">
                <q-card class="cursor-pointer" @click="$router.push('/users')">
                    <q-card-section>
                        <div class="text-subtitle2">Users</div>
                        <div class="text-h2">{{ usersCount }}</div>
                    </q-card-section>
                </q-card>
            </div>
            <div class="col-12 col-sm-4 q-pa-sm">
                <q-card class="cursor-pointer" @click="$router.push('/stores')">
                    <q-card-section>
                        <div class="text-subtitle2">Stores</div>
                        <div class="text-h2">{{ storesCount }}</div>
                    </q-card-section>
                </q-card>
            </div>
            <div class="col-12 col-sm-4 q-pa-sm">
                <q-card class="cursor-pointer" @click="$router.push('/packages')">
                    <q-card-section>
                        <div class="text-subtitle2">Packages</div>
                        <div class="text-h2">{{ packagesCount }}</div>
                    </q-card-section>
                </q-card>
            </div>
        </div>
    </q-page>
</template>

<script setup>
import {useUserStore} from "@/stores/userStore.js";
import {onBeforeMount, ref} from "vue";
import {STATISTICS_DASHBOARD} from "@/constants/urls.js";
import dashboardLoader from '@/components/dashboardLoader.vue'

defineOptions({
    name: "HomePage"
});
const userStore = useUserStore();
const loader = ref(false);
const usersCount = ref(0);
const storesCount = ref(0);
const packagesCount = ref(0);
onBeforeMount(async () => {
    loader.value = true
    await axios.get(STATISTICS_DASHBOARD)
        .then(({data}) => {
            usersCount.value = data.usersCount;
            storesCount.value = data.storesCount;
            packagesCount.value = data.packagesCount;
        })
        .finally(() => loader.value = false);
})
</script>
