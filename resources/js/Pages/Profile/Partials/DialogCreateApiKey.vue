<script setup>
import { ref } from 'vue'
import { router } from '@inertiajs/vue3'
import { Button } from '@/Components/ui/button'
import {
    Dialog,
    DialogContent,
    DialogDescription,
    DialogFooter,
    DialogHeader,
    DialogTitle,
    DialogTrigger,
} from '@/Components/ui/dialog'
import { Input } from '@/Components/ui/input'
import {
    FormControl,
    FormDescription,
    FormItem,
    FormLabel,
    FormMessage,
} from '@/Components/ui/form'
import axios from 'axios'
import { Label } from '@/Components/ui/label'
import { UseClipboard } from '@vueuse/components'
import { ClipboardIcon, CheckIcon } from "@heroicons/vue/24/outline"
import { watch } from 'vue'

const open = ref(false)

const form = ref({
    name: "",
})

const errors = ref({
    name: null
})

const token = ref(null)

watch(open, () => {
    if(!open.value) {
        token.value = null
    }
})

const submit = () => {
    return axios.post(route('api-keys.store'), form.value)
        .then(({data}) => {
            token.value = data.token
        })
        .catch(({response}) => {
            errors.value.name = response?.data?.errors?.name[0] ?? "Unknown error occurred"
        })
        .finally(() => {
            router.reload({only: [
                'apiKeys',
            ]})
        })
}

const close = () => {
    open.value = false
}
</script>

<template>
  <Dialog v-model:open="open">
    <DialogTrigger>
      <slot />
    </DialogTrigger>
    <DialogContent>
      <DialogHeader>
        <DialogTitle>Create API Key</DialogTitle>
        <DialogDescription>
          Create a new API key to be used for programmatic access to ShotShare
        </DialogDescription>
      </DialogHeader>

      <form
        v-if="!token"
        class="space-y-4"
        @submit.prevent="submit"
      >
        <FormItem>
          <FormLabel
            for="name"
            :invalid="Boolean(errors.name)"
          >
            Name
          </FormLabel>

          <FormControl>
            <Input
              v-model="form.name"
              id="name"
              type="text"
              placeholder="a descriptive name"
              @change="errors.name = null"
            />
          </FormControl>

          <FormDescription>
            Give the API key a recognizable label
          </FormDescription>

          <FormMessage v-if="errors.name">
            {{ errors.name }}
          </FormMessage>
        </FormItem>
      </form>

      <div
        v-else
        class="space-y-4"
      >
        <div>
          <Label
            for="api_key"
            class="mb-2"
          >Token</Label>
          <div class="relative">
            <Input
              id="api_key"
              :model-value="token"
              disabled
            />
            <UseClipboard
              v-slot="{ copy, copied }"
              :source="token"
            >
              <Button
                @click.prevent="copy()"
                class="absolute right-0 top-0 bottom-0 text-accent hover:text-primary"
                variant="ghost"
              >
                <CheckIcon
                  v-if="copied"
                  class="h-5 w-5 text-green-500"
                />
                <ClipboardIcon
                  v-else
                  class="h-5 w-5"
                />
              </Button>
            </UseClipboard>
          </div>
        </div>
        <p class="font-semibold text-yellow-300">
          Ensure you save this key somewhere as it will only be displayed this one time.
        </p>
      </div>

      <DialogFooter v-if="!token">
        <Button
          variant="outline"
          @click.prevent="close"
        >
          Cancel
        </Button>
        <Button
          type="submit"
          @click.prevent="submit"
        >
          Create API Key
        </Button>
      </DialogFooter>

      <DialogFooter v-else>
        <Button @click.prevent="close">
          I have copied my key
        </Button>
      </DialogFooter>
    </DialogContent>
  </Dialog>
</template>
