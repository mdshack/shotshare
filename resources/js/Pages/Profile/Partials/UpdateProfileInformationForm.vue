<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import { Button } from '@/Components/ui/button'
import { Link, useForm, usePage } from '@inertiajs/vue3';
import { Input } from '@/Components/ui/input'
import { Textarea } from '@/Components/ui/textarea'
import {
    Tooltip,
    TooltipContent,
    TooltipProvider,
    TooltipTrigger
} from '@/Components/ui/tooltip'
import { InformationCircleIcon, AtSymbolIcon } from "@heroicons/vue/24/solid";

defineProps({
    mustVerifyEmail: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const user = usePage().props.auth.user;

const form = useForm({
    name: user.name,
    handle: user.handle,
    email: user.email,
    bio: user.bio,
});
</script>

<template>
    <section>
        <form @submit.prevent="form.patch(route('profile.update'))" class="mt-6 space-y-6">
            <div>
                <InputLabel for="name" value="Name" />

                <Input
                    id="name"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.name"
                    required
                    autofocus
                    autocomplete="name"
                />

                <InputError class="mt-2" :message="form.errors.name" />
            </div>

            <div>
                <InputLabel for="handle" value="Handle" />

                <div class="relative">
                    <Input
                        id="handle"
                        type="text"
                        class="mt-1 block w-full pl-10"
                        v-model="form.handle"
                        required
                        autocomplete="handle"
                    />
                    <span class="absolute start-0 inset-y-0 flex items-center justify-center px-2">
                        <AtSymbolIcon class="size-6 text-muted-foreground"/>
                    </span>
                </div>

                <InputError class="mt-2" :message="form.errors.handle" />
            </div>

            <div>
                <div class="flex items-center">
                    <InputLabel for="email" value="Email" />
                    <TooltipProvider>
                        <Tooltip>
                            <TooltipTrigger :as-child="true">
                                <InformationCircleIcon class="h-5 w-5 text-gray-500 ml-2" />
                            </TooltipTrigger>
                            <TooltipContent>
                                Your email will not be shared with anyone
                            </TooltipContent>
                        </Tooltip>
                    </TooltipProvider>
                </div>

                <Input
                    id="email"
                    type="email"
                    class="mt-1 block w-full"
                    v-model="form.email"
                    required
                    autocomplete="username"
                />

                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div v-if="mustVerifyEmail && user.email_verified_at === null">
                <p class="text-sm mt-2 text-gray-800 dark:text-gray-200">
                    Your email address is unverified.
                    <Link
                        :href="route('verification.send')"
                        method="post"
                        as="button"
                        class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
                    >
                        Click here to re-send the verification email.
                    </Link>
                </p>

                <div
                    v-show="status === 'verification-link-sent'"
                    class="mt-2 font-medium text-sm text-green-600 dark:text-green-400"
                >
                    A new verification link has been sent to your email address.
                </div>
            </div>

            <div>
                <InputLabel for="bio" value="Bio" />

                <div class="relative">
                    <Textarea
                        id="bio"
                        type="bio"
                        class="mt-1 block w-full"
                        v-model="form.bio"
                    />
                    <p class="absolute right-0 bottom-0 mr-2 mb-1 text-sm text-gray-500">{{form.bio?.length ?? 0}} / 500</p>
                </div>

                <InputError class="mt-2" :message="form.errors.bio" />
            </div>

            <div class="flex items-center gap-4">
                <Button :disabled="form.processing">Save</Button>

                <Transition
                    enter-active-class="transition ease-in-out"
                    enter-from-class="opacity-0"
                    leave-active-class="transition ease-in-out"
                    leave-to-class="opacity-0"
                >
                    <p v-if="form.recentlySuccessful" class="text-sm text-gray-600 dark:text-gray-400">Saved.</p>
                </Transition>
            </div>
        </form>
    </section>
</template>
