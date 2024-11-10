<template>
    <q-layout view="hhh lpr fff">
        <q-header class="bg-transparent">
            <q-toolbar/>
        </q-header>
        <q-page-container>
            <router-view/>
        </q-page-container>
    </q-layout>
</template>

<script setup>
defineOptions({
    name: "AuthLayout",
});
</script>
