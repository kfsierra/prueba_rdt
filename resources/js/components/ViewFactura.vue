<template>

    <div class="bg-white p-4 rounded border-t-4 border-blue-500">

        <div class="flex justify-between border-b-2 -mx-4 px-4 pb-4">
            <span class="font-bold text-slate-700">Lista de facturas</span>
            <div class="flex gap-3 text-slate-500">
                <button>Nuevo</button>
                <button>Filtrar</button>
                <button>Exportar</button>
            </div>
        </div>

        <table class="w-full my-4 text-center">
            <thead>
                <tr class="text-slate-600">
                    <th class="bg-white border-l-2 border-t-2 border-b-2 w-1/5 p-3">Número de factura</th>
                    <th class="bg-white border-l-2 border-t-2 border-b-2 w-1/5 p-3">Cédula Cliente</th>
                    <th class="bg-white border-l-2 border-t-2 border-b-2 w-1/5 p-3">Nombre Cliente</th>
                    <th class="bg-white border-l-2 border-t-2 border-b-2 w-1/5 p-3">Fecha</th>
                    <th class="bg-white border-2 w-1/5 p-3"></th>
                </tr>
            </thead>
            <tbody class="divide-y text-gray-700">
                <tr v-for="(factura, index) in facturas" :key="factura.num_factura">

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

    </div>

</template>

<script setup>

import axios from 'axios';
import { ref } from 'vue';

const facturas = ref([]);

axios.get('/api/getFacturas').then(response => {
    facturas.value = response.data;
}).catch(err => {});

</script>
