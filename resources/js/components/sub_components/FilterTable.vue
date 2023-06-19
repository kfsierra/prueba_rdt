<template>

    <Modal
    title="Filtrar"
    refModal="filters">

        <div class="py-4 flex flex-col gap-2">

            <div class="flex flex-col gap-3">
                <label>Número de factura</label>
                <input
                v-model="filters.numFactura"
                type="number"
                class="bg-white border-2 rounded-lg p-2">
            </div>

            <div class="flex flex-col gap-3">
                <label>Cédula cliente</label>
                <input
                v-model="filters.cedulaCliente"
                type="number"
                class="bg-white border-2 rounded-lg p-2">
            </div>

            <div class="flex flex-col gap-3">
                <label>Nombre cliente</label>
                <input
                v-model="filters.nombreCliente"
                type="text"
                class="bg-white border-2 rounded-lg p-2">
            </div>

            <div class="flex flex-col gap-3">
                <label>Fecha</label>
                <div class="w-full">

                    <input
                    v-model="filters.fecha.inicio"
                    type="date"
                    class="bg-white border-2 rounded-lg p-2 w-1/2">

                    <input
                    v-model="filters.fecha.fin"
                    type="date"
                    class="bg-white border-2 rounded-lg p-2 w-1/2">

                </div>
            </div>

            <div class="flex flex-col gap-3 my-2">
                <button
                @click="filterFacturas()"
                class="bg-blue-500 rounded-lg p-2 text-white hover:bg-blue-600">
                    Aplicar
                </button>

                <button
                @click="removeFilters()"
                class="bg-red-500 rounded-lg p-2 text-white hover:bg-red-600">
                    Quitar filtros
                </button>
            </div>

        </div>

    </Modal>

</template>

<script setup>

import Modal from './Modal.vue';

import { useFacturasStore } from '@/stores/facturas';
import { storeToRefs } from 'pinia';

const useFacturas = useFacturasStore();
const { filters, modals } = storeToRefs(useFacturas);
const { filterFacturas, removeFilters } = useFacturas;

</script>

