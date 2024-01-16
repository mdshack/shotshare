<script setup>
import { useAttrs, onUpdated } from "vue";
import { Label } from "radix-vue";
import { cn } from "@/lib/utils";

defineOptions({
  inheritAttrs: false,
});
const props = defineProps({
  asChild: { type: Boolean, required: false },
  as: { type: null, required: false },
  invalid: { type: Boolean, default: false }
});

const { class: className, ...rest } = useAttrs();
</script>

<template>
    <Label
        :class="
        cn(
            'block text-sm tracking-tight font-medium text-left',
            invalid ? 'text-destructive' : 'text-foreground',
            className ?? ''
        )
        "
        v-bind="rest"
    >
        <slot />
    </Label>
</template>
