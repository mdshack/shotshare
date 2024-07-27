<script setup>
import { Button } from '@/Components/ui/button';
import User from '@/Components/User.vue';
import Layout from '@/Layouts/Layout.vue';
import { ref, onMounted } from 'vue';
import { router } from '@inertiajs/vue3';
import PaginatedShotList from '@/Components/PaginatedShotList.vue';

const props = defineProps({
    user: Object,
    shots: Object,
    isFollowing: Boolean,
})

const formatted = ref([])

onMounted(() => {
    formatted.value = [...formatted.value, ...props.shots.data]
})

const loadMore = () => {
    router.reload({
        preserveScroll: true,
        preserveState: true,
        onSuccess: () => {
            formatted.value = [...formatted.value, ...props.shots.data]
        },
        data: {
            cursor: props.shots.next_cursor
        }
    })
}

const follow = () => {
    router.post(route("users.follow", props.user.handle))
}

const unfollow = () => {
    router.delete(route("users.unfollow", props.user.handle))
}
</script>
<template>
    <Layout>
        <div class="space-y-6">
            <div class="flex items-center justify-between">
                <User :user="user"/>
                <template v-if="$page.props.features.followers && $page.props.auth.user.id != user.id">
                    <Button
                        v-if="!isFollowing"
                        @click.prevent="follow">
                        Follow
                    </Button>
                    <Button
                        v-else
                        variant="destructive"
                        @click.prevent="unfollow">
                        Unfollow
                    </Button>
                </template>
            </div>

            <h2 class="font-semibold text-2xl">Shots</h2>

            <PaginatedShotList :shots="shots"/>
        </div>
    </Layout>
</template>
