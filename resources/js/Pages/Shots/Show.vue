<script setup>
import Layout from '@/Layouts/Layout.vue'
import { Head } from '@inertiajs/vue3'
import { ref, computed } from 'vue'
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

const props = defineProps({
    shot: Object,
})

const focusedImageIndex = ref(0)
const focusedImageLink = computed(() => {
    return props.shot.uploads[focusedImageIndex.value]
})
</script>

<template>
    <Head title="Shot" />

    <Layout>
        <div class="space-y-8">
            <CardShot :shot="shot" @focus-image="(i) => focusedImageIndex = i"/>

            <div class="border rounded-lg">
                <TabsRoot default-value="comments">
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
                                    <User>
                                        <template #after-handle>
                                            •
                                            <TimeAgo :datetime="shot.created_at"/>
                                        </template>
                                    </User>
                                    <div class="ml-12 mt-2">
                                        Lorem ipsum dolor sit, amet consectetur adipisicing elit. Enim deserunt, beatae voluptatum consequatur odit ut sunt nihil porro pariatur obcaecati perspiciatis accusantium et adipisci voluptates at dolore. Velit, soluta expedita?
                                    </div>
                                </div>

                                <div class="p-4">
                                    <User>
                                        <template #after-handle>
                                            •
                                            <TimeAgo :datetime="shot.created_at"/>
                                        </template>
                                    </User>
                                    <div class="ml-12 mt-2">
                                        Lorem ipsum dolor sit, amet consectetur adipisicing elit. Enim deserunt, beatae voluptatum consequatur odit ut sunt nihil porro pariatur obcaecati perspiciatis accusantium et adipisci voluptates at dolore. Velit, soluta expedita?
                                    </div>
                                </div>

                            </div>

                            <div class="p-4">
                                <div class="relative">
                                    <Input placeholder="Add your comment" class="peer"/>
                                    <kbd
                                        class="transition opacity-0 peer-focus:opacity-100 inline-flex absolute top-0 bottom-0 right-0 my-auto mr-2 pointer-events-none h-5 select-none items-center gap-1 rounded border bg-muted px-1.5 font-mono text-[10px] font-medium text-muted-foreground">
                                        enter to post
                                    </kbd>
                                </div>
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

                                    <div class="border mt-2 rounded-lg p-4 text-muted-foreground flex text-sm">
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

