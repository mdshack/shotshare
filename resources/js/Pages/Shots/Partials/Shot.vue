<script setup>
import { computed, ref } from 'vue'
import {
    HandThumbDownIcon,
    HandThumbUpIcon,
    ClipboardIcon,
    CheckIcon,
} from "@heroicons/vue/24/outline"
import {
    ShareIcon,
    HeartIcon,
    AdjustmentsVerticalIcon,
    CalendarIcon,
    EyeIcon,
    TrashIcon,
    HandThumbUpIcon as HandThumbUpIconSolid,
    HandThumbDownIcon as HandThumbDownIconSolid,
    XMarkIcon,
} from "@heroicons/vue/20/solid"
import { UseClipboard } from '@vueuse/components'
import { PopoverAnchor } from "radix-vue"
import { router } from '@inertiajs/vue3'

import {
    Popover,
    PopoverContent,
    PopoverTrigger,
} from '@/Components/ui/popover'
import { Input } from '@/Components/ui/input'
import { Label } from '@/Components/ui/label'
import { Button } from '@/Components/ui/button'
import { Checkbox } from '@/Components/ui/checkbox'
import Spinner from '@/Components/ui/Spinner.vue'

import RequireConfirmationDialog from '@/Components/RequireConfirmationDialog.vue';
import MustBeAuthenticatedDialog from '@/Components/MustBeAuthenticatedDialog.vue';
import TimeAgo from '@/Components/ui/TimeAgo.vue'

const props = defineProps({
    shot: Object,
    reaction: Object,
    reactionCounts: Object,
    views: Number,
    isOwner: Boolean,
    isFavorite: Boolean,
})

const titleFocus = ref(false)

const activeButton = ref(null)

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

const deleteShot = () => {
    return axios.delete(route('shots.destroy', props.shot.id))
        .then(() => {
            router.visit(route('shots.index'))
        })
}

const updateName = (event) => {
    return updateShot({'name': event.target.innerText}).then(() => {
        event.target.blur()
    })
}

const reactToShot = (shotId, reaction) => {
    return axios.post(route('shots.react', shotId), {
        'reaction': reaction
    }).then(() => {
        router.reload({ only: [
            'reaction',
            'reactionCounts',
        ]})
    })
}

const toggleFavorite = () => {
    const request = props.isFavorite
        ? axios.delete(route('shots.unfavorite', props.shot.id))
        : axios.post(route('shots.favorite', props.shot.id))

    return request.then(() => {
        router.reload(['isFavorite'])
    })
}

const shotLinks = computed(() => {
    return [
        {
            id: "share",
            label: "Share Link",
            value: props.shot.links.url
        },
        {
            id: "direct",
            label: "Direct Link",
            value: props.shot.links.asset_url
        },
        {
            id: "markdown_reddit",
            label: "Markdown (Reddit)",
            value: `[Alt Text](${props.shot.links.asset_url})`
        },
        {
            id: "markdown_other",
            label: "Markdown (GitHub & StackOverflow)",
            value: `![Alt Text](${props.shot.links.asset_url})`
        },
        {
            id: "bbcode",
            label: "BBCode",
            value: `[url=${props.shot.links.url}][img]${props.shot.links.asset_url}[/img][/url]`
        },
        {
            id: "html",
            label: "HTML",
            value: `<a href='${props.shot.links.url}' target='_blank'><img src='${props.shot.links.asset_url}' border='0' alt='Alt Text'/></a>`
        },
    ]
})

const shareOpen = ref(false)

const settingsOpen = ref(false)
</script>

