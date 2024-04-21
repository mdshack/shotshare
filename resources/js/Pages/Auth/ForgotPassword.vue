<script setup>
import Layout from '@/Layouts/Layout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import { Button } from '@/Components/ui/button'
import { Head, useForm } from '@inertiajs/vue3';
import { Input } from '@/Components/ui/input'

defineProps({
    status: {
        type: String,
    },
});

const form = useForm({
    email: '',
});

const submit = () => {
    form.post(route('password.email'));
};
</script>

<template>
  <Layout>
    <Head title="Forgot Password" />

    <div class="max-w-lg mx-auto">
      <div class="flex flex-col space-y-2 text-center mb-8">
        <h1 class="text-2xl font-semibold tracking-tight">
          Forgot Password
        </h1>
      </div>

      <div class="mb-4 text-sm text-gray-600 dark:text-gray-400">
        Forgot your password? No problem. Just let us know your email address and we will email you a password reset
        link that will allow you to choose a new one.
      </div>

      <div
        v-if="status"
        class="mb-4 font-medium text-sm text-green-600 dark:text-green-400"
      >
        {{ status }}
      </div>

      <form @submit.prevent="submit">
        <div>
          <InputLabel
            for="email"
            value="Email"
          />

          <Input
            id="email"
            type="email"
            class="mt-1 block w-full"
            v-model="form.email"
            required
            autofocus
            autocomplete="username"
          />

          <InputError
            class="mt-2"
            :message="form.errors.email"
          />
        </div>

        <div class="flex items-center justify-end mt-4">
          <Button
            :class="{ 'opacity-25': form.processing }"
            :disabled="form.processing"
          >
            Email Password Reset Link
          </Button>
        </div>
      </form>
    </div>
  </Layout>
</template>
