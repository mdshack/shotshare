<script setup>
import UserAvatar from '@/Components/ui/UserAvatar.vue'
import { Link } from '@inertiajs/vue3';

defineProps({
    user: Object
})
</script>
<template>
    <div class="flex items-center">
        <UserAvatar :user="user"/>
        <div>
            <Link
                v-if="user"
                class="font-semibold hover:underline"
                :href="route('users.show', user?.handle)">
                {{ user?.name ?? "Anonymous User" }}
            </Link>
            <div
                v-else
                class="font-semibold hover:underline italic">
                Anonymous User
            </div>
            <div class="text-muted-foreground">
                <span :class="{'italic': !user?.handle}">{{ user?.handle ?? 'none' }}</span>
                <slot name="after-handle"/>
            </div>
        </div>
    </div>
</template>
