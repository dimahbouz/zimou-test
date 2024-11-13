<template>
    <q-card>
        <q-card-section class="row">
            <div class="col-12 q-mb-md text-center text-body1 text-bold">Create new package</div>
            <div class="col-12 q-pa-sm">
                <q-input v-model="name" label="Name" outlined rounded/>
            </div>
            <div class="col-12 q-pa-sm">
                <q-select v-model="store" :error="errors.indexOf('store') >= 0" :loading="storeLoader" :options="stores" error-message="This field is required"
                          input-debounce="500" label="Store *" option-label="name" option-value="id" outlined rounded
                          use-input @filter="loadStores"/>
            </div>
            <div class="col-12 q-px-md text-body1 text-bold text-grey">
                Client
            </div>
            <div class="col-12 col-md-6 q-pa-sm">
                <q-input v-model="clientFirstName" :error="errors.indexOf('clientFirstName') >= 0" error-message="This field is required" label="Client first name *"
                         outlined rounded/>
            </div>
            <div class="col-12 col-md-6 q-pa-sm">
                <q-input v-model="clientLastName" :error="errors.indexOf('clientLastName') >= 0" error-message="This field is required" label="Client last name *"
                         outlined rounded/>
            </div>
            <div class="col-12 col-md-6 q-pa-sm">
                <q-input v-model="clientPhone" :error="errors.indexOf('clientPhone') >= 0" error-message="This field is required" label="Client phone *"
                         outlined rounded/>
            </div>
            <div class="col-12 col-md-6 q-pa-sm">
                <q-input v-model="clientPhone2" label="Client phone" outlined rounded/>
            </div>
            <div class="col-12 col-md-6 q-pa-sm">
                <q-input v-model="address" :error="errors.indexOf('address') >= 0" error-message="This field is required" label="Address *"
                         outlined rounded/>
            </div>
            <div class="col-12 col-md-6 q-pa-sm">
                <q-select v-model="commune" :error="errors.indexOf('commune') >= 0" :loading="communeLoader" :options="communes"
                          error-message="This field is required" input-debounce="500" label="Commune *" option-label="name" option-value="id"
                          outlined rounded use-input
                          @filter="loadCommunes"/>
            </div>
            <div class="col-12 q-px-md text-body1 text-bold text-grey">
                Package
            </div>
            <div class="col-12 q-pa-sm">
                <q-select v-model="deliveryType" :error="errors.indexOf('deliveryType') >= 0" :loading="deliverytypeLoader"
                          :options="deliveryTypes"
                          error-message="This field is required" input-debounce="500" label="Delivery type *" option-label="name" option-value="id"
                          outlined rounded use-input
                          @filter="loadDeliveryTypes"/>
            </div>
            <div class="col-12 col-md-6 q-pa-sm">
                <q-toggle v-model="canBeOpened" label="Can be opened"/>
            </div>
            <div class="col-12 col-md-6 q-pa-sm">
                <q-toggle v-model="freeDelivery" label="Free delivery"/>
            </div>
            <div class="col-12 col-md-6 q-pa-sm">
                <q-input v-model="weight" label="Weight" outlined rounded type="number"/>
            </div>
            <div class="col-12 col-md-6 q-pa-sm">
                <q-input v-model="extraWeightPrice" label="Extra weight price" outlined rounded type="number"/>
            </div>
            <div class="col-12 col-md-6 q-pa-sm">
                <q-input v-model="packagingPrice" label="Packaging price" outlined rounded type="number"/>
            </div>
            <div class="col-12 q-px-md text-body1 text-bold text-grey">
                Prices
            </div>
            <div class="col-12 col-md-6 q-pa-sm">
                <q-input v-model="partnerCodPrice" label="Partner cod price" outlined rounded type="number"/>
            </div>
            <div class="col-12 col-md-6 q-pa-sm">
                <q-input v-model="partnerDeliveryPrice" label="Partner delivery price" outlined rounded type="number"/>
            </div>
            <div class="col-12 col-md-6 q-pa-sm">
                <q-input v-model="partnerReturn" label="Partner return" outlined rounded type="number"/>
            </div>
            <div class="col-12 col-md-6 q-pa-sm">
                <q-input v-model="returnPrice" label="Return price" outlined rounded type="number"/>
            </div>
            <div class="col-12 col-md-6 q-pa-sm">
                <q-input v-model="codToPay" label="COD to pay" outlined rounded type="number"/>
            </div>
            <div class="col-12 col-md-6 q-pa-sm">
                <q-input v-model="commission" label="Commission" outlined rounded type="number"/>
            </div>
            <div class="col-12 col-md-6 q-pa-sm">
                <q-input v-model="deliveryPrice" :error="errors.indexOf('deliveryPrice') >= 0" error-message="This field is required" label="Delivery price *" outlined
                         rounded type="number"/>
            </div>
            <div class="col-12 col-md-6 q-pa-sm">
                <q-input v-model="price" :error="errors.indexOf('price') >= 0" error-message="This field is required" label="Price *" outlined
                         rounded type="number"/>
            </div>
            <div class="col-12 col-md-6 q-pa-sm">
                <q-input v-model="priceToPay" :error="errors.indexOf('priceToPay') >= 0" error-message="This field is required" label="Price to pay *" outlined
                         rounded type="number"/>
            </div>
            <div class="col-12 col-md-6 q-pa-sm">
                <q-input v-model="totalPrice" :error="errors.indexOf('totalPrice') >= 0" error-message="This field is required" label="Total price *" outlined
                         rounded type="number"/>
            </div>
        </q-card-section>
        <q-card-actions align="right" class="q-px-md q-pb-md q-pt-none">
            <div class="q-px-sm">
                <q-btn v-close-popup flat label="Cancel" rounded/>
            </div>
            <div class="q-px-sm">
                <q-btn :loading="createLoader" color="primary" label="Create" rounded @click="createPackage"/>
            </div>
        </q-card-actions>
    </q-card>
