<script setup>
import { TooltipProvider } from "radix-vue";

const props = defineProps({
  delayDuration: { type: Number, required: false, default: 100 },
  skipDelayDuration: { type: Number, required: false },
  disableHoverableContent: { type: Boolean, required: false },
  disableClosingTrigger: { type: Boolean, required: false },
});
</script>

<template>
  <TooltipProvider v-bind="props">
    <slot />
  </TooltipProvider>
</template>
