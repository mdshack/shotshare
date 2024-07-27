<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import { Button } from '@/Components/ui/button'
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { Input } from '@/Components/ui/input'
import { Checkbox } from '@/Components/ui/checkbox'

defineProps({
    canResetPassword: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>
<template>
    <GuestLayout>
        <Head title="Log in" />

        <div class="max-w-lg w-full mx-auto mt-8 border p-4 rounded-xl">
            <div class="flex flex-col space-y-2 text-center mb-8">
                <h1 class="text-2xl font-semibold tracking-tight">
                    Log In
                </h1>

                <div class="mb-4 text-sm text-gray-600 dark:text-gray-400">
                    Don't have an account yet?
                    <Link :href="route('register')">
                    <Button variant="link" class="p-0">
                        Sign Up
                    </Button>
                    </Link>
                </div>
            </div>

            <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
                {{ status }}
            </div>

            <form @submit.prevent="submit">
                <div>
                    <InputLabel for="email" value="Email" />

                    <Input id="email" type="email" class="mt-1 block w-full" v-model="form.email" required autofocus
                        autocomplete="username" />

                    <InputError class="mt-2" :message="form.errors.email" />
                </div>

                <div class="mt-4">
                    <InputLabel for="password" value="Password" />

                    <Input id="password" type="password" class="mt-1 block w-full" v-model="form.password" required
                        autocomplete="current-password" />

                    <InputError class="mt-2" :message="form.errors.password" />
                </div>

                <div class="block mt-4">
                    <label class="flex items-center">
                        <Checkbox name="remember" v-model:checked="form.remember" />
                        <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">Remember me</span>
                    </label>
                </div>

                <div class="flex items-center justify-end mt-4">
                    <Link v-if="canResetPassword" :href="route('password.request')"
                        class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                    Forgot your password?
                    </Link>

                    <Button class="ms-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                        Log in
                    </Button>
                </div>
            </form>
        </div>
    </GuestLayout>
</template>
