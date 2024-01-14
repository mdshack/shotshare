<script setup>
import { Carousel, Slide, Pagination, Navigation } from 'vue3-carousel'
import { ref, onMounted } from 'vue'

import 'vue3-carousel/dist/carousel.css'

const props = defineProps({
    shots: Array,
})

defineEmits([
    'focus'
])

const shotImageCarousel = ref(null)

onMounted(() => {
    let params = new URLSearchParams(window.location.search)
    const selectedShot = params.get("selected_shot_id")

    if(selectedShot) {
        const shotIndex = props.shots.findIndex(({id}) => id == selectedShot)
        shotImageCarousel.value.slideTo(shotIndex)
    }
})
</script>

<template>
    <div v-if="shots.length > 1" class="flex justify-center rounded-lg border overflow-hidden">
        <carousel
            ref="shotImageCarousel"
            @slide-end="({currentSlideIndex}) => $emit('focus', currentSlideIndex)">
            <slide v-for="image in shots" :key="image.id">
                <img :src="image.links.asset_url"/>
            </slide>

            <template #addons>
                <navigation/>

                <pagination />
            </template>
        </carousel>
    </div>

    <div v-else class="flex justify-center rounded-lg border overflow-hidden">
        <img :src="shots[0].links.asset_url"/>
    </div>
</template>

<style>
:root {
    --vc-clr-primary: #ffffff;
    --vc-clr-secondary: #333;
    --vc-clr-white: #ffffff;
}
</style>
