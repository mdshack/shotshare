<script setup>
import Layout from '@/Layouts/Layout.vue'
import { Link, Head } from '@inertiajs/vue3'
import Macy from "macy"
import { ref } from 'vue';
import { onMounted } from 'vue';
import { HandThumbUpIcon, HandThumbDownIcon, PhotoIcon } from "@heroicons/vue/24/outline"

const props = defineProps({
    shots: Array
})

const masonry = ref(null)

onMounted(() => {
    masonry.value = Macy({
        container: ".masonry",
        columns: 2,
        trueOrder: true,
        waitForImages: true,
    })
})
</script>

<template>
  <Head title="My Shots" />

  <Layout>
    <div
      v-if="shots.length < 1"
      class="text-center text-lg"
    >
      You haven't uploaded any shots!
    </div>

    <div class="masonry">
      <Link
        v-for="shot in shots"
        :key="shot.uuid"
        class="flex items-center justify-center p-1"
        :href="shot.links.url"
      >
        <div class="border rounded-lg hover:bg-accent overflow-hidden w-full relative">
          <img
            :src="shot.links.asset_url"
            class="w-full"
          >

          <div
            v-if="($page.props.features.reactions && (shot.reactions?.upvote || shot.reactions?.downvote)) || shot.child_shots.length"
            class="absolute bottom-0 right-0 bg-black/85 border-l border-t rounded-tl-lg flex space-x-2 p-1.5"
          >
            <template v-if="$page.props.features.reactions">
              <div
                v-if="shot.reactions?.upvote"
                class="text-gray-500 text-xs text-center"
              >
                <HandThumbUpIcon class="w-5" />
                {{ shot.reactions?.upvote }}
              </div>
              <div
                v-if="shot.reactions?.downvote"
                class="text-gray-500 text-xs text-center"
              >
                <HandThumbDownIcon class="w-5" />
                {{ shot.reactions?.downvote }}
              </div>
            </template>

            <div
              v-if="shot.child_shots.length"
              class="text-gray-500 text-xs text-center"
            >
              <PhotoIcon class="w-5" />
              {{ shot.child_shots.length + 1 }}
            </div>
          </div>
        </div>
      </Link>
    </div>
  </Layout>
</template>
