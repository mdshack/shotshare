<script setup>
import { computed } from "vue";
import { Separator } from "radix-vue";
import { cn } from "@/lib/utils";

const props = defineProps({
  orientation: { type: String, required: false },
  decorative: { type: Boolean, required: false },
  asChild: { type: Boolean, required: false },
  as: { type: null, required: false },
  class: { type: null, required: false },
});

const delegatedProps = computed(() => {
  const { class: _, ...delegated } = props;

  return delegated;
});
</script>

<template>
  <Separator
    v-bind="delegatedProps"
    :class="
      cn(
        'shrink-0 bg-border',
        props.orientation === 'vertical' ? 'w-px h-full' : 'h-px w-full',
        props.class
      )
    "
  />
</template>
