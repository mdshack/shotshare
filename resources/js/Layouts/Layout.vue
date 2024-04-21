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
import { computed, ref } from 'vue';
import { UserIcon } from "@heroicons/vue/16/solid";
import { ArrowLeftEndOnRectangleIcon, CloudArrowUpIcon, MagnifyingGlassIcon } from "@heroicons/vue/24/outline";
import { Separator } from '@/Components/ui/separator'
import {
    Tooltip,
    TooltipContent,
    TooltipProvider,
    TooltipTrigger,
} from '@/Components/ui/tooltip'

const activeNavigation = ref(null)

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
    <div class="mx-auto pb-14">
        <div class=" border-b py-4 mb-8">
            <nav class="max-w-6xl px-4 mx-auto flex justify-between items-center">
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

                <div class="flex items-center divide-x">
                    <!-- <button type="button" class="text-white border-2 border-[#f94144] hover:bg-[#f94144] focus:ring-4 focus:outline-none focus:ring-red-300 font-medium text-sm px-4 py-2 text-center transition">
                        <div class="flex items-center">
                            <CloudArrowUpIcon class="h-5 mr-2" />
                            Upload
                        </div>
                    </button> -->
                    <TooltipProvider :delay-duration="100">
                        <div class="flex items-center pr-6 space-x-4">
                            <Tooltip>
                                <TooltipTrigger as-child>
                                    <Link
                                        :href="route('home')"
                                        class="flex items-center transition"
                                        :class="!activeNavigation || activeNavigation === 'discover' ? 'text-white' : 'text-gray-400'"
                                        @mouseenter="activeNavigation = 'discover'"
                                        @mouseleave="activeNavigation = null">
                                        <MagnifyingGlassIcon class="h-6 w-6" />
                                    </Link>
                                </TooltipTrigger>
                                <TooltipContent side="bottom">
                                    Discover
                                </TooltipContent>
                            </Tooltip>

                            <Tooltip>
                                <TooltipTrigger as-child>
                                    <Link
                                        :href="route('home')"
                                        class="flex items-center transition"
                                        :class="!activeNavigation || activeNavigation === 'upload' ? 'text-white' : 'text-gray-400'"
                                        @mouseenter="activeNavigation = 'upload'"
                                        @mouseleave="activeNavigation = null">
                                        <CloudArrowUpIcon class="h-6 w-6" />
                                    </Link>
                                </TooltipTrigger>
                                <TooltipContent side="bottom">
                                    Upload
                                </TooltipContent>
                            </Tooltip>
                        </div>

                        <div class="flex items-center pl-6 space-x-4">
                            <DropdownMenu v-if="user" >
                                <DropdownMenuTrigger>
                                    <button>
                                        <Avatar class="w-7 h-7">
                                            {{ initials }}
                                        </Avatar>
                                    </button>
                                </DropdownMenuTrigger>
                                <DropdownMenuContent side="bottom" align="end">
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

                            <Link
                                v-else
                                :href="route('login')"
                                class="flex items-center transition"
                                :class="!activeNavigation || activeNavigation === 'login' ? 'text-white' : 'text-gray-400'"
                                @mouseenter="activeNavigation = 'login'"
                                @mouseleave="activeNavigation = null">
                                <ArrowLeftEndOnRectangleIcon class="h-6 w-6 mr-2" />
                                Log In
                            </Link>
                        </div>

                    </TooltipProvider>

                    <!-- <button class="relative inline-flex items-center justify-center p-0.5 overflow-hidden text-sm font-medium text-gray-900 group bg-gradient-to-br from-purple-500 to-pink-500 group-hover:from-purple-500 group-hover:to-pink-500 hover:text-white dark:text-white focus:ring-4 focus:outline-none focus:ring-purple-200 dark:focus:ring-purple-800 transition">
                        <span class="relative px-4 py-2 transition-all ease-in duration-75 bg-[#09090b] group-hover:bg-opacity-0 flex transition">
                            <UserIcon class="w-5 mr-2"/>
                            Log In
                        </span>
                    </button> -->
                </div>

                <!-- <Button class="bg-[#8338EC] text-white">
                    Upload
                </Button> -->
            </nav>
        </div>

        <main class="max-w-6xl mx-auto px-4">
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
