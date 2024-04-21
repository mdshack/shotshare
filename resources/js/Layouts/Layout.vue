<script setup>
import { Head, Link, usePage } from '@inertiajs/vue3'
import UserAvatar from '@/Components/ui/UserAvatar.vue'
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
import { UserIcon, Cog6ToothIcon, ArrowRightStartOnRectangleIcon, StarIcon } from "@heroicons/vue/16/solid";
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
          <Button
            variant="ghost"
            class="font-semibold text-xl cursor-pointer"
          >
            ShotShare
          </Button>
        </Link>
        <div class="flex items-center divide-x">
          <TooltipProvider :delay-duration="100">
            <div class="flex items-center pr-6 space-x-4">
              <Tooltip>
                <TooltipTrigger as-child>
                  <Link
                    :href="route('home')"
                    class="flex items-center transition"
                    :class="!activeNavigation || activeNavigation === 'discover' ? 'text-white' : 'text-gray-400'"
                    @mouseenter="activeNavigation = 'discover'"
                    @mouseleave="activeNavigation = null"
                  >
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
                    @mouseleave="activeNavigation = null"
                  >
                    <CloudArrowUpIcon class="h-6 w-6" />
                  </Link>
                </TooltipTrigger>
                <TooltipContent side="bottom">
                  Upload
                </TooltipContent>
              </Tooltip>
            </div>

            <div class="flex items-center pl-6 space-x-4">
              <DropdownMenu v-if="user">
                <DropdownMenuTrigger>
                  <button>
                    <UserAvatar
                      class="w-7 h-7"
                      :user="user"
                    />
                  </button>
                </DropdownMenuTrigger>
                <DropdownMenuContent
                  side="bottom"
                  align="end"
                  class="min-w-[170px]"
                >
                  <div class="flex items-center p-1">
                    <UserAvatar
                      class="mr-2"
                      :user="user"
                    />
                    <div>
                      <h3 class="font-bold ">
                        {{ user.name }}
                      </h3>
                      <p class="text-sm">
                        {{ user.display_handle }}
                      </p>
                    </div>
                  </div>

                  <DropdownMenuSeparator />

                  <Link :href="route('profile.edit')">
                    <DropdownMenuItem class="cursor-pointer">
                      <UserIcon class="h-6 w-6 text-gray-500 mr-2" />
                      My Profile
                    </DropdownMenuItem>
                  </Link>

                  <Link :href="route('profile.edit')">
                    <DropdownMenuItem class="cursor-pointer">
                      <Cog6ToothIcon class="h-6 w-6 text-gray-500 mr-2" />
                      Settings
                    </DropdownMenuItem>
                  </Link>

                  <DropdownMenuSeparator />

                  <a
                    href="https://github.com/mdshack/shotshare"
                    target="_blank"
                    rel="noopener"
                  >
                    <DropdownMenuItem class="cursor-pointer">
                      <StarIcon class="h-6 w-6 text-gray-500 mr-2" />
                      Star on GitHub
                    </DropdownMenuItem>
                  </a>

                  <DropdownMenuSeparator />

                  <Link
                    :href="route('logout')"
                    method="post"
                    as="button"
                    class="w-full"
                  >
                    <DropdownMenuItem class="cursor-pointer">
                      <ArrowRightStartOnRectangleIcon class="h-6 w-6 text-gray-500 mr-2" />
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
                @mouseleave="activeNavigation = null"
              >
                <ArrowLeftEndOnRectangleIcon class="h-6 w-6 mr-2" />
                Log In
              </Link>
            </div>
          </TooltipProvider>
        </div>
      </nav>
    </div>

    <main class="max-w-6xl mx-auto px-4">
      <slot />
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
