<script setup>
import Layout from '@/Layouts/Layout.vue'
import { Input } from '@/Components/ui/input'
import { Label } from '@/Components/ui/label'
import { Button } from '@/Components/ui/button'
import { UseClipboard } from '@vueuse/components'
import { ClipboardIcon, CheckIcon } from "@heroicons/vue/24/outline";
import { Head } from '@inertiajs/vue3';

defineProps({
    shot: Object
})

const shareUrl = window.location.href
</script>

<template>
    <Head title="Shot" />

    <Layout>
        <div class="space-y-4">

            <div class="flex justify-center py-4 rounded-lg border">
                <img :src="shot.url"/>
            </div>

            <div>
                <Label for="email" class="mb-2">Share Link</Label>
                <div class="relative">
                    <Input :model-value="shareUrl"/>
                    <UseClipboard
                        v-slot="{ copy, copied }"
                        :source="shareUrl">
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

            <div>
                <Label for="email" class="mb-2">Image URL</Label>
                <div class="relative">
                    <Input :model-value="shot.url"/>
                    <UseClipboard
                        v-slot="{ copy, copied }"
                        :source="shot.url">
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
