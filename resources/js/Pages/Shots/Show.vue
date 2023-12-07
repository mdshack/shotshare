<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Input } from '@/Components/ui/input'

defineProps({
    shot: Object
})
</script>

<template>
    <AuthenticatedLayout>
        <div class="space-y-4">
            <div class="flex justify-center bg-muted p-4 rounded-lg">
                <img :src="shot.url"/>
            </div>

            <Input/>

            <Input/>

            <Input/>

        </div>
    </AuthenticatedLayout>
</template>
