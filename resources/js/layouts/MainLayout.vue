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
            </q-toolbar>
        </q-header>

        <q-page-container>
            <router-view/>
        </q-page-container>
    </q-layout>
</template>

<script setup>

defineOptions({
    name: "MainLayout",
});

</script>
