<script setup>
import { computed } from 'vue'
import { Avatar, AvatarFallback, AvatarImage } from '@/Components/ui/avatar'

const props = defineProps({
    src: String,
    user: Object,
})

const initials = computed(() => {
    return props.user?.name?.split(' ').map(fragment => fragment[0].toUpperCase()).join('') ?? "A"
})
</script>

<template>
  <Avatar class="mr-2">
    <AvatarImage :src="user.avatar" />
    <AvatarFallback>{{ initials }}</AvatarFallback>
  </Avatar>
</template>
