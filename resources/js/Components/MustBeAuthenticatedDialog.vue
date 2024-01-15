<script setup>
import {
    AlertDialog,
    AlertDialogAction,
    AlertDialogCancel,
    AlertDialogContent,
    AlertDialogDescription,
    AlertDialogFooter,
    AlertDialogHeader,
    AlertDialogTitle,
    AlertDialogTrigger,
} from '@/Components/ui/alert-dialog'
import { router } from '@inertiajs/vue3';

defineProps({
    action: Function
})

const redirectToLogin = () => {
    router.visit(route('login', {
        redirect_to: window.location.pathname
    }))
}
</script>

<template>
    <AlertDialog v-if="!$page.props.auth.user?.id">
        <AlertDialogTrigger>
            <slot/>
        </AlertDialogTrigger>
        <AlertDialogContent>
            <AlertDialogHeader>
                <AlertDialogTitle>Must be signed in</AlertDialogTitle>
                <AlertDialogDescription>
                    You must be authenticated to perform this action. Would you like to sign in?
                </AlertDialogDescription>
            </AlertDialogHeader>
            <AlertDialogFooter>
                <AlertDialogCancel>
                    Cancel
                </AlertDialogCancel>
                <AlertDialogAction @click="redirectToLogin">
                    Sign In
                </AlertDialogAction>
            </AlertDialogFooter>
        </AlertDialogContent>
    </AlertDialog>

    <span v-else @click.prevent="action">
        <slot />
    </span>
</template>
