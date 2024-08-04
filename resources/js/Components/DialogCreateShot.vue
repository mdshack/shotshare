<script setup>
import { Dialog, DialogContent, DialogDescription, DialogFooter, DialogHeader, DialogTitle } from '@/Components/ui/dialog';
import { Checkbox } from '@/Components/ui/checkbox';
import { RadioGroupIndicator, RadioGroupItem, RadioGroupRoot } from 'radix-vue'
import { ScrollArea } from '@/Components/ui/scroll-area';
import { PlusCircleIcon } from '@heroicons/vue/24/outline';
import { computed, ref } from 'vue';
import { Input } from '@/Components/ui/input'
import { Button } from '@/Components/ui/button'
import { Label } from '@/Components/ui/label'

const form = defineModel("form")

const uploadAsOptions = [
    {
        title: "Individual",
        description: "Each image will appear on its own page",
        value: "individual",
    },
    {
        title: "Collection",
        description: "All uploaded images will appear on this same page",
        value: "collection",
    },
]

const submitUpload = () => {
    form.value.post(route('upload'))
}

const previews = ref({})

const previewUrls = computed(() => {
    return [
        ...form.value.videos.map(file => {
            if (file.name in previews.value) {
                return previews.value[file.name]
            }

            const video = document.createElement("video")
            video.className = "videopreview absolute bottom-0 left-0 -z-10 invisible"
            document.body.append(video)

            let reader = new FileReader()
            reader.readAsDataURL(file)
            reader.addEventListener('load', function(){
                video.src = reader.result

                setTimeout(() => {
                    const canvas = document.createElement("canvas")

                    canvas.width = video.videoWidth
                    canvas.height = video.videoHeight

                    let ctx = canvas.getContext('2d')

                    ctx.drawImage(video, 0, 0, video.videoWidth, video.videoHeight)

                    previews.value[file.name] = canvas.toDataURL('image/jpeg')
                }, 150);
            })

            return file.name in previews.value
                ? previews.value[file.name]
                : null
        }),
        ...form.value.images.map(file => URL.createObjectURL(file)),
    ]
})
</script>

<template>
    <Dialog>
        <DialogContent>
            <DialogHeader>
                <DialogTitle>Upload a Shot</DialogTitle>
                <DialogDescription>Share your shot with your friends.</DialogDescription>
            </DialogHeader>

            <div class="space-y-2">
                <Label>Title</Label>
                <Input v-model="form.name" />
            </div>

            <ScrollArea class="max-h-[300px]">
                <div class="space-y-2">
                    <Label>Media</Label>
                    <div class="grid grid-cols-3 gap-4">
                        <div v-for="preview in previewUrls" class="aspect-square border rounded-lg overflow-hidden">
                            <img v-if="preview" :src="preview" class="object-cover object-center w-full h-full" />
                        </div>
                        <label for="dropzone-file"
                            class="cursor-pointer hover:border-primary hover:text-primary text-muted-foreground border border-dashed rounded-lg">
                            <div
                                class="aspect-square flex flex-col justify-center items-center transition pointer-events-none text-xs">
                                <PlusCircleIcon class="w-10 mb-2" />
                                Add Media
                            </div>
                        </label>
                    </div>
                </div>
            </ScrollArea>

            <div v-if="form.images.length > 1 || form.videos.length > 1" class="space-y-2">
                <Label>Upload As</Label>
                <RadioGroupRoot
                    v-model="form.type"
                    class="flex flex-col gap-2"
                    default-value="individual"
                    aria-label="View density">
                    <label
                        v-for="{title, description, value} in uploadAsOptions"
                        class="flex items-center space-x-2 border p-4 rounded-lg" :for="value">
                        <RadioGroupItem
                            :id="value"
                            class="w-5 h-5 border border-primary rounded-full overflow-hidden p-0.5"
                            :value="value">
                            <RadioGroupIndicator class="w-5 h-5 bg-primary w-full h-full flex rounded-full" />
                        </RadioGroupItem>
                        <div>
                            <div class="text-sm tracking-tight font-medium text-foreground">{{title}}</div>
                            <p class="text-muted-foreground text-sm">{{description}}</p>
                        </div>
                    </label>
                </RadioGroupRoot>
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
                <Button variant="outline" @click="fileUploadModalOpen = false">Cancel</Button>
                <Button @click.prevent="submitUpload">Upload Image</Button>
            </DialogFooter>
        </DialogContent>
    </Dialog>
</template>
