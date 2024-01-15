<script setup>
import { Input } from '@/Components/ui/input'
import { Label } from '@/Components/ui/label'
import { Button } from '@/Components/ui/button'
import { UseClipboard } from '@vueuse/components'
import { ClipboardIcon, CheckIcon } from "@heroicons/vue/24/outline"
import { computed } from 'vue'

const props = defineProps({
    shots: Array,
    selectedIndex: Number,
    showLinks: Object
})

const selectedShot = computed(() => {
    return props.shots[props.selectedIndex]
})

const stringToId = (str) => {
    return str
        .toLowerCase()
        .replace("_", "-")
        .replace(" ", "-")
}

const getShotLinks = (targetShot) => {
    return [
        {
            id: "share",
            label: "Share Link",
            value: targetShot.links.url
        },
        {
            id: "direct",
            label: "Direct Link",
            value: targetShot.links.asset_url
        },
        {
            id: "markdown_reddit",
            label: "Markdown (Reddit)",
            value: `[Alt Text](${targetShot.links.asset_url})`
        },
        {
            id: "markdown_other",
            label: "Markdown (GitHub & StackOverflow)",
            value: `![Alt Text](${targetShot.links.asset_url})`
        },
        {
            id: "bbcode",
            label: "BBCode",
            value: `[url=${targetShot.links.url}][img]${targetShot.links.asset_url}[/img][/url]`
        },
        {
            id: "html",
            label: "HTML",
            value: `<a href='${targetShot.links.url}' target='_blank'><img src='${targetShot.links.asset_url}' border='0' alt='Alt Text'/></a>`
        },
    ]
}
</script>

<template>
    <div class="space-y-2">
        <div v-for="image in shots" v-show="image.id === selectedShot.id">
            <div v-for="url in getShotLinks(image)" v-show="showLinks[url.id] ?? true">
                <Label :for="stringToId(image.id + '-' + url.id)" class="mb-2">{{url.label}}</Label>
                <div class="relative">
                    <Input :id="stringToId(image.id + '-' + url.id)" :model-value="url.value" disabled/>
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
</template>
