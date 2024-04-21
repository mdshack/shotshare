<script setup>
import {
    Tooltip,
    TooltipContent,
    TooltipProvider,
    TooltipTrigger
} from '@/Components/ui/tooltip'
import { format } from 'timeago.js'

defineProps({
    datetime: String
})
</script>

<template>
  <template v-if="datetime">
    <TooltipProvider>
      <Tooltip>
        <TooltipTrigger>
          {{ format(datetime) }}
        </TooltipTrigger>
        <TooltipContent>
          {{ datetime }}
        </TooltipContent>
      </Tooltip>
    </TooltipProvider>
  </template>
  <template v-else>
    <slot name="empty-state">
      <span class="text-gray-500">--</span>
    </slot>
  </template>
</template>
