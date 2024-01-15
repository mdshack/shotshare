<script setup>
import RequireConfirmationDialog from '@/Components/RequireConfirmationDialog.vue';
import MustBeAuthenticatedDialog from '@/Components/MustBeAuthenticatedDialog.vue';
import UserAvatar from '@/Components/ui/UserAvatar.vue'

import { HandThumbUpIcon, HandThumbDownIcon, TrashIcon, PencilSquareIcon } from "@heroicons/vue/24/outline"
import axios from 'axios'
import { format } from 'timeago.js'
import { router, usePage } from '@inertiajs/vue3'
import { computed } from 'vue'

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

const isOwner = computed(() => {
    return props.author.id === usePage().props.auth.user?.id
})

const updateName = (event) => {
    axios
        .patch(route('shots.update', props.shot.id), {
            'name': event.target.innerText
        })
        .then(() => {
            event.target.blur()
            router.reload({ only: [
                'shot',
            ] })
        })
}

const deleteShot = () => {
    axios
        .delete(route('shots.destroy', props.shot.id))
        .then(() => {
            router.visit(route('shots.index'))
        })
}
</script>

<template>
    <div class="space-y-2">
        <div v-if="shot.name || isOwner" class="flex items-center space-x-2">
            <h1
                class="text-xl font-semibold"
                :class="{'text-gray-400 italic': !shot.name}"
                :contenteditable="isOwner"
                @keydown.enter.prevent="updateName">
                {{shot.name ?? "Unnamed Shot"}}
            </h1>

            <div v-if="isOwner" class="flex items-center space-x-1">
                <RequireConfirmationDialog :action="deleteShot">
                    <template #title>
                        Are you sure you wish to delete this shot?
                    </template>

                    <template #description>
                        Deleting shots is a destructive action. You will not be able to recover this image if you delete it.
                    </template>

                    <template #reject>
                        Cancel
                    </template>

                    <template #confirm>
                        Delete Shot
                    </template>

                    <button class="text-gray-500 hover:text-primary transition">
                        <TrashIcon class="h-6 w-6" />
                    </button>
                </RequireConfirmationDialog>
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
                <MustBeAuthenticatedDialog :action="() => reactToShot(shot.id, 'upvote')">
                    <button
                        class="text-gray-500 hover:text-green-500 transition"
                        :class="{'text-green-500': reaction?.reaction === 'upvote'}">
                        <HandThumbUpIcon class="h-6 w-6" />
                        {{ reactionCounts?.upvote ?? '0' }}
                    </button>
                </MustBeAuthenticatedDialog>

                <MustBeAuthenticatedDialog :action="() => reactToShot(shot.id, 'downvote')">
                    <button
                        class="text-gray-500 hover:text-red-500 transition"
                        :class="{'text-red-500': reaction?.reaction === 'downvote'}">
                        <HandThumbDownIcon class="h-6 w-6" />
                        {{ reactionCounts?.downvote ?? '0' }}
                    </button>
                </MustBeAuthenticatedDialog>
            </div>
        </div>
    </div>
</template>
