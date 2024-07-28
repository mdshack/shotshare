<script setup>
import { onMounted, ref } from 'vue'
import { ChatBubbleLeftRightIcon, EllipsisHorizontalIcon, HandThumbUpIcon } from '@heroicons/vue/24/outline';
import { ChatBubbleLeftRightIcon as ChatSolid, HandThumbUpIcon as HandSolid } from '@heroicons/vue/24/solid';

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
    DropdownMenuSeparator,
    DropdownMenuTrigger,
} from '@/Components/ui/dropdown-menu'
import { Dialog, DialogContent, DialogDescription, DialogFooter, DialogHeader, DialogTitle } from '@/Components/ui/dialog';
import { Button } from '@/Components/ui/button';
import User from '@/Components/User.vue'
import TimeAgo from '@/Components/ui/TimeAgo.vue'
import { Link, router, usePage } from '@inertiajs/vue3';
import axios from 'axios';
import ShotComments from '@/Components/ShotComments.vue';
import MustBeAuthenticatedDialog from '@/Components/MustBeAuthenticatedDialog.vue';
import RequireConfirmationDialog from '@/Components/RequireConfirmationDialog.vue';
import DialogEditShot from '@/Components/DialogEditShot.vue';

const props = defineProps({
    shot: Object,
    condensed: {
        type: Boolean,
        default: false,
    }
})

const emit = defineEmits([
    "focus-image"
])

const page = usePage()

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

const reactions = ref(null)
const loadReactions = () => {
    if(!page.props.features.reactions) return

    axios.get(route("shots.reactions.index", props.shot.id))
        .then(({data}) => {
            reactions.value = data
        })
}

onMounted(() => {
    loadReactions()
})

const commentsOpen = ref(false)

const react = (reaction) => {
    if(!page.props.features.reactions) return

    axios.post(route('shots.reactions.store', props.shot.id), {
        'reaction': reaction
    }).then(() => {
        loadReactions()
    })
}

const deleteShotOpen = ref(false)
const deleteShot = () => {
    return axios.delete(route('shots.destroy', props.shot.id))
        .finally(() => window.location.pathname = `/users/${page.props.auth.user.handle}`)
}

const editShotOpen = ref(false)
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

            <DropdownMenu v-if="shot.is_owner">
                <DropdownMenuTrigger>
                    <Button variant="ghost" class="px-2">
                        <EllipsisHorizontalIcon class="w-7"/>
                    </Button>
                </DropdownMenuTrigger>
                <DropdownMenuContent align="end">
                    <DropdownMenuItem class="cursor-pointer" @click.prevent="editShotOpen = true">
                        Edit Shot
                    </DropdownMenuItem>

                    <DropdownMenuSeparator />

                    <DropdownMenuItem class="cursor-pointer text-red-500" @click.prevent="deleteShotOpen = true">
                        Delete Shot
                    </DropdownMenuItem>
                </DropdownMenuContent>
            </DropdownMenu>
        </div>

        <Carousel v-if="shot.type === 'collection'" @init-api="setApi" class="bg-muted">
            <CarouselContent class="flex items-center">
                <CarouselItem v-for="upload in shot.uploads"><img :src="upload.url" class="w-full bg-muted"/></CarouselItem>
            </CarouselContent>
            <CarouselPrevious />
            <CarouselNext />
        </Carousel>

        <img v-else-if="shot.type === 'individual'" :src="shot.uploads[0].url" class="w-full bg-muted"/>

        <div class="p-4 flex justify-between items-end">
            <div class="text-muted-foreground">
                <Link
                    class="mb-2 text-xl hover:underline flex"
                    :class="shot.name ? 'font-semibold text-primary' : 'italic'"
                    :href="route('shots.show', shot.id)">
                    {{ shot?.name ?? 'Unnamed Shot' }}
                </Link>

                <div v-if="reactions && page.props.features.reactions">
                    <template v-if="reactions.count !== 0">
                        <template
                            v-if="reactions.users.length"
                            v-for="(user, i) in reactions.users">
                            <span class="font-semibold text-primary">{{ user.handle }}</span>{{ reactions.users.length > 1 ? ', ' : '' }}
                            {{ i === reactions.users.length - 1 && (reactions.count - reactions.users.length) > 0 ? 'and' : '' }}
                        </template>
                        <template v-if="(reactions.count - reactions.users.length) > 0">
                            {{' '}}{{ (reactions.count - reactions.users.length).toLocaleString() }} {{ reactions.users.length > 0 ? 'other' : '' }}{{ reactions.users.length > 1 ? 's' : '' }} liked
                        </template>
                        <template v-else>
                            liked
                        </template>
                    </template>
                    <div v-else>
                        Nobody has liked this, be the first!
                    </div>
                </div>
            </div>
            <div class="space-x-4 flex">
                <button v-if="page.props.features.comments && condensed" class="hover:text-primary text-muted-foreground transition" @click.prevent="commentsOpen = !commentsOpen">
                    <ChatBubbleLeftRightIcon v-if="!commentsOpen" class="w-5"/>
                    <ChatSolid v-else class="w-5"/>
                </button>

                <MustBeAuthenticatedDialog v-if="page.props.features.reactions" @click.prevent="() => react('upvote')">
                    <button class="hover:text-primary text-muted-foreground transition">
                        <HandThumbUpIcon v-if="!(reactions?.current_user ?? false)" class="w-5 text-muted-foreground"/>
                        <HandSolid v-else class="w-5 text-muted-foreground"/>
                    </button>
                </MustBeAuthenticatedDialog>
            </div>
        </div>

        <div v-if="commentsOpen" class="border-t">
            <h5 class="font-semibold p-4 pb-0">Comments</h5>
            <ShotComments :shot="shot"/>
        </div>
    </div>

    <div class="!my-0 !py-0">
        <RequireConfirmationDialog
            v-if="deleteShotOpen"
            :open="true"
            :action="deleteShot">
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
        </RequireConfirmationDialog>

        <DialogEditShot
            v-if="editShotOpen"
            :shot="shot"
            @close="editShotOpen = false"
        />
    </div>
</template>
