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
            },
            search: ''
        },
        modals: {
            default: false,
            filters: false,
            facturaCreation: false
        },
        facturaDetail: null,

        facturaCreation: {
            idCliente: null,
            currentProductoSelected: {
                id: null,
                cantidad: null
            },
            items: [],
            creationError: {
                visible: false,
                message: ''
            },
            creationSuccess: {
                visible: false,
                message: 'Factura creada exitosamente'
            }
        },

        clientesToSelect: [],
        productosToSelect: []
    }),

    actions: {

        filterFacturas(){
            let filtered = this.includesSearchInFilter(this.facturas);
            filtered = this.filterByNumFactura(filtered);
            filtered = this.filterByCedulaCliente(filtered);
            filtered = this.filterByNombreCliente(filtered);
            filtered = this.filterByFecha(filtered);

            this.facturasFiltered = filtered;
        },

        includesSearchInFilter(items){
            return this.filters.search
                ? items.filter(
                        item => Object.values(item).some(
                            item => item.toString().toLowerCase().includes(this.filters.search.toLowerCase())
                        )
                    )
                : items;
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
        },

        /**
         * Get factura detail
         */

        getFacturaDetail(numFactura){
            axios.post('api/getFacturaDetail', {
                numFactura: numFactura
            }).then(response => {
                this.facturaDetail = response.data;
            });
        },

        /**
         * Delete factura detail
         */
        deleteFacturaDetail(numFactura, idProducto){
            axios.post('api/deleteFacturaDetail', {
                numFactura,
                idProducto
            }).then(response => {
                this.facturaDetail.items = this.facturaDetail.items.filter(item => item.producto_id != idProducto);
            })
        },

        /**
         * Get necessary data to create facturas
        */
        getNecessaryDataToCreate(){
            if (!this.clientesToSelect.length || !this.productosToSelect.length) {
                axios.get('api/getNecessaryDataToCreate').then(response => {
                    this.clientesToSelect = response.data.clientes;
                    this.productosToSelect = response.data.productos;
                });
            }
        },

        /**
         * add product to factura items
         */
        addProductoToFactura(){

            const productSelected = this.productosToSelect.find(item => item.id_producto == this.facturaCreation.currentProductoSelected.id);
            const stockProdutSelected = productSelected?.stock || 0;

            /**
             * Declare product addition validations
             */
            const validation = [
                {
                    type: 'alreadyAdded',
                    message: 'Este producto ya se encuentra agregado.',
                    result: !this.facturaCreation.items.some(item => item.id == this.facturaCreation.currentProductoSelected.id)
                },
                {
                    type: 'notInStock',
                    message: 'Este producto no se encuentra disponible.',
                    result: stockProdutSelected > 0
                },
                {
                    type: 'notSpecifiedAmount',
                    message: `No contamos con la cantidad solicitada del producto seleccionado. Cantidad disponible: ${ stockProdutSelected }`,
                    result: stockProdutSelected >= this.facturaCreation.currentProductoSelected.cantidad
                }
            ];

            /**
             * Set error message in case of error
             */
            this.facturaCreation.creationError.message = validation.find(item => !item.result)?.message || null;

            /**
             * Validate if there are not errors
             */
            if (!validation.some(item => !item.result)) {

                this.facturaCreation.creationError.visible = false;

                this.productosToSelect.map(item => {
                    if (item.id_producto == this.facturaCreation.currentProductoSelected.id) {
                        item.stock -= this.facturaCreation.currentProductoSelected.cantidad;
                    }
                });

                this.facturaCreation.items.push({
                    id: productSelected.id_producto,
                    nombre: productSelected.nombre,
                    precio: productSelected.precio,
                    cantidad: this.facturaCreation.currentProductoSelected.cantidad
                });

            } else {
                this.facturaCreation.creationError.visible = true;
            }

            /**
             * Finally, reset product addition information
             */
            this.facturaCreation.currentProductoSelected.id = null;
            this.facturaCreation.currentProductoSelected.cantidad = null;
        },

        /**
         * Remove some product added in factura
         */
        removeProductoFromFactura(idProducto){

            const findProduct = this.facturaCreation.items.find(item => item.id == idProducto);

            this.facturaCreation.items = this.facturaCreation.items.filter(item => item.id != idProducto);
            this.productosToSelect.map(item => {
                if (item.id_producto == idProducto) {
                    item.stock += findProduct.cantidad;
                }
            });

        },

        /**
         * Create factura
         */
        createFactura(){

            /**
             * Declare factura creation validations
             */
            const validation = [
                {
                    type: 'clientNotSelected',
                    message: 'Por favor selecciona un cliente.',
                    result: this.facturaCreation.idCliente != null && this.facturaCreation.idCliente != ""
                },
                {
                    type: 'notProductsSelected',
                    message: 'Por favor selecciona al menos un producto.',
                    result: this.facturaCreation.items.length > 0
                }
            ];

            /**
             * If there are not errors
             */
            if (!validation.some(item => !item.result)) {

                this.facturaCreation.creationError.visible = false;
                axios.post('api/createFactura', this.facturaCreation).then(response => {

                    if (!response.data.error) {

                        this.resetValuesCreation();
                        this.facturas.push(response.data.facturaCreated);
                        this.facturasFiltered = this.facturas;

                    } else {

                        this.facturaCreation.creationError.message = response.data.message;
                        this.facturaCreation.creationError.visible = true;

                    }

                })

            } else {
                this.facturaCreation.creationError.visible = true;
            }


            /**
             * Set error message in case of error
             */
            this.facturaCreation.creationError.message = validation.find(item => !item.result)?.message || null;

        },

        resetValuesCreation(){

            this.facturaCreation.creationSuccess.visible = true;

            this.facturaCreation.currentProductoSelected.id = null;
            this.facturaCreation.currentProductoSelected.cantidad = null;

            this.facturaCreation.idCliente = null;

            this.facturaCreation.creationError.message = null;
            this.facturaCreation.creationError.visible = false;

            this.modals.facturaCreation = false;

        },

        /**
         * Delete factura
         */
        deleteFactura(numFactura){
            axios.post('api/deleteFactura', {
                numFactura
            }).then(response => {
                this.facturas = this.facturas.filter(item => item.num_factura != numFactura);
                this.facturasFiltered = this.facturas;
            });
        }

    },

    getters: {

    }

});
