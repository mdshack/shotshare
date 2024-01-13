<script setup>
import Layout from '@/Layouts/Layout.vue'
import { Input } from '@/Components/ui/input'
import { Label } from '@/Components/ui/label'
import { Button } from '@/Components/ui/button'
import { UseClipboard } from '@vueuse/components'
import { ClipboardIcon, CheckIcon } from "@heroicons/vue/24/outline";
import { Head } from '@inertiajs/vue3';

const props = defineProps({
    shot: Object,
    childShots: Array,
})

let shots = [
    props.shot,
    ...props.childShots
].map((s) => ({
    ...s,
    urls: [
        {
            label: "Share Link",
            value: s.links.url
        },
        {
            label: "Direct Link",
            value: s.links.asset_url
        },
        {
            label: "Markdown (Reddit)",
            value: `[Alt Text](${s.links.asset_url})`
        },
        {
            label: "Markdown (GitHub & StackOverflow)",
            value: `![Alt Text](${s.links.asset_url})`
        },
        {
            label: "BBCode",
            value: `[url=${s.links.url}][img]${s.links.asset_url}[/img][/url]`
        },
        {
            label: "HTML",
            value: `<a href='${s.links.url}' target='_blank'><img src='${s.links.asset_url}' border='0' alt='Alt Text'/></a>`
        },
    ]
}))

const stringToId = (str) => {
    return str.toLowerCase().replace(" ", "-")
}
</script>

<template>
    <Head title="Shot" />

    <Layout>
        <div class="space-y-8">
            <div v-for="image in shots" class="space-y-4">
                <div class="flex justify-center py-4 rounded-lg border">
                    <img :src="image.links.asset_url"/>
                </div>

                <div v-for="url in image.urls">
                    <Label :for="stringToId(image.id + '-' + url.label)" class="mb-2">{{url.label}}</Label>
                    <div class="relative">
                        <Input :id="stringToId(image.id + '-' + url.label)" :model-value="url.value" disabled/>
                        <UseClipboard
                            v-slot="{ copy, copied }"
                            :source="url.value">
                            <Button
                                @click.prevent="copy()"
                                class="absolute right-0 top-0 bottom-0 text-accent hover:text-primary"
                                variant="ghost">
                                <CheckIcon v-if="copied" class="h-5 w-5 text-green-500" />
                                <ClipboardIcon v-else class="h-5 w-5" />
                            </Button>
                        </UseClipboard>
                    </div>
                </div>
            </div>
        </div>
    </Layout>
</template>
