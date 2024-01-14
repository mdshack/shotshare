<script setup>
import Layout from '@/Layouts/Layout.vue'
import { Link, Head } from '@inertiajs/vue3'
import Macy from "macy"
import { ref } from 'vue';
import { onMounted } from 'vue';

defineProps({
    shots: Array
})

const masonry = ref(null)

onMounted(() => {
    masonry.value = Macy({
        container: ".masonry",
        columns: 2,
        trueOrder: true,
        waitForImages: true,
    })
})
</script>

<template>
    <Head title="My Shots" />

    <Layout>
        <div class="masonry">
            <Link
                v-for="shot in shots"
                class="flex items-center justify-center p-1"
                :href="route('shots.show', shot.id)">
                <div class="border rounded-lg hover:bg-accent overflow-hidden w-full">
                    <img :src="shot.links.asset_url" class="w-full"/>
                </div>
            </Link>
        </div>
    </Layout>
</template>
