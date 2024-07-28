<script setup>
import CardShot from '@/Components/CardShot.vue';
import { Button } from '@/Components/ui/button';
import { ref, onMounted } from 'vue';
import { router } from '@inertiajs/vue3';

const props = defineProps({
    shots: Object,
    condensed: {
        type: Boolean,
        default: false,
    }
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
</script>
<template>
    <div class="space-y-4">
        <CardShot v-for="shot in formatted" :shot="shot" :condensed="condensed"/>

        <div v-if="!formatted?.length" class="flex items-center justify-center text-xl text-muted-foreground">
            Nothing to see here
        </div>

        <div class="flex justify-center">
            <Button
                v-if="shots?.next_cursor"
                variant="outline"
                @click.prevent="loadMore">
                Load More
            </Button>
        </div>
    </div>
</template>
