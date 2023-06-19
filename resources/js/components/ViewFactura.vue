<template>

    <div class="bg-white p-4 rounded border-t-4 border-blue-500">
        <TableFactura/>
    </div>

    <FilterTable/>

</template>

<script setup>

import axios from 'axios';
import { ref } from 'vue';
import { useFacturasStore } from '@/stores/facturas';
import { storeToRefs } from 'pinia';
import TableFactura from './sub_components/TableFactura.vue';
import FilterTable from './sub_components/FilterTable.vue';

const useFacturas = useFacturasStore();
const { facturas, facturasFiltered } = storeToRefs(useFacturas);

axios.get('/api/getFacturas').then(response => {
    facturas.value = response.data;
    facturasFiltered.value = response.data;
}).catch(err => {});

</script>
