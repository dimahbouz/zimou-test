<template>
    <q-page padding>
        <tableLoader v-if="firstLoad"/>
        <div v-else>
            <div class="row justify-between items-center">
                <div class="text-h5">Packages</div>
                <div>

                </div>
            </div>
            <q-card class="q-mt-md">
                <q-table
                    :columns="columns"
                    :loading="loading"
                    :pagination="pagination"
                    :rows="packages"
                    class="sticky-table"
                    hide-pagination
                    row-key="id"
                    @request="loadPackages">
                    <template v-slot:loading>
                        <q-inner-loading color="primary" showing/>
                    </template>

                    <template v-slot:no-data="{ icon, message, filter }">
                        <div class="full-width row flex-center q-pa-lg text-grey">
                            <q-icon name="sentiment_dissatisfied" size="5em"/>
                            <div class="col-12 text-center text-body1 text-bold">Sorry! nothing to show</div>
                        </div>
                    </template>
                </q-table>
                <div v-if="packages.length > 0" class="row justify-center q-pa-md">
                    <q-pagination
                        v-model="pagination.page"
                        :max="pagination.maxPages"
                        :max-pages="9"
                    />
                </div>
            </q-card>
        </div>
    </q-page>
</template>

<script setup>
import {onMounted, ref, watch} from "vue";
import {formatUrl, INDEX_PACKAGES} from "@/constants/urls.js";
import tableLoader from '@/components/tableLoader.vue';
import {useRoute, useRouter} from "vue-router";

defineOptions({
    name: 'PackageIndexPage'
});
const $router = useRouter();
const $route = useRoute();

const columns = [
    {
        name: 'id',
        required: true,
        label: '#id',
        align: 'left',
        field: 'id',
    },
    {name: 'store_name', align: 'left', label: 'Store', field: 'store_name'},
    {name: 'tracking_code', align: 'left', label: 'Tracking code', field: 'tracking_code'},
    {name: 'name', align: 'left', label: 'Name', field: 'name'},
    {name: 'client_full_name', align: 'left', label: 'Client full name', field: 'client_full_name'},
    {name: 'client_phone', label: 'Client phone', field: 'client_phone'},
    {name: 'wilaya', align: 'left', label: 'Wilaya', field: 'wilaya'},
    {name: 'commune', align: 'left', label: 'Commune', field: 'commune'},
    {name: 'delivery_type', label: 'Delivery type', field: 'delivery_type'},
    {name: 'status_name', label: 'Status', field: 'status_name'},
]
const packages = ref([]);

const loading = ref(false);
const pagination = ref({
    sortBy: 'desc',
    descending: false,
    page: 1,
    rowsPerPage: 10,
    rowsNumber: 1,
    maxPages: 1
});

const firstLoad = ref(false);
onMounted(async () => {
    firstLoad.value = true;
    if ($route.query.page) pagination.value.page = parseInt($route.query.page);
    await loadPackages().finally(() => firstLoad.value = false);
});

const loadPackages = async () => {
    loading.value = true;
    await axios.get(formatUrl(INDEX_PACKAGES, {}, {page: pagination.value.page, perPage: pagination.value.rowsPerPage}))
        .then(({data}) => {
            packages.value = data.data;
            pagination.value.rowsNumber = data.meta.total;
            pagination.value.maxPages = Math.ceil(pagination.value.rowsNumber / pagination.value.rowsPerPage);
        }).catch(error => {
        }).finally(() => loading.value = false);
}
watch(
    () => pagination.value.page,
    async () => {
        if (!firstLoad.value) {
            await loadPackages();
            let routeQuery = {...$route.query};
            routeQuery.page = pagination.value.page;
            $router.push({name: "IndexPackages", query: routeQuery});
        }
    }
)
</script>
