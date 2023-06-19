import { defineStore } from 'pinia';

export const useFacturasStore = defineStore('facturas', {

    state: () => ({
        facturas: [],
        facturasFiltered: []
    }),

    actions: {

        filterFacturas(){

        }

    },

    getters: {

    }

});
