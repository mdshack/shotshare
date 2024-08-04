<script setup>
import TimeAgo from '@/Components/ui/TimeAgo.vue'
import User from '@/Components/User.vue'

defineProps({
    comment: Object
})
</script>
<template>
    <div class="p-4">
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
</template>
