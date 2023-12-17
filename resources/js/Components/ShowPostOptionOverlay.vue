<script setup>
import { toRefs } from 'vue';
import { } from '@inertiajs/vue3';

defineEmits(['close', 'deleteSelected'])

const props = defineProps({
    deleteType: String,
    id: Number,
})

const { deleteType, id } = toRefs(props)
</script>

<template>
    <div id="show-post-option-overlay"
        class="fixed flex items-center z-50 top-0 left-0 w-full h-screen bg-[#000000] bg-opacity-60 p-3">
        <div class="max-w-sm w-full mx-auto mt-10 bg-white rounded-xl text-center">
            <button class="font-extrabold w-full text-red-600 p-3 text-lg border-b border-b-gray-300 cursor-pointer">
                Delete
            </button>
            <div @click="$emit('close')" class="p-3 text-lg cursor-pointer">Cancel</div>
        </div>
    </div>
</template>
