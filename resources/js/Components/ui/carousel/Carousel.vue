<script setup>
import { useProvideCarousel } from "./useCarousel";
import { cn } from "@/lib/utils";

const props = defineProps({
  opts: { type: null, required: false },
  plugins: { type: null, required: false },
  orientation: { type: String, required: false, default: "horizontal" },
  class: { type: null, required: false },
});

const emits = defineEmits(["init-api"]);

const carouselArgs = useProvideCarousel(props, emits);

defineExpose(carouselArgs);

function onKeyDown(event) {
  const prevKey = props.orientation === "vertical" ? "ArrowUp" : "ArrowLeft";
  const nextKey = props.orientation === "vertical" ? "ArrowDown" : "ArrowRight";

  if (event.key === prevKey) {
    event.preventDefault();
    carouselArgs.scrollPrev();

    return;
  }

  if (event.key === nextKey) {
    event.preventDefault();
    carouselArgs.scrollNext();
  }
}
</script>

<template>
  <div
    :class="cn('relative', props.class)"
    role="region"
    aria-roledescription="carousel"
    tabindex="0"
    @keydown="onKeyDown"
  >
    <slot v-bind="carouselArgs" />
  </div>
</template>
