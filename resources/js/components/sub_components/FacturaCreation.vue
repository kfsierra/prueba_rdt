<template>

    <Modal
    title="Crear factura"
    refModal="facturaCreation"
    classes="!h-screen overflow-y-auto !w-2/5">
        <div class="py-4 flex flex-col gap-2">

            <div class="flex flex-col gap-3">
                <label>Cliente</label>

                <select
                v-model="facturaCreation.idCliente"
                class="bg-white border-2 rounded-lg p-2">
                    <option
                    v-for="cliente in clientesToSelect"
                    :key="cliente.id_cliente"
                    :value="cliente.id_cliente">
                        {{ `${cliente.cedula} - ${cliente.cliente_nombre}` }}
                    </option>
                </select>

            </div>

            <div class="flex flex-col gap-3">

                <label>Seleccionar productos</label>

                <div class="flex flex-col justify-content-between items-center gap-2">

                    <select
                    v-model="facturaCreation.currentProductoSelected.id"
                    class="bg-white border-2 rounded-lg p-2 w-full">

                        <option
                        v-for="producto in productosToSelect"
                        :key="producto.id_producto"
                        :value="producto.id_producto"
                        :title="`$${producto.precio}`">
                            {{ producto.nombre }}
                        </option>

                    </select>

                    <div class="flex justify-between items-center gap-2 w-full">
                        <input
                        :class="[
                            (!isProductoSelected) ? 'bg-slate-100' : 'bg-white',
                            'border-2 rounded-lg p-2 w-2/3'
                        ]"
                        v-model="facturaCreation.currentProductoSelected.cantidad"
                        :disabled="!isProductoSelected"
                        type="number"
                        placeholder="Cantidad">

                        <button
                        @click="addProductoToFactura()"
                        :disabled="!isCantidadDefined"
                        :class="[
                            {
                                'hover:bg-yellow-500': isCantidadDefined
                            },
                            'bg-yellow-400 w-1/3 h-8 rounded text-center'
                        ]">
                            <i class="bi bi-plus-lg text-xl"></i>
                        </button>
                    </div>

                    <div
                    v-show="facturaCreation.creationError.visible"
                    class="bg-red-300 text-red-800 font-bold p-2 w-full rounded text-center">
                        <i class="bi bi-exclamation-triangle"></i>
                        {{ facturaCreation.creationError.message }}
                    </div>

                </div>

            </div>

            <div>
                <table class="w-full my-4 text-center">
                    <thead>
                        <tr>
                            <td class="bg-white border-l-2 border-y-2 1/4 p-1">Producto</td>
                            <td class="bg-white border-l-2 border-y-2 1/4 p-1">Precio</td>
                            <td class="bg-white border-l-2 border-y-2 1/4 p-1">Cantidad</td>
                            <td class="bg-white border-2 1/4 p-1"></td>
                        </tr>
                    </thead>
                    <tbody class="divide-y text-gray-700">
                        <tr
                        v-for="(itemAdded, index) in facturaCreation.items"
                        :key="index">

                            <td :class="[
                                (index % 2 == 0) ? 'bg-gray-100' : 'bg-white',
                                'border-l-2 border-b-2 p-2'
                            ]">
                                {{ itemAdded.nombre }}
                            </td>

                            <td :class="[
                                (index % 2 == 0) ? 'bg-gray-100' : 'bg-white',
                                'border-l-2 border-b-2 p-2'
                            ]">
                                {{ itemAdded.precio }}
                            </td>

                            <td :class="[
                                (index % 2 == 0) ? 'bg-gray-100' : 'bg-white',
                                'border-l-2 border-b-2 p-2'
                            ]">
                                {{ itemAdded.cantidad }}
                            </td>

                            <td :class="[
                                (index % 2 == 0) ? 'bg-gray-100' : 'bg-white',
                                'border-l-2 border-b-2 border-r-2 p-2'
                            ]">
                                <button
                                @click="removeProductoFromFactura(itemAdded.id)"
                                class="bg-red-500 hover:bg-red-600 rounded w-6 h-6">
                                    <i class="bi bi-trash text-white"></i>
                                </button>
                            </td>

                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="flex flex-col gap-3 my-2">
                <button
                @click="createFactura()"
                class="bg-green-500 rounded-lg p-2 text-white hover:bg-green-600">
                    Guardar
                </button>
            </div>

        </div>
    </Modal>

</template>

<script setup>

import { computed } from 'vue';
import Modal from '@/components/sub_components/Modal.vue';
import { useFacturasStore } from '@/stores/facturas';
import { storeToRefs } from 'pinia';

const useFacturas = useFacturasStore();
const { clientesToSelect, productosToSelect, facturaCreation } = storeToRefs(useFacturas);
const { addProductoToFactura, removeProductoFromFactura, createFactura } = useFacturas;

const isProductoSelected = computed(() => {
    return facturaCreation.value.currentProductoSelected.id != null && facturaCreation.value.currentProductoSelected.id != '';
});

const isCantidadDefined = computed(() => {
    return  facturaCreation.value.currentProductoSelected.cantidad != null && facturaCreation.value.currentProductoSelected.cantidad != '';
});

</script>
