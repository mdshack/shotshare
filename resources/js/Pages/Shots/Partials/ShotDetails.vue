<script setup>
import UserAvatar from '@/Components/ui/UserAvatar.vue'

import { HandThumbUpIcon, HandThumbDownIcon, TrashIcon, PencilSquareIcon } from "@heroicons/vue/24/outline"
import axios from 'axios'
import { format } from 'timeago.js'
import { router } from '@inertiajs/vue3'

const props = defineProps({
    shot: Object,
    author: Object,
    reaction: Object,
    reactionCounts: Object,
})

const reactToShot = (shotId, reaction) => {
    axios.post(route('shots.react', shotId), {
        'reaction': reaction
    }).then(() => {
        router.reload({ only: [
            'reaction',
            'reactionCounts',
        ] })
    })
}
</script>

<template>
    <div class="space-y-2">
        <div class="flex items-center space-x-2">
            <h1 class="text-xl font-semibold">Name of my screen shot</h1>

            <!-- Owner Options -->
            <div v-if="author.id === $page.props.auth.user.id" class="flex items-center space-x-1">
                <button class="text-gray-500 hover:text-primary transition">
                    <PencilSquareIcon class="h-6 w-6" />
                </button>

                <button class="text-gray-500 hover:text-primary transition">
                    <TrashIcon class="h-6 w-6" />
                </button>
            </div>
        </div>

        <div class="flex items-center justify-between">
            <!-- User & Posted at -->
            <div class="flex items-center">
                <UserAvatar  class="text-lg" :user="author"/>
                <div class="flex flex-col text-sm">
                    <div class="text-blue-500 font-semibold">{{ author.name }}</div>
                    <div class="text-muted-foreground">{{ format(shot.created_at) }}</div>
                </div>
            </div>

            <!-- Reactions -->
            <div v-if="$page.props.features.reactions" class="flex space-x-4 text-xs">
                <button
                    @click.prevent="() => reactToShot(shot.id, 'upvote')"
                    class="text-gray-500 hover:text-green-500 transition"
                    :class="{'text-green-500': reaction?.reaction === 'upvote'}">
                    <HandThumbUpIcon class="h-6 w-6" />
                    {{ reactionCounts?.upvote ?? '0' }}
                </button>

                <button
                    @click.prevent="() => reactToShot(shot.id, 'downvote')"
                    class="text-gray-500 hover:text-red-500 transition"
                    :class="{'text-red-500': reaction?.reaction === 'downvote'}">
                    <HandThumbDownIcon class="h-6 w-6" />
                    {{ reactionCounts?.downvote ?? '0' }}
                </button>
            </div>
        </div>
    </div>
</template>
