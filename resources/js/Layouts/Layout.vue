0
<script setup>
import { Head, Link, useForm, usePage } from '@inertiajs/vue3';
import { Avatar } from '@/Components/ui/avatar'
import { Button } from '@/Components/ui/button'
import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuItem,
    DropdownMenuLabel,
    DropdownMenuSeparator,
    DropdownMenuTrigger,
} from '@/Components/ui/dropdown-menu'
import { computed, ref, watch } from 'vue';
import { Aperture, Scan, Search } from 'lucide-vue-next';
import { Input } from '@/Components/ui/input'
import { useFocus } from '@vueuse/core'
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import UserAvatar from '@/Components/ui/UserAvatar.vue';
import { ArrowRightEndOnRectangleIcon, PhotoIcon, PlusCircleIcon } from '@heroicons/vue/24/outline';
import { Dialog, DialogContent, DialogDescription, DialogFooter, DialogHeader, DialogTitle } from '@/Components/ui/dialog';
import { Label } from '@/Components/ui/label'
import { Checkbox } from '@/Components/ui/checkbox';
// import { RadioGroup, RadioGroupItem } from '@/Components/ui/radio-group'
import { RadioGroupIndicator, RadioGroupItem, RadioGroupRoot } from 'radix-vue'

const page = usePage()

const searchTerm = ref("")
const search = ref(null)
const { focused: searchFocused } = page.props.features.search
    ? useFocus(search)
    : false


const user = computed(() => {
    return page.props?.auth?.user
})

const routes = computed(() => ([
    {
        name: "Home",
        href: route("feed"),
        active: route().current("feed"),
        feature: 'home',
    },
    {
        name: "Feed",
        href: route("feed"),
        active: route().current("feed"),
        feature: 'feed',
    },
    {
        name: "Explore",
        href: route("explore"),
        active: route().current("explore"),
        feature: 'explore',
    },
]).filter(({feature}) => page.props.features[feature]))

const fileInput = ref(null)

const hoveringGlobalDropzone = ref(false)

const form = useForm({
    name: "",
    images: [],
    type: 'individual',
    require_logged_in: false,
    anonymize: false,
})

const clearForm = () => {
    form.name = ""
    form.images = []
    form.type = 'individual'
    form.require_logged_in = false
    form.anonymize = false
}

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

// const fileUploadModalOpen = ref(false)
const fileUploadModalOpen = ref(false)

watch(fileUploadModalOpen, (open) => {
    if(!open) {
        clearForm()
    }
})

const handleFileUpload = (event) => {
    form.images = [
        ...form.images,
        ...(event?.dataTransfer?.files ?? []),
        ...(event?.target?.files ?? []),
    ]

    hoveringGlobalDropzone.value = false

    if(form.images.length) {
        fileUploadModalOpen.value = true
    }
}

const submitUpload = () => {
    form.post(route('upload'), {
        onFinish: () => {
            fileUploadModalOpen.value = false
            clearForm()
        }
    })
}

const previewUrls = computed(() => {
    return form.images.map((file) => URL.createObjectURL(file))
})

</script>

