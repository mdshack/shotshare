<script setup>
import Layout from '@/Layouts/Layout.vue'
import { Link, Head } from '@inertiajs/vue3'

defineProps({
    shots: Array
})
</script>

<template>
    <Head title="My Shots" />

    <Layout>
        <div class="grid grid-cols-3 gap-4">
            <Link
                v-for="shot in shots"
                class="flex items-center justify-center p-1 rounded-lg border aspect-square hover:bg-accent"
                :href="route('shots.show', shot.id)">
                <img :src="shot.url"/>
            </Link>
        </div>
    </Layout>
</template>
