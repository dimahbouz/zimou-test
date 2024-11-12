<template>
    <q-card style="width: 500px">
        <q-card-section class="row justify-center q-pt-md q-pa-none text-body1">Packages filter</q-card-section>
        <q-card-section class="row">
            <div class="col-12 q-pa-sm">
                <q-select v-model="store" :loading="storeLoader" :options="stores" input-debounce="500" label="Store"
                          option-label="name" option-value="id" outlined rounded use-input @filter="loadStores">
                    <template v-if="store.id !== 0" v-slot:append>
                        <q-icon class="cursor-pointer" name="cancel"
                                @click.stop.prevent="store = {name: 'All', id: 0}"/>
                    </template>
                </q-select>
            </div>
            <div class="col-12 q-pa-sm">
                <q-select v-model="packageStatus" :loading="packageStatusLoader" :options="packageStatuses" input-debounce="500"
                          label="Package Status" option-label="name" option-value="id" outlined rounded
                          use-input @filter="loadPackageStatuses">
                    <template v-if="packageStatus.id !== 0" v-slot:append>
                        <q-icon class="cursor-pointer" name="cancel"
                                @click.stop.prevent="packageStatus = {name: 'All', id: 0}"/>
                    </template>
                </q-select>
            </div>
            <div class="col-12 q-pa-sm">
                <q-select v-model="deliveryType" :loading="deliverytypeLoader" :options="deliveryTypes" input-debounce="500"
                          label="Delivery type" option-label="name" option-value="id" outlined rounded
                          use-input @filter="loadDeliveryTypes">
                    <template v-if="deliveryType.id !== 0" v-slot:append>
                        <q-icon class="cursor-pointer" name="cancel"
                                @click.stop.prevent="deliveryType = {name: 'All', id: 0}"/>
                    </template>
                </q-select>
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
import {onBeforeMount, ref} from "vue";
import {formatUrl, INDEX_DELIVERY_TYPES, INDEX_PACKAGE_STATUSES, INDEX_STORES} from "@/constants/urls.js";

defineOptions({
    name: 'packagesFilterComponent'
});

const props = defineProps({
    filter: {
        type: Object,
        default: {}
    },
})

onBeforeMount(async () => {
    if (props.filter?.storeId) await loadStores(null, null, null, props.filter?.storeId);
    if (props.filter?.packageStatusId) await loadPackageStatuses(null, null, null, props.filter?.packageStatusId);
    if (props.filter?.deliveryTypeId) await loadDeliveryTypes(null, null, null, props.filter?.deliveryTypeId);
})

const stores = ref([{name: 'All', id: 0}]);
const store = ref({name: 'All', id: 0});

const packageStatuses = ref([{name: 'All', id: 0}]);
const packageStatus = ref({name: 'All', id: 0});

const deliveryTypes = ref([{name: 'All', id: 0}]);
const deliveryType = ref({name: 'All', id: 0});

const storeLoader = ref(false);

async function loadStores(name, update, abort, storeId = null) {
    if (storeId != null || (name !== null && name !== '' && name.length >= 3)) {
        storeLoader.value = true;
        const query = storeId !== null ? {id: storeId} : {name, perPage: 10}
        await axios.get(formatUrl(INDEX_STORES, {}, query))
            .then(({data}) => {
                stores.value = [{name: 'All', id: 0}, ...data.data];
                if (storeId && data.data.length > 0) store.value = data.data[0]
                if (storeId === null) update(() => {
                });
            }).finally(() => storeLoader.value = false);
    }
}

const deliverytypeLoader = ref(false);

async function loadDeliveryTypes(name, update, abort, deliveryTypeId = null) {
    if (deliveryTypeId != null || (name !== null && name !== '' && name.length >= 3)) {
        deliverytypeLoader.value = true;
        const query = deliveryTypeId !== null ? {id: deliveryTypeId} : {name, perPage: 10}
        await axios.get(formatUrl(INDEX_DELIVERY_TYPES, {}, query))
            .then(({data}) => {
                deliveryTypes.value = [{name: 'All', id: 0}, ...data.data];
                if (deliveryTypeId && data.data.length > 0) deliveryType.value = data.data[0]
                if (deliveryTypeId === null) update(() => {
                });
            }).finally(() => deliverytypeLoader.value = false);
    }
}

const packageStatusLoader = ref(false);

async function loadPackageStatuses(name, update, abort, packageStatusId = null) {
    if (packageStatusId != null || (name !== null && name !== '' && name.length >= 3)) {
        packageStatusLoader.value = true;
        const query = packageStatusId !== null ? {id: packageStatusId} : {name, perPage: 10}
        await axios.get(formatUrl(INDEX_PACKAGE_STATUSES, {}, query))
            .then(({data}) => {
                packageStatuses.value = [{name: 'All', id: 0}, ...data.data];
                if (packageStatusId && data.data.length > 0) packageStatus.value = data.data[0]
                if (packageStatusId === null) update(() => {
                });
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
