<script setup>
import { useAttrs } from "vue";
import { cn } from "@/lib/utils";

defineOptions({
  inheritAttrs: false,
});

const { class: className, ...rest } = useAttrs();
</script>

<template>
  <p
    :class="cn('text-sm text-muted-foreground', className ?? '')"
    v-bind="rest"
  >
    <slot />
  </p>
</template>
