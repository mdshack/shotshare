<script setup>
import UserAvatar from '@/Components/ui/UserAvatar.vue'

defineProps({
    user: Object
})
</script>
<template>
    <div class="flex items-center">
        <UserAvatar :user="user"/>
        <div>
            <h5 class="font-semibold" :class="{'italic': !user?.name}">{{ user?.name ?? "Anonymous User" }}</h5>
            <div class="text-muted-foreground">
                <span :class="{'italic': !user?.handle}">{{ user?.handle ?? 'none' }}</span>
                <slot name="after-handle"/>
            </div>
        </div>
    </div>
</template>
