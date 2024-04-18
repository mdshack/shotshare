<script setup>
import { Head, Link, usePage } from '@inertiajs/vue3';
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
import { computed } from 'vue';
import { UserIcon, CloudArrowUpIcon } from "@heroicons/vue/16/solid";

const user = computed(() => {
    return usePage().props?.auth?.user
})

const firstName = computed(() => {
    return user.value?.name.split(' ')[0]
})

const initials = computed(() => {
    return user.value?.name.split(' ').map(fragment => fragment[0].toUpperCase()).join('')
})
</script>

<template>
    <div class="max-w-6xl mx-auto pb-14">
        <nav class="flex justify-between items-center py-4 border-b mb-8">
            <Link :href="route('home')">
                <Button variant="ghost" class="font-semibold text-xl cursor-pointer">
                    ShotShare
                </Button>
            </Link>
            <!-- <DropdownMenu v-if="user">
                <DropdownMenuTrigger>
                    <Button variant="ghost">
                        <Avatar class="w-6 h-6 mr-2">
                            {{ initials }}
                        </Avatar>
                        {{ firstName }}
                    </Button>
                </DropdownMenuTrigger>
                <DropdownMenuContent>
                    <DropdownMenuLabel>My Account</DropdownMenuLabel>

                    <DropdownMenuSeparator />

                    <Link :href="route('profile.edit')">
                        <DropdownMenuItem class="cursor-pointer">
                            Profile
                        </DropdownMenuItem>
                    </Link>

                    <Link :href="route('shots.index')">
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

            <div v-else class="space-x-2">
                <Link :href="route('login')">
                    <Button>
                        Log In
                    </Button>
                </Link>

                <Link v-if="$page.props.auth.allow_registration" :href="route('register')">
                    <Button variant="secondary">
                        Sign Up
                    </Button>
                </Link>
            </div> -->

            <div class="space-x-4 flex items-center">
                <!-- <button type="button" class="text-white border-2 border-[#f94144] hover:bg-[#f94144] focus:ring-4 focus:outline-none focus:ring-red-300 font-medium text-sm px-4 py-2 text-center transition">
                    <div class="flex items-center">
                        <CloudArrowUpIcon class="h-5 mr-2" />
                        Upload
                    </div>
                </button> -->

                <button class="relative inline-flex items-center justify-center p-0.5 overflow-hidden text-sm font-medium text-gray-900 group bg-gradient-to-br from-purple-500 to-pink-500 group-hover:from-purple-500 group-hover:to-pink-500 hover:text-white dark:text-white focus:ring-4 focus:outline-none focus:ring-purple-200 dark:focus:ring-purple-800 transition">
                    <span class="relative px-4 py-2 transition-all ease-in duration-75 bg-[#09090b] group-hover:bg-opacity-0 flex transition">
                        <UserIcon class="w-5 mr-2"/>
                        Log In
                    </span>
                </button>
            </div>

            <!-- <Button class="bg-[#8338EC] text-white">
                Upload
            </Button> -->
        </nav>

        <main class="pb-8">
            <slot/>
        </main>

        <!-- <footer v-if="$page.props.features.footer" class="items-center justify-center space-y-2 text-center text-sm">
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
    </div>
</template>