</template>
<script setup>
import {ref} from "vue";
import {CREATE_PACKAGE_URL, formatUrl, INDEX_COMMUNES, INDEX_DELIVERY_TYPES, INDEX_STORES} from "@/constants/urls.js";
import {useQuasar} from "quasar";

defineOptions({
    name: 'createPackageComponent'
});
const $q = useQuasar();

const name = ref('');
const clientFirstName = ref('');
const clientLastName = ref('');
const clientPhone = ref('');
const clientPhone2 = ref('');
const address = ref('');
const canBeOpened = ref(false);
const freeDelivery = ref(false);
const deliveryPrice = ref(0);
const price = ref(0);
const priceToPay = ref(0);
const totalPrice = ref(0);
const codToPay = ref(0);
const commission = ref(0);
const extraWeightPrice = ref(0);
const packagingPrice = ref(0);
const partnerCodPrice = ref(0);
const partnerDeliveryPrice = ref(0);
const partnerReturn = ref(0);
const returnPrice = ref(0);
const weight = ref(0);

const stores = ref([]);
const store = ref(null);
const storeLoader = ref(false);

async function loadStores(name, update) {
    if (name !== null && name !== '' && name.length >= 3) {
        storeLoader.value = true;
        await axios.get(formatUrl(INDEX_STORES, {}, {name, perPage: 10}))
            .then(({data}) => {
                update(() => stores.value = data.data);
            }).finally(() => storeLoader.value = false);
    }
}

const communes = ref([]);
const commune = ref(null);
const communeLoader = ref(false);

async function loadCommunes(name, update) {
    if (name !== null && name !== '' && name.length >= 3) {
        communeLoader.value = true;
        await axios.get(formatUrl(INDEX_COMMUNES, {}, {name, perPage: 10}))
            .then(({data}) => {
                update(() => communes.value = data.data);
            }).finally(() => communeLoader.value = false);
    }
}

const deliveryTypes = ref([]);
const deliveryType = ref(null);
const deliverytypeLoader = ref(false);

async function loadDeliveryTypes(name, update) {
    if (name !== null && name !== '' && name.length >= 3) {
        deliverytypeLoader.value = true;
        await axios.get(formatUrl(INDEX_DELIVERY_TYPES, {}, {name, perPage: 10}))
            .then(({data}) => {
                update(() => deliveryTypes.value = data.data);
            }).finally(() => deliverytypeLoader.value = false);
    }
}

const emit = defineEmits(['created']);
const createLoader = ref(false);
const errors = ref([]);
const createPackage = async () => {
    errors.value = [];
    if (!store.value) errors.value.push('store');
    if (clientFirstName.value === '') errors.value.push('clientFirstName');
    if (clientLastName.value === '') errors.value.push('clientLastName');
    if (clientPhone.value === '') errors.value.push('clientPhone');
    if (address.value === '') errors.value.push('address');
    if (!commune.value) errors.value.push('commune');
    if (!deliveryType.value) errors.value.push('deliveryType');
    if (deliveryPrice.value < 0) errors.value.push('deliveryPrice');
    if (price.value < 0) errors.value.push('price');
    if (priceToPay.value < 0) errors.value.push('priceToPay');
    if (totalPrice.value < 0) errors.value.push('totalPrice');
    if (errors.value.length > 0) return;
    createLoader.value = true;
    let packageData = {
        name: name.value,
        store_id: store.value.id,
        client_first_name: clientFirstName.value,
        client_last_name: clientLastName.value,
        client_phone: clientPhone.value,
        client_phone2: clientPhone2.value,
        address: address.value,
        commune_id: commune.value.id,
        delivery_type_id: deliveryType.value.id,
        can_be_opened: canBeOpened.value,
        free_delivery: freeDelivery.value,
        delivery_price: deliveryPrice.value,
        price: price.value,
        price_to_pay: priceToPay.value,
        total_price: totalPrice.value,
        cod_to_pay: codToPay.value,
        commission: commission.value,
        extra_weight_price: extraWeightPrice.value,
        packaging_price: packagingPrice.value,
        partner_cod_price: partnerCodPrice.value,
        partner_delivery_price: partnerDeliveryPrice.value,
        partner_return: partnerReturn.value,
        return_price: returnPrice.value,
        weight: weight.value
    }
    await axios.post(CREATE_PACKAGE_URL, packageData)
        .then(({data}) => {
            emit('created', data.data)
        })
        .catch(error => $q.notify({
            type: 'negative',
            message: error.message
        }))
        .finally(() => createLoader.value = false)
}
</script>
