<script setup>
import Layout from '@/Layouts/Layout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import { Button } from '@/Components/ui/button'
import { Head, Link, useForm } from '@inertiajs/vue3';
import { Input } from '@/Components/ui/input'
import { AtSymbolIcon } from "@heroicons/vue/24/solid";

const form = useForm({
    name: '',
    handle: '',
    email: '',
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <Layout>
        <Head title="Register" />

        <div class="max-w-lg mx-auto">
            <div class="flex flex-col space-y-2 text-center mb-8">
                <h1 class="text-2xl font-semibold tracking-tight">
                    Register
                </h1>
                <div class="mb-4 text-sm text-gray-600 dark:text-gray-400">
                    Already have an account? <Link :href="route('login')"><Button variant="link" class="p-0">Sign In</Button></Link>
                </div>
            </div>

            <form @submit.prevent="submit" class="space-y-4">
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
                    <InputLabel for="email" value="Email" />

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

                <div>
                    <InputLabel for="password" value="Password" />

                    <Input
                        id="password"
                        type="password"
                        class="mt-1 block w-full"
                        v-model="form.password"
                        required
                        autocomplete="new-password"
                    />

                    <InputError class="mt-2" :message="form.errors.password" />
                </div>

                <div>
                    <InputLabel for="password_confirmation" value="Confirm Password" />

                    <Input
                        id="password_confirmation"
                        type="password"
                        class="mt-1 block w-full"
                        v-model="form.password_confirmation"
                        required
                        autocomplete="new-password"
                    />

                    <InputError class="mt-2" :message="form.errors.password_confirmation" />
                </div>

                <div class="flex items-center justify-end mt-4">
                    <Button class="ms-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                        Register
                    </Button>
                </div>
            </form>
        </div>
    </Layout>
</template>
