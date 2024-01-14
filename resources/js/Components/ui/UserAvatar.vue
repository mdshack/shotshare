<script setup>
import { computed } from 'vue'
import { Avatar } from '@/Components/ui/avatar'

const props = defineProps({
    user: Object,
})

const initials = computed(() => {
    return props.user?.name.split(' ').map(fragment => fragment[0].toUpperCase()).join('')
})
</script>

<template>
    <Avatar class="mr-2">
        {{ initials }}
    </Avatar>
</template>
