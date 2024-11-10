<template>
    <q-layout view="hhh lpr fff">
        <q-page-container>
            <q-page class="flex flex-center" padding>
                <div class="text-primary text-center">
                    <div class="row justify-center items-center text-h1 text-bold">
                        <q-icon name="error" size="7rem"/>
                        404
                    </div>
                    <div class="text-h4">
                        Page not found or you don't have access
                    </div>
                </div>
            </q-page>
        </q-page-container>
    </q-layout>
</template>

<script setup>
defineOptions({
    name: "NotFoundPage"
});
</script>
