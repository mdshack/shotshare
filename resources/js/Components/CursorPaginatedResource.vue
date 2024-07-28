<script setup>
import {onMounted, ref, watch} from "vue"
import axios from "axios"
import Spinner from "@/Components/ui/Spinner.vue";
import {Button} from "@/Components/ui/button";
import uniqueBy from 'lodash/uniqBy'

const props = defineProps({
    paginatedRoute: String,
    params: Object,

    uniqueField: {
        type: String,
        default: "id",
    },
    sortField: {
        type: String,
        default: "created_at",
    },
})

const items = ref([])
const loading = ref(false)
const next = ref(null)

const load = (cursor = undefined) => {
    loading.value = true

    axios.get(route(props.paginatedRoute, {...props.params, cursor: cursor !== undefined ? cursor : next.value}))
        .then(({data}) => {
            items.value = uniqueBy([...items.value, ...data.data], props.uniqueField)

            if(cursor === undefined) {
                next.value = data.next_cursor
            }

            items.value.sort((a,b) => {
                if (a[props.sortField] > b[props.sortField]) {
                    return -1
                } else if (a[props.sortField] < b[props.sortField]) {
                    return 1
                }

                return 0
            })
        })
        .finally(() => {
            loading.value = false
        })
}

const paramSignature = ref(null)
watch(() => props.params, () => {
    const paramSig = JSON.stringify(props.params)

    if(!paramSignature.value) {
        paramSignature.value = paramSig
    }

    if(paramSignature.value != paramSig) {
        console.log("resetting resource")
        items.value = []
        loading.value = false
        next.value = null
        load()
    }
})

onMounted(() => {
    load()
})
</script>

<template>
    <slot name="before" :load="load"/>

    <template v-for="item in items">
        <slot name="item" :item="item"/>
    </template>

    <slot v-if="!loading && !items.length" name="empty">
        <div class="p-4 flex items-center justify-center text-muted-foreground text-sm">
            Nothing to see here
        </div>
    </slot>

    <slot v-if="loading" name="loading">
        <div  class="p-4 flex items-center justify-center">
            <Spinner />
        </div>
    </slot>

    <slot v-if="next" name="load-more" :load="load">
        <div class="p-4 flex items-center justify-center">
            <Button @click.prevent="load()" variant="outline">Load More</Button>
        </div>
    </slot>

    <slot name="after" :load="load"/>
</template>
