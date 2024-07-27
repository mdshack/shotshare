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

const form = useForm({
    images: [],
})

const hoveringDropzone = ref(false)

const dropFile = (event) => {
    form.images = [
        ...form.images,
        ...event.dataTransfer.files
    ]

    form.post('upload', {
        onFinish: () => {
            form.images = []
        }
    })
}

const selectFile = (event) => {

    form.images = [
        ...form.images,
        ...event.target.files
    ]

    form.post('upload', {
        onFinish: () => {
            form.images = []
        }
    })
}

const pasteFile = (event) => {
    form.images = [
        ...form.images,
        ...event.clipboardData.files
    ]

    form.post('upload', {
        onFinish: () => {
            form.images = []
        }
    })
}
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

                <div class="space-y-4">
                    <div
                        v-for="i in 10"
                        class="border rounded-lg">
                        <div class="flex justify-between items-start p-4">
                            <div class="space-y-2">
                                <div class="flex items-center">
                                    <Avatar class="mr-2"/>
                                    <div>
                                        <h5 class="font-semibold">Micah Shackelford</h5>
                                        <div class="text-muted-foreground">
                                            <span>@mdshack</span>
                                            •
                                            <span>2hrs ago</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <Button variant="ghost" class="px-2">
                                <EllipsisHorizontalIcon class="w-7"/>
                            </Button>
                        </div>

                        <img :src="`https://picsum.photos/seed/${i}/536/354`" class="w-full"/>

                        <div class="p-4 flex justify-between items-end">
                            <div class="text-muted-foreground">
                                <h5 class="text-xl font-semibold text-primary mb-2">I built a new computer</h5>
                                <span class="font-semibold text-primary">Micah</span> and 4,123 others liked
                            </div>
                            <div class="space-x-4 flex">
                                <ChatBubbleLeftRightIcon class="w-5 text-muted-foreground"/>
                                <ThumbsUpIcon class="w-5 text-muted-foreground"/>
                            </div>
                        </div>
                    </div>

                    <div class="border rounded-lg">
                        <div class="flex justify-between items-start p-4">
                            <div class="flex items-center">
                                <Avatar class="mr-2"/>
                                <div>
                                    <h5 class="font-semibold">Micah Shackelford</h5>
                                    <span class="text-muted-foreground">@mdshack</span>
                                </div>
                            </div>

                            <Button variant="ghost" class="px-2">
                                <EllipsisHorizontalIcon class="w-7"/>
                            </Button>
                        </div>

                        <img src="https://picsum.photos/seed/picsum/536/354" class="w-full"/>

                        <div class="p-4 flex justify-between items-end">
                            <div class="text-muted-foreground">
                                <span class="font-semibold text-primary">Micah</span> and 4,123 others liked
                            </div>
                            <div class="space-x-4 flex">
                                <ChatBubbleLeftRightIcon class="w-5 text-muted-foreground"/>
                                <ThumbsUpIcon class="w-5 text-muted-foreground"/>
                            </div>
                        </div>
                    </div>

                    <div class="border rounded-lg">
                        <div class="flex justify-between items-start p-4">
                            <div class="flex items-center">
                                <Avatar class="mr-2"/>
                                <div>
                                    <h5 class="font-semibold">Micah Shackelford</h5>
                                    <span class="text-muted-foreground">@mdshack</span>
                                </div>
                            </div>

                            <Button variant="ghost" class="px-2">
                                <EllipsisHorizontalIcon class="w-7"/>
                            </Button>
                        </div>

                        <img src="https://picsum.photos/seed/asd/536/354" class="w-full"/>

                        <div class="p-4 flex justify-between items-end">
                            <div class="text-muted-foreground">
                                <span class="font-semibold text-primary">Micah</span> and 4,123 others liked
                            </div>
                            <div class="space-x-4 flex">
                                <ChatBubbleLeftRightIcon class="w-5 text-muted-foreground"/>
                                <ThumbsUpIcon class="w-5 text-muted-foreground"/>
                            </div>
                        </div>
                    </div>

                </div>
            </template>
        </div>

        <!-- <template v-if="$page.props.auth.user">
            <form v-if="!form.progress" @submit.prevent="submit" class="flex flex-col items-center space-y-8">
                <div class="flex items-center justify-center w-full">
                    <label
                        for="dropzone-file"
                        class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer dark:border-accent text-primary"
                        :class="{'dark:border-white': hoveringDropzone}"
                        @dragover.prevent="hoveringDropzone = true"
                        @dragleave.prevent="hoveringDropzone = false"
                        @drop.prevent="dropFile"
                        @change.prevent="selectFile">
                        <div class="flex flex-col items-center justify-center pt-5 pb-6">
                            <svg class="w-8 h-8 mb-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/>
                            </svg>
                            <p class="mb-2 text-sm">
                                Drag & drop shot, or click to browse for shot
                            </p>
                        </div>
                        <input id="dropzone-file" type="file" class="hidden" />
                    </label>
                </div>

                <div class="w-full">
                    <Input placeholder="or paste shot" class="text-center" @paste.prevent="pasteFile"/>

                    <div v-if="form.errors" class="text-red-500">
                        {{ Object.values(form.errors)[0] }}
                    </div>
                </div>
            </form>

            <div v-else class="pt-8 text-center">
                <Progress :model-value="form.progress.percentage" />
                <h3 class="font-semibold text-lg mt-4">Uploading...</h3>
            </div>
        </template>

        <div v-else class="text-center text-lg">
            Please Login or Sign Up to post a shot!
        </div> -->
    </Layout>
</template>
