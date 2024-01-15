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
    <div class="max-w-2xl mx-auto pb-14">
        <nav class="flex justify-between items-center py-4 border-b mb-8">
            <Link :href="route('home')">
                <Button variant="ghost" class="font-semibold text-xl cursor-pointer">
                    ShotShare
                </Button>
            </Link>
            <DropdownMenu v-if="user">
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
            </div>
        </nav>

        <main class="pb-8">
            <slot/>
        </main>

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
        </footer>
    </div>
</template>
