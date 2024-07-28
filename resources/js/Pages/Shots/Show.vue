<script setup>
import Layout from '@/Layouts/Layout.vue'
import { Head, router } from '@inertiajs/vue3'
import { ref, computed, onMounted } from 'vue'
import ShotImage from '@/Pages/Shots/Partials/ShotImage.vue'
import ShotDetails from '@/Pages/Shots/Partials/ShotDetails.vue'
import ShotLinks from '@/Pages/Shots/Partials/ShotLinks.vue'
import { ChatBubbleLeftRightIcon, CheckIcon, ClipboardIcon, EllipsisHorizontalIcon, HandThumbUpIcon, InformationCircleIcon } from '@heroicons/vue/24/outline';
import { Button } from '@/Components/ui/button'
import UserAvatar from '@/Components/ui/UserAvatar.vue'
import TimeAgo from '@/Components/ui/TimeAgo.vue'

import { TabsContent, TabsIndicator, TabsList, TabsRoot, TabsTrigger } from 'radix-vue'


import CardShot from '@/Components/CardShot.vue'
import User from '@/Components/User.vue'
import { Input } from '@/Components/ui/input'
import { Label } from '@/Components/ui/label'
import { UseClipboard } from '@vueuse/components'
import Spinner from '@/Components/ui/Spinner.vue'

const props = defineProps({
    shot: Object,
    tab: String,

    comments: Object,
})

const focusedImageIndex = ref(0)
const focusedImageLink = computed(() => {
    return props.shot.uploads[focusedImageIndex.value]
})

const commentsLoading = ref(true)
const formattedComments = ref([])
const loadComments = (extra = {}) => {
    router.reload({
        ...extra,
        only: ["comments"],
        onSuccess: () => {
            formattedComments.value = [...formattedComments.value, ...props.comments.data]

            formattedComments.value.sort((a,b) => {
                if (a.created_at > b.created_at) {
                    return -1
                } else if (a.created_at < b.created_at) {
                    return 1
                }

                return 0
            })

            commentsLoading.value = false
        }
    })
}

onMounted(() => {
    loadComments()
})

const commentContents = ref("")
const submitComment = () => {
    router.post(route("shots.comments.store", props.shot.id), {contents: commentContents.value}, {
        onBefore: () => {
            commentContents.value = ""
        },
        onSuccess: () => {
            loadComments()
        }
    })
}

const loadMore = () => {
    loadComments({
        data: {
            comments_cursor: props.comments.next_cursor
        }
    })
}
</script>

<template>
    <Head title="Shot" />

    <Layout>
        <div class="space-y-8">
            <CardShot :shot="shot" @focus-image="(i) => focusedImageIndex = i"/>

            <div class="border rounded-lg">
                <TabsRoot :default-value="tab ?? 'comments'">
                    <TabsList>
                        <TabsTrigger as-child value="comments">
                            <button class="text-muted-foreground hover:text-primary p-4 data-[state=active]:border-b-2 data-[state=active]:font-semibold data-[state=active]:text-primary data-[state=active]:border-primary transition">
                                Comments
                            </button>
                        </TabsTrigger>

                        <TabsTrigger as-child value="share">
                            <button class="text-muted-foreground hover:text-primary p-4 data-[state=active]:border-b-2 data-[state=active]:font-semibold data-[state=active]:text-primary data-[state=active]:border-primary transition">
                                Share Links
                            </button>
                        </TabsTrigger>

                        <TabsTrigger as-child value="info">
                            <button class="text-muted-foreground hover:text-primary p-4 data-[state=active]:border-b-2 data-[state=active]:font-semibold data-[state=active]:text-primary data-[state=active]:border-primary transition">
                                More Info
                            </button>
                        </TabsTrigger>
                        <div class="grow border-b" />
                    </TabsList>

                    <div>
                        <TabsContent value="comments">
                            <div class="divide-y">
                                <div class="p-4">
                                    <div class="relative">
                                        <Input v-model="commentContents" placeholder="Add your comment" class="peer" @keyup.enter="submitComment"/>
                                        <kbd
                                            class="transition opacity-0 peer-focus:opacity-100 inline-flex absolute top-0 bottom-0 right-0 my-auto mr-2 pointer-events-none h-5 select-none items-center gap-1 rounded border bg-muted px-1.5 font-mono text-[10px] font-medium text-muted-foreground">
                                            enter to post
                                        </kbd>
                                    </div>
                                </div>

                                <div v-if="!formattedComments.length && !commentsLoading" class="p-4 text-muted-foreground text-center">
                                    Nothing to see here
                                </div>

                                <div
                                    v-for="comment in formattedComments"
                                    class="p-4">
                                    <User :user="comment.user">
                                        <template #after-handle>
                                            •
                                            <TimeAgo :datetime="comment.created_at"/>
                                        </template>
                                    </User>
                                    <div class="ml-12 mt-2">
                                        {{ comment.contents }}
                                    </div>
                                </div>
                            </div>
                            <div v-if="commentsLoading || comments?.next_cursor" class="p-4 flex justify-center">
                                <template>
                                    <Spinner/>
                                    <span class="sr-only">Loading</span>
                                </template>

                                <Button
                                    v-if="comments?.next_cursor"
                                    variant="outline"
                                    @click.prevent="loadMore">
                                    Load More
                                </Button>
                            </div>
                        </TabsContent>

                        <TabsContent value="share">
                            <div class="p-4 space-y-4">
                                <div>
                                    <Label class="space-y-1">
                                        <div>
                                            Share Link
                                        </div>
                                        <div class="relative">
                                            <Input :model-value="shot.url" disabled/>
                                            <UseClipboard
                                                v-slot="{ copy, copied }"
                                                :source="shot.url">
                                                <Button
                                                    @click.prevent="copy()"
                                                    class="absolute right-0 top-0 bottom-0 text-accent hover:text-primary"
                                                    variant="ghost">
                                                    <CheckIcon v-if="copied" class="h-5 w-5 text-green-500" />
                                                    <ClipboardIcon v-else class="h-5 w-5" />
                                                </Button>
                                            </UseClipboard>
                                        </div>
                                    </Label>
                                </div>

                                <div>
                                    <Label class="space-y-1">
                                        <div>
                                            Direct Link
                                        </div>
                                        <div class="relative">
                                            <Input :model-value="focusedImageLink" disabled/>
                                            <UseClipboard
                                                v-slot="{ copy, copied }"
                                                :source="focusedImageLink">
                                                <Button
                                                    @click.prevent="copy()"
                                                    class="absolute right-0 top-0 bottom-0 text-accent hover:text-primary"
                                                    variant="ghost">
                                                    <CheckIcon v-if="copied" class="h-5 w-5 text-green-500" />
                                                    <ClipboardIcon v-else class="h-5 w-5" />
                                                </Button>
                                            </UseClipboard>
                                        </div>
                                    </Label>

                                    <div v-if="shot.type === 'collection'" class="border mt-2 rounded-lg p-4 text-muted-foreground flex text-sm">
                                        <div>
                                            <InformationCircleIcon class="w-5 text-blue-500 dark:text-blue-600 mr-2"/>
                                        </div>
                                        If this is a collection, this direct link is relative to the currently select photo.
                                    </div>
                                </div>
                            </div>
                        </TabsContent>

                        <TabsContent value="info">
                            c
                        </TabsContent>
                    </div>
                </TabsRoot>
            </div>
        </div>
    </Layout>
</template>

