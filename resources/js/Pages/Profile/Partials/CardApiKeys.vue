<script setup>
import { Button } from '@/Components/ui/button'
import { router } from '@inertiajs/vue3';
import { TrashIcon } from "@heroicons/vue/24/outline";
import Spinner from '@/Components/ui/Spinner.vue'
import TimeAgo from '@/Components/ui/TimeAgo.vue'
import RequireConfirmationDialog from '@/Components/RequireConfirmationDialog.vue'
import DialogCreateApiKey from '@/Pages/Profile/Partials/DialogCreateApiKey.vue'
import {
    Card,
    CardContent,
    CardDescription,
    CardFooter,
    CardHeader,
    CardTitle,
} from '@/Components/ui/card'
import {
    Table,
    TableBody,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
} from '@/Components/ui/table'

defineProps({
    apiKeys: Array,
})

const deleteApiKey = (apiKeyId) => {
    return axios.delete(route('api-keys.destroy', apiKeyId))
        .catch((err) => {
            console.error("Failed to delete API key")
            console.error(err)
        })
        .finally(() => {
            router.reload({only: [
                'apiKeys',
            ]})
        })
}
</script>

<template>
    <Card>
        <CardHeader>
            <CardTitle>API Keys</CardTitle>
            <CardDescription>Manage keys used for programmatic access to ShotShare.</CardDescription>
        </CardHeader>
        <CardContent>
            <section class="space-y-6">
                <DialogCreateApiKey>
                    <Button>
                        Create API Key
                    </Button>
                </DialogCreateApiKey>

                <Table>
                    <TableHeader>
                        <TableRow>
                            <TableHead>Name</TableHead>
                            <TableHead>API Key</TableHead>
                            <TableHead>Created</TableHead>
                            <TableHead>Last Used</TableHead>
                            <!-- Actions -->
                            <TableHead/>
                        </TableRow>
                    </TableHeader>
                    <TableBody>
                        <TableRow
                            v-for="apiKey in apiKeys"
                            :key="apiKey.id">
                            <TableCell>
                                {{apiKey.name}}
                            </TableCell>

                            <TableCell>
                                <p class="truncate max-w-[125px]">
                                    {{apiKey.anonymized_token}}
                                </p>
                            </TableCell>

                            <TableCell>
                                <TimeAgo :datetime="apiKey.created_at"/>
                            </TableCell>

                            <TableCell>
                                <TimeAgo :datetime="apiKey.last_used_at">
                                    <template #empty-state>
                                        <p class="text-gray-500 italic">Never</p>
                                    </template>
                                </TimeAgo>
                            </TableCell>

                            <TableCell align="end" class="flex items-center justify-end">
                                <RequireConfirmationDialog :action="() => deleteApiKey(apiKey.id)">
                                    <template #title>
                                        Are you sure you wish to delete this API key?
                                    </template>

                                    <template #description>
                                        Deleting API keys is a destructive action. You will not be able to recover this key if you delete it.
                                    </template>

                                    <template #reject>
                                        Cancel
                                    </template>

                                    <template #confirm>
                                        Delete API Key
                                    </template>

                                    <button class="text-gray-500 hover:text-destructive transition flex items-center justify-center">
                                        <TrashIcon class="h-6 w-6" />
                                    </button>
                                </RequireConfirmationDialog>
                            </TableCell>
                        </TableRow>

                        <!-- Empty State -->
                        <TableRow v-if="apiKeys === undefined">
                            <TableCell :colSpan="5" class="h-36">
                                <div class="w-full h-full flex items-center justify-center">
                                    <Spinner/>
                                </div>
                            </TableCell>
                        </TableRow>

                        <TableRow v-else-if="!apiKeys?.length">
                            <TableCell :colSpan="5" class="h-36 text-center">
                                <h3 class="font-semibold">No API keys exist</h3>
                            </TableCell>
                        </TableRow>
                    </TableBody>
                </Table>
            </section>
        </CardContent>
    </Card>
</template>
