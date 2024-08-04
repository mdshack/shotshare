<script setup>
import CardShot from '@/Components/CardShot.vue';
import { Button } from '@/Components/ui/button';
import { ref, onMounted } from 'vue';
import { router } from '@inertiajs/vue3';
import { vElementVisibility } from '@vueuse/components'

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

const visible = ref([])
const onVideoVisible = (isVisible, shot) => {
    if(isVisible) {
        visible.value.push(shot.id)
    } else {
        visible.value.splice(visible.value.findIndex(id => id === shot.id), 1)
    }
}
</script>
<template>
    <div class="space-y-4">
        <CardShot
            v-for="shot in formatted"
            v-element-visibility="(e) => onVideoVisible(e, shot)"
            :shot="shot"
            :condensed="condensed"
            :visible="visible.includes(shot.id)"
        />

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
