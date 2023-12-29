<script setup>
import Layout from '@/Layouts/Layout.vue'
import { Input } from '@/Components/ui/input'
import { Label } from '@/Components/ui/label'
import { Button } from '@/Components/ui/button'
import { UseClipboard } from '@vueuse/components'
import { ClipboardIcon, CheckIcon } from "@heroicons/vue/24/outline";
import { Head } from '@inertiajs/vue3';

const props = defineProps({
    shot: Object
})

const urls = [
    {
        label: "Share Link",
        value: window.location.href
    },
    {
        label: "Direct Link",
        value: props.shot.url
    },
    {
        label: "Markdown (Reddit)",
        value: `[Alt Text](${props.shot.url})`
    },
    {
        label: "Markdown (GitHub & StackOverflow)",
        value: `![Alt Text](${props.shot.url})`
    },
    {
        label: "BBCode",
        value: `[url=${window.location.href}][img]${props.shot.url}[/img][/url]`
    },
    {
        label: "HTML",
        value: `<a href='${window.location.href}' target='_blank'><img src='${props.shot.url}' border='0' alt='Alt Text'/></a>`
    },
]
</script>

<template>
    <Head title="Shot" />

    <Layout>
        <div class="space-y-4">

            <div class="flex justify-center py-4 rounded-lg border">
                <img :src="shot.url"/>
            </div>

            <div v-for="url in urls">
                <Label for="email" class="mb-2">{{url.label}}</Label>
                <div class="relative">
                    <Input :model-value="url.value"/>
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
    </Layout>
</template>
