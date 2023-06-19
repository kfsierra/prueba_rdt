import { defineStore } from 'pinia';
import moment from 'moment';

export const useFacturasStore = defineStore('facturas', {

    state: () => ({
        facturas: [],
        facturasFiltered: [],
        filters: {
            modalShowing: false,
            numFactura: null,
            cedulaCliente: null,
            nombreCliente: null,
            fecha: {
                inicio: null,
                fin: null
            }
        },
        modals: {
            default: false,
            filters: false,
        }
    }),

    actions: {

        filterFacturas(){
            let filtered = this.filterByNumFactura(this.facturas);
            filtered = this.filterByCedulaCliente(filtered);
            filtered = this.filterByNombreCliente(filtered);
            filtered = this.filterByFecha(filtered);

            this.facturasFiltered = filtered;
        },

        filterByNumFactura(items){
            return this.filters.numFactura
                ? items.filter(item => item.num_factura == this.filters.numFactura)
                : items;
        },

        filterByCedulaCliente(items){
            return this.filters.cedulaCliente
                ? items.filter(item => item.cliente_cedula == this.filters.cedulaCliente)
                : items;
        },

        filterByNombreCliente(items){
            return this.filters.nombreCliente
                ? items.filter(item => item.cliente_nombre.toLowerCase().includes(this.filters.nombreCliente.toLowerCase()))
                : items;
        },

        filterByFecha(items){
            let itemsReturn = items;

            if (this.filters.fecha.inicio) {
                itemsReturn = itemsReturn.filter(item => moment(item.fecha).format('YYYY-MM-DD') >= this.filters.fecha.inicio);
            }
            if (this.filters.fecha.fin) {
                itemsReturn = itemsReturn.filter(item => moment(item.fecha).format('YYYY-MM-DD') <= this.filters.fecha.fin);
            }

            return itemsReturn;
        },

        removeFilters(){
            this.filters.numFactura = null;
            this.filters.cedulaCliente = null;
            this.filters.nombreCliente = null;
            this.filters.fecha.inicio = null;
            this.filters.fecha.fin = null;

            this.filterFacturas();
        }

    },

    getters: {

    }

});
