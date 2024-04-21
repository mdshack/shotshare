<script setup>
import Layout from '@/Layouts/Layout.vue'
import { Head } from '@inertiajs/vue3'
import { Carousel, Slide, Pagination, Navigation } from 'vue3-carousel'
import { ref, onMounted } from 'vue'
import { HandThumbDownIcon, HandThumbUpIcon } from "@heroicons/vue/24/outline";
import { ShareIcon, HeartIcon, EyeIcon, TrashIcon, HandThumbUpIcon as HandThumbUpIconSolid, HandThumbDownIcon as HandThumbDownIconSolid } from "@heroicons/vue/20/solid"
import {
    Popover,
    PopoverContent,
    PopoverTrigger,
} from '@/Components/ui/popover'

import AuthorSidebar from '@/Pages/Shots/Partials/AuthorSidebar.vue'
import Shot from '@/Pages/Shots/Partials/Shot.vue'

defineEmits([
    'focus'
])

const props = defineProps({
    shot: Object,
    showLinks: Object,
    author: Object,
    reaction: Object,
    reactionCounts: Object,
    childShots: Array,
    isOwner: Boolean,
    isFavorite: Boolean,
    views: Number,
})

onMounted(() => {
    let params = new URLSearchParams(window.location.search)
    const selectedShot = params.get("selected_shot_id")

    if(selectedShot) {
        const shotIndex = props.shots.findIndex(({id}) => id == selectedShot)
        shotImageCarousel.value.slideTo(shotIndex)
    }
})
</script>

<template>
  <Head title="Shot" />

  <Layout>
    <div class="space-y-8">
      <div class="grid grid-cols-12">
        <AuthorSidebar :author="author" />

        <div class="col-span-12 md:col-span-9">
          <Shot
            :shot="shot"
            :reaction="reaction"
            :reaction-counts="reactionCounts"
            :views="views"
            :is-owner="isOwner"
            :is-favorite="isFavorite"
          />

          <template v-if="author">
            <hr class="my-14">

            <h3 class="font-bold text-xl mb-4">
              More from {{ author?.display_handle }}
            </h3>

            <div class="grid grid-cols-3 gap-4">
              <img :src="shot.links.asset_url">
            </div>
          </template>
        </div>
      </div>
    </div>
  </Layout>
</template>