<template>
    <div @dragover.prevent="hoveringGlobalDropzone = true" class="max-w-2xl mx-auto pb-14 relative">
        <nav class="flex justify-between items-center p-4 mb-4 space-x-8 relative">
            <Link :href="route('feed')">
                <div class="flex items-center tracking-widest">
                    <ApplicationLogo />
                    <div
                        v-if="!$page.props.features.feed
                            && !$page.props.features.explore
                            && !$page.props.features.search"
                        class="text-2xl ml-2 font-semibold">
                        ShotShare
                    </div>
                </div>

            </Link>

            <template v-if="user">
                <div v-if="routes.length > 1" class="space-x-4 text-sm grow nowrap">
                    <Link
                        v-for="{ name, href, active } in routes"
                        :href="href"
                        :class="['transition', active ? 'font-semibold' : 'text-muted-foreground hover:text-primary']">
                        {{ name }}
                    </Link>
                </div>

                <div
                    v-if="$page.props.features.search"
                    class="hidden sm:inline-block relative w-full items-center max-w-xs has-[:focus]:max-w-screen-2xl has-[:focus]:absolute has-[:focus]:right-0 has-[:focus]:!ml-0 has-[:focus]:left-0 has-[:focus]:right-0 has-[:focus] animate">
                    <Input v-model="searchTerm" ref="search" type="text" placeholder="Search..."
                        class="pl-10 border-none bg-muted" />
                    <span class="absolute start-0 inset-y-0 flex items-center justify-center px-2">
                        <Search class="size-6 text-muted-foreground" />
                    </span>
                </div>

                <DropdownMenu v-if="user">
                    <DropdownMenuTrigger>
                        <UserAvatar :user="user" class="mr-0" />
                    </DropdownMenuTrigger>
                    <DropdownMenuContent align="end">
                        <DropdownMenuLabel>My Account</DropdownMenuLabel>

                        <DropdownMenuSeparator />

                        <Link :href="route('profile.edit')">
                            <DropdownMenuItem class="cursor-pointer">
                                Profile
                            </DropdownMenuItem>
                        </Link>

                        <Link :href="route('users.show', $page.props.auth.user.handle)">
                            <DropdownMenuItem class="cursor-pointer">
                                Shots
                            </DropdownMenuItem>
                        </Link>

                        <DropdownMenuSeparator />

                        <Link :href="route('logout')" method="post" as="button" class="w-full">
                            <DropdownMenuItem class="cursor-pointer">
                                Sign Out
                            </DropdownMenuItem>
                        </Link>
                    </DropdownMenuContent>
                </DropdownMenu>
            </template>
            <div v-else>
                <Link :href="route('login')" as-child>
                    <button class="flex items-center text-muted-foreground hover:text-primary transition">
                        Log In
                        <ArrowRightEndOnRectangleIcon class="ml-2 w-5"/>
                    </button>
                </Link>
            </div>
        </nav>

        <Transition>
            <div v-if="$page.props.features.search && searchFocused" class="absolute w-full border -mt-5 rounded-lg py-4 bg-muted">
                <h5 class="px-4 font-semibold mb-4">Search results</h5>
                <template v-if="searchTerm">
                    <button class="w-full text-left py-2 px-4 hover:bg-background/25">"{{ searchTerm }}" in
                        Images</button>
                    <button class="w-full text-left py-2 px-4 hover:bg-background/25">"{{ searchTerm }}" in
                        Collections</button>
                    <button class="w-full text-left py-2 px-4 hover:bg-background/25">"{{ searchTerm }}" in Tags</button>
                </template>
                <div v-else class="w-full flex justify-center text-sm text-muted-foreground">Enter something to begin
                    searching
                </div>
            </div>
        </Transition>

        <main class="pb-8 px-4">
            <slot :file-input="fileInput" />
        </main>

        <!--
        <footer v-if="$page.props.features.footer" class="items-center justify-center space-y-2 text-center text-sm">
            <p>
                Made with ❤️ by
                <a
                    target="_blank"
                    href="https://github.com/mdshack"
                    class="text-blue-300 hover:text-blue-500 hover:underline">@mdshack</a>
            </p>

            <p>
                Check out the <a
                    target="_blank"
                    href="https://github.com/mdshack/shotshare"
                    class="text-blue-300 hover:text-blue-500 hover:underline">source code</a>
            </p>
        </footer> -->

        <label v-show="hoveringGlobalDropzone" for="dropzone-file"
            class="fixed top-0 left-0 w-full h-full bg-none p-8 transition"
            :class="{ 'block bg-black/90': hoveringGlobalDropzone }"
            @dragleave.prevent.stop="hoveringGlobalDropzone = false" @drop.prevent="handleFileUpload">
            <div
                class="border-4 border-dashed border-primary rounded-lg h-full w-full flex flex-col items-center justify-center space-y-2 pointer-events-none">
                <div class="border border-primary text-primary rounded-full p-2">
                    <PhotoIcon class="w-10" />
                </div>

                <div class="text-center">
                    <h5 class="text-muted-foreground font-semibold text-primary">Drop your images here to upload</h5>
                </div>
            </div>
            <input ref="fileInput" id="dropzone-file" type="file" class="hidden" @change="handleFileUpload" accept="image/png, image/gif, image/jpeg" />
        </label>

        <Dialog v-model:open="fileUploadModalOpen">
            <DialogContent>
                <DialogHeader>
                    <DialogTitle>Upload a Shot</DialogTitle>
                    <DialogDescription>Share your shot with your friends.</DialogDescription>
                </DialogHeader>

                <div class="space-y-2">
                    <Label>Title</Label>
                    <Input v-model="form.name" />
                </div>

                <div class="space-y-2">
                    <Label>Image(s)</Label>
                    <div class="grid grid-cols-3 gap-4">
                        <div v-for="preview in previewUrls" class="aspect-square border rounded-lg overflow-hidden">
                            <img :src="preview" class="object-cover object-center w-full h-full" />
                        </div>
                        <label for="dropzone-file"
                            class="cursor-pointer hover:border-primary hover:text-primary text-muted-foreground border border-dashed rounded-lg">
                            <div
                                class="aspect-square flex flex-col justify-center items-center transition pointer-events-none text-xs">
                                <PlusCircleIcon class="w-10 mb-2" />
                                Add Image
                            </div>
                        </label>
                    </div>
                </div>

                <div class="space-y-2">
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
    </div>
</template>
