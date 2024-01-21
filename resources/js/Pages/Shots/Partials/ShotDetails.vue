<script setup>
import RequireConfirmationDialog from '@/Components/RequireConfirmationDialog.vue';
import MustBeAuthenticatedDialog from '@/Components/MustBeAuthenticatedDialog.vue';
import UserAvatar from '@/Components/ui/UserAvatar.vue'
import { PopoverAnchor } from "radix-vue";

import { HandThumbUpIcon, HandThumbDownIcon, TrashIcon, PencilSquareIcon, Cog6ToothIcon, EyeSlashIcon, EyeIcon } from "@heroicons/vue/24/outline"
import axios from 'axios'
import { format } from 'timeago.js'
import { router, usePage } from '@inertiajs/vue3'
import { computed } from 'vue'
import { ref } from 'vue';
import {
    Popover,
    PopoverContent,
    PopoverTrigger,
} from '@/Components/ui/popover'
import { Checkbox } from '@/Components/ui/checkbox'
import Spinner from '@/Components/ui/Spinner.vue'

const props = defineProps({
    shot: Object,
    author: Object,
    reaction: Object,
    reactionCounts: Object,
    isOwner: Boolean,
})

const titleFocus = ref(false)

const reactToShot = (shotId, reaction) => {
    axios.post(route('shots.react', shotId), {
        'reaction': reaction
    }).then(() => {
        router.reload({ only: [
            'reaction',
            'reactionCounts',
        ]})
    })
}

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
            <Popover :open="titleFocus">
                <PopoverAnchor>
                    <h1
                        class="text-xl font-semibold"
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

            <div v-if="isOwner" class="flex items-center space-x-1">
                <button class="text-gray-500 hover:text-primary transition">
                    <PencilSquareIcon class="h-6 w-6" @click.prevent="$refs.name.focus()" />
                </button>

                <Popover>
                    <PopoverTrigger as="button" class="text-gray-500 hover:text-primary transition flex items-center justify-center">
                        <EyeIcon class="h-6 w-6"/>
                    </PopoverTrigger>
                    <PopoverContent>
                        <div class="grid gap-4">
                            <div class="space-y-2">
                                <h4 class="font-medium leading-none">
                                    Visibility
                                </h4>
                                <p class="text-sm text-muted-foreground">
                                    Set the shot's visibility settings.
                                </p>

                            </div>

                            <div class="flex items-center space-x-2">
                                <Checkbox
                                    v-if="!updating?.require_logged_in"
                                    id="require_logged_in"
                                    :checked="shot.require_logged_in"
                                    @update:checked="(checked) => updateShot({require_logged_in: checked})"
                                />
                                <Spinner v-else/>
                                <label
                                    for="require_logged_in"
                                    class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">
                                    Require viewers to be logged in
                                </label>
                            </div>

                            <div class="flex items-center space-x-2">
                                <Checkbox
                                    v-if="!updating?.anonymize"
                                    id="anonymize"
                                    :checked="shot.anonymize"
                                    @update:checked="(checked) => updateShot({anonymize: checked})"
                                />
                                <Spinner v-else/>
                                <label
                                    for="anonymize"
                                    class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">
                                    Anonymize "posted by" details
                                </label>
                            </div>
                        </div>
                    </PopoverContent>
                </Popover>

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

                    <button class="text-gray-500 hover:text-destructive transition flex items-center justify-center">
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
                    <div
                        class="font-semibold"
                        :class="{
                            'text-blue-500': author,
                            'text-gray-300': !author,
                        }">
                        {{ author?.name ?? "Anonymous User" }}
                    </div>
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
