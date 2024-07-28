<script setup>
import Comment from '@/Components/Comment.vue'
import InputComment from '@/Components/InputComment.vue'
import CursorPaginatedResource from '@/Components/CursorPaginatedResource.vue';

const props = defineProps({
    shot: Object
})
</script>

<template>
    <CursorPaginatedResource paginated-route="shots.comments.index" :params="{shotId: shot.id}">
        <template #before="{load}">
            <InputComment :shot="shot" @on-success="load(null)"/>
        </template>

        <template #item="{item}">
            <Comment :comment="item"/>
        </template>
    </CursorPaginatedResource>
</template>
