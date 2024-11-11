<template>
    <q-card style="width: 500px">
        <q-card-section class="row justify-center q-pt-md q-pa-none text-body1">Packages filter</q-card-section>
        <q-card-section class="row">
            <div class="col-12 q-pa-sm">
                <q-select v-model="store" :loading="storeLoader" :options="stores" input-debounce="500" label="Store"
                          option-label="name" option-value="id" outlined rounded use-input @filter="loadStores"/>
            </div>
            <div class="col-12 q-pa-sm">
                <q-select v-model="packageStatus" :loading="packageStatusLoader" :options="packageStatuses" input-debounce="500"
                          label="Package Status" option-label="name" option-value="id" outlined rounded
                          use-input @filter="loadPackageStatuses"/>
            </div>
            <div class="col-12 q-pa-sm">
                <q-select v-model="deliveryType" :loading="deliverytypeLoader" :options="deliveryTypes" input-debounce="500"
                          label="Delivery type" option-label="name" option-value="id" outlined rounded
                          use-input @filter="loadDeliveryTypes"/>
            </div>
        </q-card-section>
        <q-card-actions align="right" class="q-px-md q-pb-md q-pt-none">
            <div class="q-px-sm">
                <q-btn v-close-popup flat label="Cancel" rounded/>
            </div>
            <div class="q-px-sm">
                <q-btn color="primary" label="Validate" rounded @click="validateFilter"/>
            </div>
        </q-card-actions>
    </q-card>
</template>
<script setup>
import {ref} from "vue";
import {formatUrl, INDEX_DELIVERY_TYPES, INDEX_PACKAGE_STATUSES, INDEX_STORES} from "@/constants/urls.js";

defineOptions({
    name: 'packagesFilterComponent'
});

const stores = ref([{name: 'All', id: 0}]);
const store = ref({name: 'All', id: 0});

const packageStatuses = ref([{name: 'All', id: 0}]);
const packageStatus = ref({name: 'All', id: 0});

const deliveryTypes = ref([{name: 'All', id: 0}]);
const deliveryType = ref({name: 'All', id: 0});

const storeLoader = ref(false);

async function loadStores(name, update) {
    if (name !== '' && name.length >= 3) {
        storeLoader.value = true;
        await axios.get(formatUrl(INDEX_STORES, {}, {name, perPage: 10}))
            .then(({data}) => {
                update(() => {
                    stores.value = [{name: 'All', id: 0}, ...data.data];
                })
            }).finally(() => storeLoader.value = false);
    }
}

const deliverytypeLoader = ref(false);

async function loadDeliveryTypes(name, update) {
    if (name !== '' && name.length >= 3) {
        deliverytypeLoader.value = true;
        await axios.get(formatUrl(INDEX_DELIVERY_TYPES, {}, {name, perPage: 10}))
            .then(({data}) => {
                update(() => {
                    deliveryTypes.value = [{name: 'All', id: 0}, ...data.data];
                })
            }).finally(() => deliverytypeLoader.value = false);
    }
}

const packageStatusLoader = ref(false);

async function loadPackageStatuses(name, update) {
    if (name !== '' && name.length >= 3) {
        packageStatusLoader.value = true;
        await axios.get(formatUrl(INDEX_PACKAGE_STATUSES, {}, {name, perPage: 10}))
            .then(({data}) => {
                update(() => {
                    packageStatuses.value = [{name: 'All', id: 0}, ...data.data];
                })
            }).finally(() => packageStatusLoader.value = false);
    }
}

const emit = defineEmits(['validate'])
const validateFilter = () => {
    let urlQuery = {};
    if (store.value.id !== 0) urlQuery.storeId = store.value.id;
    if (packageStatus.value.id !== 0) urlQuery.packageStatusId = packageStatus.value.id;
    if (deliveryType.value.id !== 0) urlQuery.deliveryTypeId = deliveryType.value.id;
    emit('validate', urlQuery);
}
</script>
