<script setup>
import Comment from '@/Components/Comment.vue'
import InputComment from '@/Components/InputComment.vue'
import CursorPaginatedResource from '@/Components/CursorPaginatedResource.vue';
import MustBeAuthenticatedDialog from '@/Components/MustBeAuthenticatedDialog.vue';

const props = defineProps({
    shot: Object
})
</script>

<template>
    <CursorPaginatedResource paginated-route="shots.comments.index" :params="{shotId: shot.id}">
        <template #before="{load}">
            <MustBeAuthenticatedDialog>
                <InputComment :shot="shot" @on-success="load(null)"/>
            </MustBeAuthenticatedDialog>
        </template>

        <template #item="{item}">
            <Comment :comment="item"/>
        </template>
    </CursorPaginatedResource>
</template>
