<script setup>
import Layout from '@/Layouts/Layout.vue'
import { Input } from '@/Components/ui/input'
import { Progress } from '@/Components/ui/progress'

import { useForm, Head } from '@inertiajs/vue3';
import { ref } from 'vue';
import { Avatar } from '@/Components/ui/avatar';
import { ChatBubbleLeftRightIcon, EllipsisHorizontalIcon, PhotoIcon } from '@heroicons/vue/24/outline';
import { Button } from '@/Components/ui/button';
import { ThumbsUpIcon } from 'lucide-vue-next';
import PaginatedShotList from '@/Components/PaginatedShotList.vue';
const props = defineProps({
    shots: Object
})
</script>

<template>
    <Head :title="$page.props.features.feed ? 'Feed' : 'Home'" />

    <Layout #="{fileInput}">
        <div class="space-y-6">
            <div class="border rounded-lg bg- py-6 px-4 flex flex-col items-center justify-center space-y-2">
                <div class="border border-primary text-primary rounded-full p-2">
                    <PhotoIcon class="w-10"/>
                </div>

                <div class="text-center">
                    <h5 class="text-muted-foreground font-semibold text-primary">Drag & drop images to upload</h5>
                    <p class="text-muted-foreground">Upload a single photo or a collection of photos</p>
                </div>
                <Button variant="outline" @click="fileInput.click()">Select Files</Button>
            </div>

            <template v-if="$page.props.features.feed">
                <h2 class="font-semibold text-2xl">What's New?</h2>

                <PaginatedShotList :shots="shots"/>
            </template>
        </div>
    </Layout>
</template>
