<script setup>
import { ref } from 'vue'
import { ChatBubbleLeftRightIcon, EllipsisHorizontalIcon, HandThumbUpIcon } from '@heroicons/vue/24/outline';

import {
    Carousel,
    CarouselContent,
    CarouselItem,
    CarouselNext,
    CarouselPrevious,
} from '@/Components/ui/carousel'
import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuItem,
    DropdownMenuLabel,
    DropdownMenuSeparator,
    DropdownMenuTrigger,
} from '@/Components/ui/dropdown-menu'
import { Button } from '@/Components/ui/button';
import UserAvatar from '@/Components/ui/UserAvatar.vue'
import User from '@/Components/User.vue'
import TimeAgo from '@/Components/ui/TimeAgo.vue'
import { useCarousel } from '@/Components/ui/carousel'
import throttle from "lodash/throttle"
import { Link } from '@inertiajs/vue3';

defineProps({
    shot: Object
})

const emit = defineEmits([
    "focus-image"
])

const currentSlide = ref(0)

const api = ref(null)

const setApi = (value) => {
    api.value = value
    api.value.on("select", () => {
        // TODO: Find a more consistent method of finding the current image
        setTimeout(() => {
            const inView = api.value.slidesInView().filter(i => i !== currentSlide.value)
            currentSlide.value = inView[0]
            emit("focus-image", currentSlide.value)
        }, 100)
    })
}
</script>

<template>
    <div class="border rounded-lg">
        <div class="flex justify-between items-start p-4">
            <div class="space-y-2">
                <User :user="shot.author">
                    <template #after-handle>
                        •
                        <TimeAgo :datetime="shot.created_at"/>
                    </template>
                </User>
            </div>

            <DropdownMenu v-if="shot.author.id === $page.props.auth.user.id">
                <DropdownMenuTrigger>
                    <Button variant="ghost" class="px-2">
                        <EllipsisHorizontalIcon class="w-7"/>
                    </Button>
                </DropdownMenuTrigger>
                <DropdownMenuContent align="end">
                    <DropdownMenuItem class="cursor-pointer">
                        Edit Shot
                    </DropdownMenuItem>

                    <DropdownMenuSeparator />

                    <DropdownMenuItem class="cursor-pointer text-red-500">
                        Delete Shot
                    </DropdownMenuItem>
                </DropdownMenuContent>
            </DropdownMenu>
        </div>

        <Carousel v-if="shot.type === 'collection'" @init-api="setApi" class="bg-muted">
            <CarouselContent class="flex items-center">
                <CarouselItem v-for="upload in shot.uploads"><img :src="upload" class="w-full bg-muted"/></CarouselItem>
            </CarouselContent>
            <CarouselPrevious />
            <CarouselNext />
        </Carousel>

        <img v-else-if="shot.type === 'individual'" :src="shot.uploads[0]" class="w-full bg-muted"/>

        <div class="p-4 flex justify-between items-end">
            <div class="text-muted-foreground">
                <Link
                    class="mb-2 text-xl hover:underline flex"
                    :class="shot.name ? 'font-semibold text-primary' : 'italic'"
                    :href="route('shots.show', shot.id)">
                    {{ shot?.name ?? 'Unnamed Shot' }}
                </Link>
                <span class="font-semibold text-primary">Micah</span> and 4,123 others liked
            </div>
            <div class="space-x-4 flex">
                <ChatBubbleLeftRightIcon class="w-5 text-muted-foreground"/>
                <HandThumbUpIcon class="w-5 text-muted-foreground"/>
            </div>
        </div>
    </div>
</template>
