<script setup>
import { Input } from '@/Components/ui/input'

import { router } from '@inertiajs/vue3'
import { ref } from 'vue'

const props = defineProps({
    shot: Object
})

const emit = defineEmits([
    "on-success"
])

const commentContents = ref("")
const submitComment = () => {
    router.post(route("shots.comments.store", props.shot.id), {contents: commentContents.value}, {
        preserveScroll: true,
        preserveState: true,
        onBefore: () => {
            commentContents.value = ""
        },
        onSuccess: () => {
            emit("on-success")
        }
    })
}
</script>
<template>
    <div class="p-4">
        <div class="relative">
            <Input v-model="commentContents" placeholder="Add your comment" class="peer" @keyup.enter="submitComment"/>
            <kbd
                class="transition opacity-0 peer-focus:opacity-100 inline-flex absolute top-0 bottom-0 right-0 my-auto mr-2 pointer-events-none h-5 select-none items-center gap-1 rounded border bg-muted px-1.5 font-mono text-[10px] font-medium text-muted-foreground">
                enter to post
            </kbd>
        </div>
    </div>
</template>
