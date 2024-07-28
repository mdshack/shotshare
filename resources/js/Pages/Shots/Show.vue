<script setup>
import Layout from '@/Layouts/Layout.vue'
import { Head, router, usePage } from '@inertiajs/vue3'
import { ref, computed, onMounted } from 'vue'
import { CheckIcon, ClipboardIcon, InformationCircleIcon } from '@heroicons/vue/24/outline';
import { Button } from '@/Components/ui/button'
import Comment from '@/Components/Comment.vue'

import { TabsContent, TabsList, TabsRoot, TabsTrigger } from 'radix-vue'

import InputComment from '@/Components/InputComment.vue'
import CardShot from '@/Components/CardShot.vue'
import { Input } from '@/Components/ui/input'
import { Label } from '@/Components/ui/label'
import { UseClipboard } from '@vueuse/components'
import Spinner from '@/Components/ui/Spinner.vue'
import CursorPaginatedResource from '@/Components/CursorPaginatedResource.vue';
import ShotComments from '@/Components/ShotComments.vue';

const page = usePage()

const props = defineProps({
    shot: Object,
    tab: String,

    reactions: Object,
    comments: Object,
})

const focusedImageIndex = ref(0)
const focusedImage = computed(() => {
    return props.shot.uploads[focusedImageIndex.value]
})

const commentsLoading = ref(true)
const formattedComments = ref([])
const loadComments = (extra = {}) => {
    if(!page.props.features.comments) {
        commentsLoading.value = false

        return
    }

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

    router.reload({ only: [
        'reactions',
    ]})
})

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

        {{ reactions }}
        <div class="space-y-8">
            <CardShot :shot="shot" @focus-image="(i) => focusedImageIndex = i"/>

            <div class="border rounded-lg">
                <TabsRoot :default-value="tab ?? page.props.features.comments ? 'comments' : 'share'">
                    <TabsList>
                        <TabsTrigger v-if="$page.props.features.comments" as-child value="comments">
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
                        <TabsContent value="comments" v-if="$page.props.features.comments">
                            <div class="divide-y">
                                <ShotComments :shot="shot"/>
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
                                            <Input :model-value="focusedImage.url" disabled/>
                                            <UseClipboard
                                                v-slot="{ copy, copied }"
                                                :source="focusedImage.url">
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

                        <TabsContent value="info" class="p-4 space-y-4">
                            <div class="grid grid-cols-7 grid sm:gap-4">
                                <div class="sm:text-right col-span-7 sm:col-span-2 text-muted-foreground">
                                    Resolution
                                </div>
                                <div class="col-span-7 sm:col-span-5 font-semibold">
                                    {{focusedImage.resolution}}
                                </div>
                            </div>

                            <div class="grid grid-cols-7 grid sm:gap-4">
                                <div class="sm:text-right col-span-7 sm:col-span-2 text-muted-foreground">
                                    Size
                                </div>
                                <div class="col-span-7 sm:col-span-5 font-semibold">
                                    {{focusedImage.size}}
                                </div>
                            </div>

                            <div class="grid grid-cols-7 grid sm:gap-4">
                                <div class="sm:text-right col-span-7 sm:col-span-2 text-muted-foreground">
                                    Format
                                </div>
                                <div class="col-span-7 sm:col-span-5 font-semibold">
                                    {{focusedImage.format}}
                                </div>
                            </div>
                        </TabsContent>
                    </div>
                </TabsRoot>
            </div>
        </div>
    </Layout>
</template>

