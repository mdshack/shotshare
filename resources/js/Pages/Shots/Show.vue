<script setup>
import Layout from '@/Layouts/Layout.vue'
import { Head } from '@inertiajs/vue3'
import { ref } from 'vue'
import ShotImage from '@/Pages/Shots/Partials/ShotImage.vue'
import ShotDetails from '@/Pages/Shots/Partials/ShotDetails.vue'
import ShotLinks from '@/Pages/Shots/Partials/ShotLinks.vue'
import { ChatBubbleLeftRightIcon, EllipsisHorizontalIcon, HandThumbUpIcon } from '@heroicons/vue/24/outline';
import { Button } from '@/Components/ui/button'
import UserAvatar from '@/Components/ui/UserAvatar.vue'
import TimeAgo from '@/Components/ui/TimeAgo.vue'

import { TabsContent, TabsIndicator, TabsList, TabsRoot, TabsTrigger } from 'radix-vue'


import CardShot from '@/Components/CardShot.vue'

const props = defineProps({
    shot: Object,
    // author: Object,
    // showLinks: Object,
    // reaction: Object,
    // reactionCounts: Object,
    // childShots: Array,
    // isOwner: Boolean,
})

// let shots = [
//     props.shot,
//     ...props.childShots
// ]

// const selectedIndex = ref(0)
</script>

<template>
    <Head title="Shot" />

    <Layout>
        <div class="space-y-8">
            <CardShot :shot="shot"/>

            <div class="border rounded-lg">
                <TabsRoot>
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

                    <div class="p-4">
                        <TabsContent value="comments">
    a
                        </TabsContent>

                        <TabsContent value="share">
    b
                        </TabsContent>

                        <TabsContent value="info">
    c
                        </TabsContent>
                    </div>
                </TabsRoot>

                <!-- <div class="flex">

                </div>
                <div class="p-4 text-muted-foreground">
                    No comments
                </div> -->
            </div>

            <!-- <ShotImage
                :shots="shots"
                @focus="(index) =>  selectedIndex = index">
            </ShotImage>

            <ShotDetails
                :shot="shot"
                :author="author"
                :is-owner="isOwner"
                :reaction="reaction"
                :reaction-counts="reactionCounts">
            </ShotDetails>

            <ShotLinks
                :shots="shots"
                :selected-index="selectedIndex"
                :show-links="showLinks">
            </ShotLinks> -->
        </div>
    </Layout>
</template>