<template>
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
    </div>

    <div class="grid grid-cols-8">
        <div class="col-span-8 sm:col-span-4 min-h-[175px]">
            <!-- TODO: Handle multiple shots view -->

            <div class="flex justify-center rounded-lg border overflow-hidden relative">
                <img :src="shot.links.asset_url"/>

                <div v-if="shareOpen" class="absolute w-full h-full left-0 top-0 bg-black/75 flex items-center justify-center flex-col">
                    <Button
                        variant="ghost"
                        class="absolute top-0 right-0 mr-1 mt-1 px-2"
                        @click="shareOpen = false">
                        <XMarkIcon class="w-6"/>
                    </Button>
                    <h1 class="text-2xl font-semibold tracking-tight">
                        Share
                    </h1>
                    <div class="px-6 w-full space-y-2 max-h-[70%] overflow-y-auto">
                        <div v-for="link in shotLinks">
                            <Label class="mb-2">{{link.label}}</Label>
                            <div class="relative">
                                <Input :model-value="link.value" disabled/>
                                <UseClipboard
                                    v-slot="{ copy, copied }"
                                    :source="link.value">
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

                <div v-if="settingsOpen" class="absolute w-full h-full left-0 top-0 bg-black/75 flex items-center justify-center flex-col">
                    <Button
                        variant="ghost"
                        class="absolute top-0 right-0 mr-1 mt-1 px-2"
                        @click="settingsOpen = false">
                        <XMarkIcon class="w-6"/>
                    </Button>
                    <h1 class="text-2xl font-semibold tracking-tight">
                        Settings
                    </h1>
                    <div class="grid gap-4 mt-8">
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
                </div>
            </div>
        </div>
        <div class="col-span-8 sm:col-span-4 flex flex-col sm:ml-8 sm:mt-0 mt-8 justify-between">
            <div class="flex justify-between">
                <div class="space-y-4">
                    <MustBeAuthenticatedDialog :action="toggleFavorite">
                        <button
                            class="text-lg font-semibold flex items-center transition"
                            :class="!activeButton || activeButton === 'favorite' ? 'text-white' : 'text-gray-400'"
                            @mouseover="activeButton = 'favorite'"
                            @mouseleave="activeButton = null">
                            <HeartIcon class="h-6 w-6 mr-3" />
                            {{ isFavorite ? "Unfavorite" : "Favorite" }}
                        </button>
                    </MustBeAuthenticatedDialog>

                    <button
                        class="text-lg font-semibold flex items-center transition"
                        :class="!activeButton || activeButton === 'share' ? 'text-white' : 'text-gray-400'"
                        @mouseover="activeButton = 'share'"
                        @mouseleave="activeButton = null"
                        @click="shareOpen = !shareOpen">
                        <ShareIcon class="h-6 w-6 mr-3" />
                        Share
                    </button>

                    <template v-if="isOwner">
                        <button
                            class="text-lg font-semibold flex items-center transition"
                            :class="!activeButton || activeButton === 'Settings' ? 'text-white' : 'text-gray-400'"
                            @mouseover="activeButton = 'Settings'"
                            @mouseleave="activeButton = null"
                            @click="settingsOpen = !settingsOpen">
                            <AdjustmentsVerticalIcon class="h-6 w-6 mr-3" />
                            Settings
                        </button>

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

                            <button
                                class="text-lg font-semibold flex items-center transition"
                                :class="!activeButton || activeButton === 'delete' ? 'text-white' : 'text-gray-400'"
                                @mouseover="activeButton = 'delete'"
                                @mouseleave="activeButton = null">
                                <TrashIcon class="h-6 w-6 mr-3" />
                                Delete
                            </button>
                        </RequireConfirmationDialog>
                    </template>
                </div>
            </div>

            <div class="flex justify-between items-end">
                <div class="space-y-2 text-sm">
                    <div class="flex items-center text-gray-400">
                        <EyeIcon class="h-5 w-5 mr-2" />
                        {{ views }} view{{ views != 1 ? 's' : '' }}
                    </div>
                    <div class="flex items-center text-gray-400">
                        <CalendarIcon class="h-5 w-5 mr-2" />
                        <TimeAgo :datetime="shot.created_at"/>
                    </div>
                </div>
                <div class="border rounded-lg flex items-center h-min">
                    <MustBeAuthenticatedDialog :action="() => reactToShot(shot.id, 'upvote')">
                        <button
                            class="flex items-center  hover:text-green-500 p-2 transition"
                            :class="reaction?.reaction === 'upvote' ? 'text-green-600' : 'text-white'">
                            <HandThumbUpIcon v-if="reaction?.reaction !== 'upvote'" class="w-5 mr-1"/>
                            <HandThumbUpIconSolid v-else class="w-5 mr-1" />
                            {{ reactionCounts?.upvote ?? '0' }}
                        </button>
                    </MustBeAuthenticatedDialog>
                    <MustBeAuthenticatedDialog :action="() => reactToShot(shot.id, 'downvote')">
                        <button
                            class="flex items-center hover:text-red-500 p-2"
                            :class="reaction?.reaction === 'downvote' ? 'text-red-600' : 'text-white'">
                            <HandThumbDownIcon v-if="reaction?.reaction !== 'downvote'" class="w-5 mr-1"/>
                            <HandThumbDownIconSolid v-else class="w-5 mr-1" />
                            {{ reactionCounts?.downvote ?? '0' }}
                        </button>
                    </MustBeAuthenticatedDialog>
                </div>
            </div>
        </div>
    </div>
</template>
