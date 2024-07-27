<script setup>
import { ref } from 'vue'
import { ChatBubbleLeftRightIcon, EllipsisHorizontalIcon, HandThumbUpIcon } from '@heroicons/vue/24/outline';

import { Button } from '@/Components/ui/button';
import UserAvatar from '@/Components/ui/UserAvatar.vue'
import TimeAgo from '@/Components/ui/TimeAgo.vue'
import { Link } from '@inertiajs/vue3';

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
                        <Link
                            v-if="shot.author"
                            class="font-semibold hover:underline"
                            :href="route('users.show', shot.author?.handle)">
                            {{ shot.author?.name ?? "Anonymous User" }}
                        </Link>
                        <div
                            v-else
                            class="font-semibold hover:underline italic">
                            Anonymous User
                        </div>
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
