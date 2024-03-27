<script setup>
import Layout from '@/Layouts/Layout.vue'
import { Head } from '@inertiajs/vue3'
import { ref } from 'vue'
import ShotImage from '@/Pages/Shots/Partials/ShotImage.vue'
import ShotDetails from '@/Pages/Shots/Partials/ShotDetails.vue'
import ShotLinks from '@/Pages/Shots/Partials/ShotLinks.vue'

const props = defineProps({
    shot: Object,
    showLinks: Object,
    author: Object,
    reaction: Object,
    reactionCounts: Object,
    childShots: Array,
    isOwner: Boolean,
})

let shots = [
    props.shot,
    ...props.childShots
]

const selectedIndex = ref(0)
</script>

<template>
    <Head title="Shot">
        <meta property="og:site_name" content="ShotShare"/>
        <meta v-if="shot" property="og:image" :content="shot.links.asset_url"/>
    </Head>

    <Layout>
        <div class="space-y-8">
            <div class="space-y-8">
                <ShotImage
                    :shots="shots"
                    @focus="(index) =>  selectedIndex = index">
                </ShotImage>

                <ShotDetails
                    :shot="shot"
                    :author="author"
                    :is-owner="isOwner"
                    :reaction="reaction"
                    :reaction-counts="reactionCounts">
                </ShotDetails>

                <ShotLinks
                    :shots="shots"
                    :selected-index="selectedIndex"
                    :show-links="showLinks">
                </ShotLinks>
            </div>
        </div>
    </Layout>
</template>

