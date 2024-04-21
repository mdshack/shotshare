<script setup>
import UserAvatar from '@/Components/ui/UserAvatar.vue'

defineProps({
    author: {
        type: Object,
    }
})
</script>

<template>
    <div class="col-span-12 md:col-span-3 md:pb-0 pb-8 pr-8">
        <div class="flex items-center">
            <UserAvatar class="text-lg mr-2" :user="author"/>
            <div>
                <h5 class="font-semibold">{{ author?.name ?? "Anonymous" }}</h5>
                <span class="text-red-600 font-semibold text-sm">{{ author?.display_handle }}</span>
            </div>
        </div>
        <p v-if="author?.bio" class="mt-4 text-gray-400">
            {{ author?.bio }}
        </p>
    </div>
</template>
