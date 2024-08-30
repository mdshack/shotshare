<script setup>
import { Dialog, DialogContent, DialogDescription, DialogFooter, DialogHeader, DialogTitle } from '@/Components/ui/dialog';
import { Checkbox } from '@/Components/ui/checkbox';
import { RadioGroupIndicator, RadioGroupItem, RadioGroupRoot } from 'radix-vue'
import { ScrollArea } from '@/Components/ui/scroll-area';
import { PlusCircleIcon } from '@heroicons/vue/24/outline';
import { computed, onMounted } from 'vue';
import { Input } from '@/Components/ui/input'
import { Button } from '@/Components/ui/button'
import { router, useForm } from '@inertiajs/vue3';

const props = defineProps({
    shot: Object
})

const emit = defineEmits(["close"])

const form = useForm({
    name: "",
    require_logged_in: false,
    anonymize: false,
})

onMounted(() => {
    form.name = props.shot.name
    form.require_logged_in = props.shot.require_logged_in
    form.anonymize = props.shot.anonymize
})

const submitUpload = () => {
    form.patch(route("shots.update", props.shot.id), {
        onFinish: () => {
            router.reload()
            emit("close")
        }
    })
}
</script>

<template>
    <Dialog :open="true" @update:open="emit('close')">
        <DialogContent>
            <DialogHeader>
                <DialogTitle>Update a Shot</DialogTitle>
            </DialogHeader>

            <div class="space-y-2">
                <Label>Title</Label>
                <Input v-model="form.name" />
            </div>

            <div class="space-y-2">
                <Label>Settings</Label>
                <div class="flex items-center space-x-2">
                    <Checkbox v-model:checked="form.require_logged_in" id="require_logged_in" />
                    <label for="require_logged_in"
                        class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">
                        Require viewers to be logged in
                    </label>
                </div>

                <div class="flex items-center space-x-2">
                    <Checkbox v-model:checked="form.anonymize" id="anonymize" />
                    <label for="anonymize"
                        class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">
                        Anonymize "posted by" details
                    </label>
                </div>
            </div>

            <DialogFooter>
                <Button variant="outline" @click="emit('close')">Cancel</Button>
                <Button @click.prevent="submitUpload">Update Image</Button>
            </DialogFooter>
        </DialogContent>
    </Dialog>
</template>
