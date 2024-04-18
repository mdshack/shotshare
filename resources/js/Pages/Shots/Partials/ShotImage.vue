<script setup>
import { Carousel, Slide, Pagination, Navigation } from 'vue3-carousel'
import { ref, onMounted } from 'vue'
import UserAvatar from '@/Components/ui/UserAvatar.vue'
import { ShareIcon, HeartIcon, EyeIcon, TrashIcon } from "@heroicons/vue/16/solid";
import { HandThumbDownIcon, HandThumbUpIcon } from "@heroicons/vue/24/outline";
import {
    Popover,
    PopoverContent,
    PopoverTrigger,
} from '@/Components/ui/popover'
import { PopoverAnchor } from "radix-vue";
import { router } from '@inertiajs/vue3'

import 'vue3-carousel/dist/carousel.css'

const props = defineProps({
    author: Object,
    shot: Object,
    shots: Array,
    isOwner: Boolean,
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

const titleFocus = ref(false)

let updating = ref({})

const updateShot = (body = {}) => {
    let updateKeys = Object.keys(body)

    updateKeys.forEach(key => updating.value[key] = true)

    return axios.patch(route('shots.update', props.shot.id), body)
        .then((response) => {
            router.reload({
                only: ['shot', 'author'],
                onFinish: () => updateKeys.forEach(key => updating.value[key] = false)
            })

            return response
        })
}

const updateName = (event) => {
    return updateShot({'name': event.target.innerText}).then(() => {
        event.target.blur()
    })
}

const activeButton = ref(null)
</script>

<template>
    <div class="grid grid-cols-12">
        <div class="col-span-3 pr-8">
            <div class="flex items-center">
                <UserAvatar class="text-lg mr-2" :user="author"/>
                <div>
                    <h5 class="font-semibold">Micah Shackelford</h5>
                    <span class="text-red-600 font-semibold text-sm">@mdshack</span>
                </div>
            </div>
            <p class="mt-4 max-h-[100px] text-gray-300">
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Quibusdam, at? Optio tempore quis cupiditate corporis perferendis quam voluptatum, modi iure dignissimos vitae minima quisquam doloribus ratione. Magni ab ipsum ullam?
            </p>
            <!-- <div class="mt-4">
                Links
            </div> -->
        </div>

        <div class="col-span-9">
            <div class="flex justify-between items-end mb-2">
                <Popover :open="titleFocus">
                    <PopoverAnchor>
                        <h1
                            class="font-bold text-lg"
                            :class="{'text-gray-400 italic': !shot.name}"
                            :contenteditable="isOwner"
                            ref="name"
                            @keydown.enter.prevent="updateName"
                            @focusin="() => titleFocus = true"
                            @focusout="() => titleFocus = false">
                            {{shot.name ?? "Unnamed Shot"}}
                        </h1>
                    </PopoverAnchor>
                    <PopoverContent
                        class="w-32 p-2 flex items-center justify-center"
                        align="start">
                        <div class="text-gray-500 flex items-center justify-center">
                            <kbd class="pointer-events-none inline-flex h-5 select-none items-center gap-1 rounded border bg-muted px-1.5 font-mono text-[10px] font-medium text-muted-foreground opacity-100 mr-1">
                                Enter
                            </kbd>
                            to save
                        </div>
                    </PopoverContent>
                </Popover>
                <!-- <div class="border rounded-lg flex items-center h-min">
                    <div class="flex p-2">
                        <HandThumbUpIcon class="w-5 mr-1"/>128
                    </div>
                    <div class="flex p-2">
                        <HandThumbDownIcon class="w-5 mr-1"/>0
                    </div>
                </div> -->
            </div>

            <div class="grid grid-cols-8">
                <div class="col-span-4 min-h-[175px]">
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
                </div>
                <div class="col-span-4 flex flex-col ml-8 justify-between">
                    <div class="flex justify-between">
                        <div class="space-y-4">
                            <button
                                class="text-lg font-semibold flex items-center transition"
                                :class="!activeButton || activeButton === 'favorite' ? 'text-white' : 'text-gray-400'"
                                @mouseover="activeButton = 'favorite'"
                                @mouseleave="activeButton = null">
                                <HeartIcon class="h-6 w-6 mr-3" />
                                Favorite
                            </button>

                            <button
                                class="text-lg font-semibold flex items-center transition"
                                :class="!activeButton || activeButton === 'share' ? 'text-white' : 'text-gray-400'"
                                @mouseover="activeButton = 'share'"
                                @mouseleave="activeButton = null">
                                <ShareIcon class="h-6 w-6 mr-3" />
                                Share
                            </button>

                            <button
                                class="text-lg font-semibold flex items-center transition"
                                :class="!activeButton || activeButton === 'delete' ? 'text-white' : 'text-gray-400'"
                                @mouseover="activeButton = 'delete'"
                                @mouseleave="activeButton = null">
                                <TrashIcon class="h-6 w-6 mr-3" />
                                Delete
                            </button>
                        </div>
                    </div>

                    <div>
                        <div class="flex items-center text-gray-400">
                            <EyeIcon class="h-5 w-5 mr-2" />
                            5,231 views
                        </div>
                    </div>
                </div>
            </div>

            <hr class="my-14"/>

            <h3 class="font-bold text-xl mb-4">More from @mdshack</h3>

            <div class="grid grid-cols-3 gap-4">
                <img :src="shots[0].links.asset_url"/>
                <img :src="shots[0].links.asset_url"/>
                <img :src="shots[0].links.asset_url"/>
                <img :src="shots[0].links.asset_url"/>
                <img :src="shots[0].links.asset_url"/>
                <img :src="shots[0].links.asset_url"/>
                <img :src="shots[0].links.asset_url"/>
                <img :src="shots[0].links.asset_url"/>
                <img :src="shots[0].links.asset_url"/>
                <img :src="shots[0].links.asset_url"/>
                <img :src="shots[0].links.asset_url"/>
                <img :src="shots[0].links.asset_url"/>
                <img :src="shots[0].links.asset_url"/>
                <img :src="shots[0].links.asset_url"/>
                <img :src="shots[0].links.asset_url"/>
                <img :src="shots[0].links.asset_url"/>
                <img :src="shots[0].links.asset_url"/>
                <img :src="shots[0].links.asset_url"/>
                <img :src="shots[0].links.asset_url"/>
                <img :src="shots[0].links.asset_url"/>
                <img :src="shots[0].links.asset_url"/>
                <img :src="shots[0].links.asset_url"/>
                <img :src="shots[0].links.asset_url"/>
                <img :src="shots[0].links.asset_url"/>
                <img :src="shots[0].links.asset_url"/>
                <img :src="shots[0].links.asset_url"/>
                <img :src="shots[0].links.asset_url"/>
                <img :src="shots[0].links.asset_url"/>
                <img :src="shots[0].links.asset_url"/>
                <img :src="shots[0].links.asset_url"/>
                <img :src="shots[0].links.asset_url"/>
                <img :src="shots[0].links.asset_url"/>
                <img :src="shots[0].links.asset_url"/>
                <img :src="shots[0].links.asset_url"/>
                <img :src="shots[0].links.asset_url"/>
            </div>
        </div>
    </div>
</template>

<style>
:root {
    --vc-clr-primary: #ffffff;
    --vc-clr-secondary: #333;
    --vc-clr-white: #ffffff;
}

.checkerboard {
    background-image: linear-gradient(45deg, #808080 25%, transparent 25%), linear-gradient(-45deg, #808080 25%, transparent 25%), linear-gradient(45deg, transparent 75%, #808080 75%), linear-gradient(-45deg, transparent 75%, #808080 75%);
    background-size: 20px 20px;
    background-position: 0 0, 0 10px, 10px -10px, -10px 0px;
}
</style>
