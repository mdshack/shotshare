<script setup>
import { Link } from '@inertiajs/vue3';
import { Input } from '@/Components/ui/input'
import { Aperture, Scan, Search } from 'lucide-vue-next';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
</script>

<template>
    <div class="flex flex-col items-center w-full pt-16">
        <div class="flex items-center tracking-widest">
            <ApplicationLogo size="md"/>
            <div class="text-4xl ml-2 font-semibold">ShotShare</div>
        </div>
        <slot />
    </div>
</template>
