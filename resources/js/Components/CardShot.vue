<script setup>
import { ref } from 'vue'
import { ChatBubbleLeftRightIcon, EllipsisHorizontalIcon, HandThumbUpIcon } from '@heroicons/vue/24/outline';

import ShotImage from '@/Pages/Shots/Partials/ShotImage.vue'
import ShotDetails from '@/Pages/Shots/Partials/ShotDetails.vue'
import ShotLinks from '@/Pages/Shots/Partials/ShotLinks.vue'
import UserAvatar from '@/Components/ui/UserAvatar.vue'
import TimeAgo from '@/Components/ui/TimeAgo.vue'

defineProps({
    shot: Object
})
</script>

<template>
    <div class="border rounded-lg">
        <div class="flex justify-between items-start p-4">
            <div class="space-y-2">
                <div class="flex items-center">
                    <UserAvatar :user="shot.author"/>
                    <div>
                        <h5 class="font-semibold" :class="{'italic': !shot.author?.name}">{{ shot.author?.name ?? "Anonymous User" }}</h5>
                        <div class="text-muted-foreground">
                            <span :class="{'italic': !shot.author?.handle}">{{ shot.author?.handle ?? 'none' }}</span>
                            •
                            <TimeAgo :datetime="shot.created_at"/>
                        </div>
                    </div>
                </div>
            </div>

            <Button variant="ghost" class="px-2">
                <EllipsisHorizontalIcon class="w-7"/>
            </Button>
        </div>

        <img :src="shot.uploads[0]" class="w-full bg-muted"/>

        <div class="p-4 flex justify-between items-end">
            <div class="text-muted-foreground">
                <h5 class="mb-2 text-xl" :class="shot.title ? 'font-semibold text-primary' : 'italic'">
                    {{ shot?.title ?? 'Unnamed Shot' }}
                </h5>
                <span class="font-semibold text-primary">Micah</span> and 4,123 others liked
            </div>
            <div class="space-x-4 flex">
                <ChatBubbleLeftRightIcon class="w-5 text-muted-foreground"/>
                <HandThumbUpIcon class="w-5 text-muted-foreground"/>
            </div>
        </div>
    </div>
</template>
