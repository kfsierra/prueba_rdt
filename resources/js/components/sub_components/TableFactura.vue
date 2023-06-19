<template>

    <div class="flex justify-between border-b-2 -mx-4 px-4 pb-4 mb-4">
        <span class="font-bold text-slate-700">Lista de facturas</span>
        <div class="flex gap-3 text-slate-500">
            <button>Nuevo</button>
            <button>Exportar</button>
        </div>
    </div>

    <div class="flex justify-between items-center">

        <div class="flex gap-3 items-center text-sm">
            <span>Mostrar</span>
            <select
            @change="changeNumItemsShowing()"
            v-model="pagination.numItemsShowing"
            class="border-2 p-2 rounded">
                <option :value="10">10</option>
                <option :value="20">20</option>
                <option :value="50">50</option>
                <option :value="100">100</option>
            </select>
            <span>Registros</span>
        </div>

        <div class="flex">
            <input class="border-2 p-2 w-80 flex-1" placeholder="Buscar..." type="text">
        </div>

    </div>

    <table class="w-full my-4 text-center">
        <thead>
            <tr class="text-slate-600">
                <th class="bg-white border-l-2 border-t-2 border-b-2 w-1/5 p-3">
                    Número de factura
                </th>
                <th class="bg-white border-l-2 border-t-2 border-b-2 w-1/5 p-3">
                    Cédula Cliente
                </th>
                <th class="bg-white border-l-2 border-t-2 border-b-2 w-1/5 p-3">
                    Nombre Cliente
                </th>
                <th class="bg-white border-l-2 border-t-2 border-b-2 w-1/5 p-3">
                    Fecha
                </th>
                <th class="bg-white border-2 w-1/5 p-3"></th>
            </tr>
        </thead>
        <tbody class="divide-y text-gray-700">
            <tr v-for="(factura, index) in getFacturasPaginated" :key="factura.num_factura">

                <td :class="[
                    (index % 2 == 0) ? 'bg-gray-100' : 'bg-white',
                    'p-4',
                    'border-l-2 border-t-2 border-b-2 w-1/5'
                ]">
                    {{ factura.num_factura }}
                </td>

                <td :class="[
                    (index % 2 == 0) ? 'bg-gray-100' : 'bg-white',
                    'p-4',
                    'border-l-2 border-t-2 border-b-2 w-1/5'
                ]">
                    {{ factura.cliente_cedula }}
                </td>

                <td :class="[
                    (index % 2 == 0) ? 'bg-gray-100' : 'bg-white',
                    'p-4',
                    'border-l-2 border-t-2 border-b-2 w-1/5'
                ]">
                    {{ factura.cliente_nombre }}
                </td>

                <td :class="[
                    (index % 2 == 0) ? 'bg-gray-100' : 'bg-white',
                    'p-4',
                    'border-l-2 border-t-2 border-b-2 w-1/5'
                ]">
                    {{ factura.fecha }}
                </td>

                <td :class="[
                    (index % 2 == 0) ? 'bg-gray-100' : 'bg-white',
                    'p-4',
                    'border-2 w-1/5'
                ]">
                    <div class="flex justify-center items-center gap-3">
                        <button class="w-10 h-10 bg-blue-600 text-white cursor-pointer rounded hover:bg-blue-700">
                            <i class="bi bi-pencil-square"></i>
                        </button>
                        <button class="w-10 h-10 bg-red-500 text-white cursor-pointer rounded hover:bg-red-700">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                </td>

            </tr>
        </tbody>
    </table>

    <div class="flex justify-between">
        <span class="text-sm">
            Mostrando {{ `${pagination.start + 1}-${pagination.start + pagination.numItemsShowing} de ${facturasFiltered.length}` }}
        </span>
        <div>

            <button
            @click="clickButtonPagination('back')"
            class="w-10 h-10 bg-white border-2 text-blue-500">
                <i class="bi bi-chevron-double-left"></i>
            </button>

            <button
            v-for="i in pagination.numPages"
            :key="i"
            :class="[
                {
                    'border-l-2': i != 1
                },
                'w-10 h-10 border-t-2 border-b-2 hover:bg-blue-500 hover:text-white',
                (i == pagination.pageActive) ? 'bg-blue-500 text-white' : 'bg-white text-blue-500'
            ]"
            @click="changePagination(i)">
                {{ i }}
            </button>

            <button
            @click="clickButtonPagination('next')"
            class="w-10 h-10 bg-white border-2 text-blue-500">
                <i class="bi bi-chevron-double-right"></i>
            </button>

        </div>
    </div>

</template>

<script setup>

import { useFacturasStore } from '@/stores/facturas';
import { storeToRefs } from 'pinia';
import { ref, computed } from 'vue';

const useFacturas = useFacturasStore();
const { facturas, facturasFiltered } = storeToRefs(useFacturas);

/**
 * Reactive
 */
const pagination = ref({
    start: 0,
    numItemsShowing: 10,
    pageActive: 1,
    numPages: 1
});

/**
 * Computed
 */
const getFacturasPaginated = computed(() => {
    setNumPages();
    return facturasFiltered.value.slice(pagination.value.start, (pagination.value.start + pagination.value.numItemsShowing));
});

/**
 * Methods
 */
const changeNumItemsShowing = () => {
    setNumPages();
    pagination.value.pageActive = 1;
}

const changePagination = (i) => {
    pagination.value.start = (i * pagination.value.numItemsShowing) - pagination.value.numItemsShowing;
    pagination.value.pageActive = i;
}

const setNumPages = () => {
    pagination.value.numPages = Math.ceil(facturasFiltered.value.length / pagination.value.numItemsShowing);
}

const clickButtonPagination = (button) => {

    switch (button) {
        case 'back':

            if (pagination.value.pageActive != 1) {
                pagination.value.start -= pagination.value.numItemsShowing;
                pagination.value.pageActive--;
            }

            break;
        case 'next':

            if (pagination.value.pageActive != pagination.value.numPages) {
                pagination.value.start += pagination.value.numItemsShowing;
                pagination.value.pageActive++;
            }

            break;
    }

}

</script>
