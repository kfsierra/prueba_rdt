<template>

    <div
    :class="[
        modals[refModal] ? 'translate-x-0' : 'translate-x-full',
        'fixed bottom-0 right-0 w-96 h-3/4 bg-white border-2 rounded transition-transform duration-500 p-4 shadow'
    ]">
        <div class="flex justify-between">
            <span class="font-bold text-slate-600">{{ title }}</span>
            <button @click="modals[refModal] = false">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>

        <slot></slot>

    </div>

</template>

<script setup>

import { useFacturasStore } from '@/stores/facturas';
import { storeToRefs } from 'pinia';

const useFacturas = useFacturasStore();
const { modals } = storeToRefs(useFacturas);

defineProps({
    refModal: {
        type: String,
        default: 'default'
    },
    title: String
})

</script>
