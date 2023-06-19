<template>

    <div class="flex justify-between border-b-2 -mx-4 px-4 pb-4 mb-4">
        <span class="font-bold text-slate-700">Lista de facturas</span>
        <div class="flex gap-3 text-slate-500">

            <button
            @click="openModalFacturaCreation()"
            class="flex gap-2 items-center justify-center hover:text-yellow-500">
                Nuevo
                <i class="bi bi-plus-lg"></i>
            </button>

            <button
            class="flex gap-2 items-center justify-center hover:text-yellow-500"
            @click="modals.filters = true">
                Filtrar
                <i class="bi bi-funnel-fill"></i>
            </button>

            <div class="relative">

                <button
                @click="facturaExport.dropdown.visible = !facturaExport.dropdown.visible"
                class="flex gap-2 items-center justify-center hover:text-yellow-500">
                    Exportar
                    <i class="bi bi-caret-down-fill"></i>
                </button>

                <div
                v-show="facturaExport.dropdown.visible"
                class="
                absolute
                bottom-0
                right-0
                w-40
                bg-white
                translate-y-full
                border-2
                shadow
                flex
                flex-col items-start">
                    <button class="flex gap-2 items-center hover:bg-blue-200 w-full p-2">
                        <i class="bi bi-file-earmark-excel text-green-500"></i>
                        Excel
                    </button>
                    <button class="flex gap-2 items-center hover:bg-blue-200 w-full p-2">
                        <i class="bi bi-file-earmark-pdf text-red-500"></i>
                        PDF
                    </button>
                </div>

            </div>

        </div>
    </div>

    <div
    v-show="facturaCreation.creationSuccess.visible"
    class="bg-green-200 text-green-800 p-2 my-4 rounded font-bold flex items-center gap-2">
        <i class="bi bi-check2 text-2xl"></i>
        {{ facturaCreation.creationSuccess.message }}
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
            <input
            @input="filterFacturas()"
            v-model="filters.search"
            class="border-2 p-2 w-80 flex-1"
            placeholder="Buscar..."
            type="text">
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

            <template v-for="(factura, index) in getFacturasPaginated" :key="factura.num_factura">

                <tr>

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
                        {{ moment(factura.fecha).format('YYYY-MM-DD hh:mm A') }}
                    </td>

                    <td :class="[
                        (index % 2 == 0) ? 'bg-gray-100' : 'bg-white',
                        'p-4',
                        'border-2 w-1/5'
                    ]">
                        <div class="flex justify-center items-center gap-3">

                            <button
                            @click="getFacturaDetail(factura.num_factura)"
                            class="w-10 h-10 bg-blue-600 text-white cursor-pointer rounded hover:bg-blue-700">
                                <i class="bi bi-pencil-square"></i>
                            </button>

                            <button
                            @click="deleteFactura(factura.num_factura)"
                            class="w-10 h-10 bg-red-500 text-white cursor-pointer rounded hover:bg-red-700">
                                <i class="bi bi-trash"></i>
                            </button>

                        </div>
                    </td>

                </tr>

                <tr
                v-if="facturaDetail?.num_factura == factura.num_factura">
                    <td
                    class="border-l-2 border-r-2 bg-green-100 p-2"
                    colspan="5">

                        <div class="w-full flex justify-center py-3">
                            <table class="w-1/2">
                                <thead>
                                    <tr>
                                        <th colspan="4">Detalle de la factura</th>
                                    </tr>
                                    <tr class="text-slate-600">
                                        <th class="bg-green-400 p-1">Producto</th>
                                        <th class="bg-green-400 p-1">Precio</th>
                                        <th class="bg-green-400 p-1">Cantidad</th>
                                        <th class="bg-green-400 p-1"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(itemFactura, index) in facturaDetail.items" :key="index">
                                        <td class="bg-green-200 border-b-2 border-green-600 p-2">{{ itemFactura.producto_nombre }}</td>
                                        <td class="bg-green-200 border-b-2 border-green-600 p-2">${{ itemFactura.producto_precio }}</td>
                                        <td class="bg-green-200 border-b-2 border-green-600 p-2">{{ itemFactura.cantidad }}</td>
                                        <td class="bg-green-200 border-b-2 border-green-600 p-2">

                                            <button
                                            @click="deleteFacturaDetail(factura.num_factura, itemFactura.producto_id)"
                                            class="bg-red-500 w-6 h-6 rounded">
                                                <i class="bi bi-trash text-white"></i>
                                            </button>

                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </td>
                </tr>

            </template>

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
import moment from 'moment';

const useFacturas = useFacturasStore();

const {
    facturasFiltered,
    modals,
    facturaDetail,
    facturaCreation,
    filters,
    facturaExport
} = storeToRefs(useFacturas);

const {
    getFacturaDetail,
    deleteFacturaDetail,
    getNecessaryDataToCreate,
    deleteFactura,
    filterFacturas
} = useFacturas;

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

const openModalFacturaCreation = () => {
    getNecessaryDataToCreate();
    modals.value.facturaCreation = true;
}

</script>
