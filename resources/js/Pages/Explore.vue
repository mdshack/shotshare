<script setup>
import { Head } from '@inertiajs/vue3';

import Layout from '@/Layouts/Layout.vue'
import { Button } from '@/Components/ui/button';
import PaginatedShotList from '@/Components/PaginatedShotList.vue';

const props = defineProps({
    shots: Object
})
</script>

<template>
    <Head title="Explore" />

    <Layout #="{fileInput}">
        <div class="space-y-6">
            <template v-if="$page.props.features.feed">
                <h2 class="font-semibold text-2xl">Explore</h2>

                <PaginatedShotList :shots="shots" condensed/>
            </template>
        </div>
    </Layout>
</template>
