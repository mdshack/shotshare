<script setup>
import { Aperture, Scan, Search } from 'lucide-vue-next'
import { computed } from 'vue';

const props = defineProps({
    size: {
        type: String,
        default: "sm"
    }
})

const sizeClass = computed(() => {
    return {
        sm: {
            scan: "w-8 h-8",
            aperture: "w-4 h-4",
        },
        md: {
            scan: "w-16 h-16",
            aperture: "w-8 h-8",
        },
        lg: {
            scan: "w-24 h-24",
            aperture: "w-12 h-12",
        },
    }[props.size]
})
</script>
<template>
    <div class="flex">
        <div class="relative">
            <div class="absolute top-0 left-0 right-0 bottom-0 flex items-center justify-center">
                <Aperture :class="sizeClass.aperture"/>
            </div>
            <Scan :class="sizeClass.scan"/>
            <span class="sr-only">ShotShare Logo</span>
        </div>
    </div>
</template>
