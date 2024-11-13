<template>
    <q-page padding>
        <tableLoader v-if="firstLoad"/>
        <div v-else>
            <div class="row justify-between items-center">
                <div class="text-h5">Packages</div>
                <div class="col-auto">
                    <div class="row items-center">
                        <div class="q-px-sm">
                            <q-btn color="primary" label="Add" rounded @click="createPackageDialog = true"/>
                        </div>
                        <div class="q-px-sm">
                          <q-btn color="secondary" label="Export" rounded @click="exportDialog = true"/>
                        </div>
                        <div class="q-px-sm">
                            <q-btn dense flat icon="filter_alt" round @click="filterDialog = true"/>
                        </div>
                    </div>
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

                    <template v-slot:body="props">
                        <q-tr
                            :props="props"
                            class="cursor-pointer"
                            @click="$router.push(`/packages/${props.row.id}`)"
                        >
                            <q-td v-for="col in props.cols" :key="col.name" :props="props">
                                {{ col.value }}
                            </q-td>
                        </q-tr>
                    </template>

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

            <q-dialog v-model="filterDialog">
                <packagesFilter :filter="filter" @validate="updateFilter"/>
            </q-dialog>
          <q-dialog v-model="exportDialog" @hide="hideExportDialog">
            <q-card>
              <q-card-section class="row justify-center items-center">
                <div class="col-12 q-mb-md text-center text-body1 text-bold">Export Data</div>
                <div class="col-12 q-pa-sm">
                  <q-select v-model="exportType" :options="exportTypes" label="Export in file" outlined rounded/>
                </div>
                <div class="col-12 q-pa-sm">
                  <q-select v-model="exportContent" :options="exportContents" label="Content" outlined rounded/>
                </div>
              </q-card-section>
              <q-card-actions align="right" class="q-px-md q-pb-md q-pt-none">
                <div class="q-px-sm">
                  <q-btn v-close-popup flat label="Cancel" rounded/>
                </div>
                <div class="q-px-sm">
                  <q-btn color="primary" label="Export" rounded @click="exportData"/>
                </div>
              </q-card-actions>
              <q-inner-loading :showing="exportLoader">
                <q-spinner color="primary" size="50px"/>
              </q-inner-loading>
            </q-card>
          </q-dialog>
            <q-dialog v-model="createPackageDialog">
                <createPackage @created="packageCreated"/>
            </q-dialog>
        </div>
    </q-page>
</template>

<script setup>
import {onMounted, ref, watch} from "vue";
import {formatUrl, INDEX_PACKAGES} from "@/constants/urls.js";
import tableLoader from '@/components/tableLoader.vue';
import packagesFilter from '@/components/packagesFilter.vue';
import createPackage from '@/components/createPackage.vue';
import {useRoute, useRouter} from "vue-router";
import exportFromJSON from "export-from-json";

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
    if ($route.query.storeId) filter.value.storeId = parseInt($route.query.storeId);
    if ($route.query.packageStatusId) filter.value.packageStatusId = parseInt($route.query.packageStatusId);
    if ($route.query.deliveryTypeId) filter.value.deliveryTypeId = parseInt($route.query.deliveryTypeId);
    if ($route.query.wilayaId) filter.value.wilayaId = parseInt($route.query.wilayaId);
    if ($route.query.communeId) filter.value.communeId = parseInt($route.query.communeId);
    await loadPackages().finally(() => firstLoad.value = false);
});

const controller = new AbortController();
const signal = controller.signal;
const loadPackages = async (exportData = false) => {
  if (!exportData) {
    loading.value = true;
  } else exportLoader.value = true;
    let urlQuery = JSON.parse(JSON.stringify(filter.value));
  if (!exportData) {
    urlQuery.page = pagination.value.page;
    urlQuery.perPage = pagination.value.rowsPerPage;
  } else urlQuery.export = 'all';
  let dataToExport = [];
  await axios.get(formatUrl(INDEX_PACKAGES, {}, urlQuery), {signal})
        .then(({data}) => {
          if (!exportData) {
            packages.value = data.data;
            pagination.value.rowsNumber = data.meta.total;
            pagination.value.maxPages = Math.ceil(pagination.value.rowsNumber / pagination.value.rowsPerPage);
          } else dataToExport = data.data;
        }).catch(error => {
      }).finally(() => {
        if (!exportData) {
          loading.value = false;
        } else exportLoader.value = false;
      });
  return dataToExport;
}
watch(
    () => pagination.value.page,
    async () => {
        if (!firstLoad.value) {
            let routeQuery = {...$route.query};
            routeQuery.page = pagination.value.page;
            $router.push({name: "IndexPackages", query: routeQuery});
            await loadPackages();
        }
    }
)

const filter = ref({});
const filterDialog = ref(false);
const updateFilter = async (newFilter) => {
    let route = {name: 'IndexPackages'};
    filter.value = newFilter;
    if (Object.keys(newFilter).length === 0) {
        filter.value = {};
    } else route.query = newFilter;
    await $router.push(route);
    if (pagination.value.page !== 1) {
        pagination.value.page = 1;
    } else await loadPackages();
}

const exportDialog = ref(false);
const exportType = ref({label: 'Csv', value: 'csv'});
const exportTypes = ref([{label: 'Csv', value: 'csv'}, {label: 'Excel', value: 'xls'}]);
const exportContent = ref({label: 'This page only', value: 'page'});
const exportContents = ref([{label: 'This page only', value: 'page'}, {label: 'All data', value: 'all'}]);
const exportLoader = ref(false);
const exportData = async () => {
  let packagesToExport = packages.value;
  if (exportContent.value.value === 'all' && pagination.value.maxPages > 1) {
    packagesToExport = await loadPackages(true);
  }
  let content = [
    columns.map(column => column.label),
    ...packagesToExport.map(row => {
      return columns.map(col => col.field === 'client_phone' ? `'${row[col.field]}'` : row[col.field])
    })
  ];

  if (packagesToExport.length > 0) {
    exportFromJSON({
      data: content,
      fileName: 'data',
      exportType: exportType.value.value,
      delimiter: ',',
      withBOM: true,
    });
  }
  exportDialog.value = false;
}
const hideExportDialog = () => {
  exportType.value = {label: 'Csv', value: 'csv'};
  exportContent.value = {label: 'This page only', value: 'page'};
  if (exportLoader.value) {
    controller.abort();
    exportLoader.value = false;
  }
}

const createPackageDialog = ref(false);
const packageCreated = (packageData) => {
    createPackageDialog.value = false;
    packages.value.unshift(packageData);
}
</script>
