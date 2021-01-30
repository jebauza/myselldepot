<template>
    <div class="card">
        <!-- Carga de datos -->
        <!-- <div v-if="!loaded" class="overlay"><i class="fas fa-2x fa-sync-alt fa-spin"></i></div> -->

        <div class="card-header">
            <div class="card-tools">
                <button v-if="authUserPermissions.includes('products.store')" @click="openModalAddEdit('add')"
                    class="btn btn-info btn-sm">
                    <i class="fas fa-plus-square"> Nuevo Pedido</i>
                </button>
            </div>
        </div>

        <div class="card-body" v-loading.fullscreen.lock="fullscreenLoading">
            <div class="container-fluid">

                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">Criterio de Busqueda</h3>
                    </div>

                    <div class="card-body">
                        <div class="form-row">
                            <div class="form-group col-sm-6 col-md-5 col-lg-3">
                                <label class="control-label">#Pedido</label>
                                <input v-model="searches.order" type="text" class="form-control" name="order" placeholder="#Pedido">
                            </div>
                            <div class="form-group col-sm-6 col-md-5 col-lg-3">
                                <label class="control-label">#Documento</label>
                                <input v-model="searches.document" type="text" class="form-control" name="document" placeholder="#Documento">
                            </div>
                            <div class="form-group col-sm-3 col-md-2 col-lg-2">
                                <label class="control-label">Estado</label>
                                <select v-model="searches.state" class="form-control" >
                                    <option value=""></option>
                                    <option value="A">ACTIVO</option>
                                    <option value="I">RECHAZADO</option>
                                </select>
                            </div>
                            <div class="form-group col-9 col-sm-7 col-md-11 col-lg-3">
                                <label class="control-label">Nombre</label>
                                <input v-model="searches.name" type="text" class="form-control" name="name" placeholder="Nombre">
                            </div>

                            <div class="form-group col-auto mt-4 pt-2">
                                <button @click="clearSearches()" title="Eliminar Filtros" type="button"
                                    class="btn waves-effect waves-light btn-danger float-right">
                                    <i class="fas fa-filter"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">Bandeja de Resultados
                            <span v-show="orders.total" class="right badge badge-dark">{{ orders.total }}</span>
                        </h3>
                    </div>

                    <div v-if="orders.data.length" class="card-body">
                        <div class="card-body table-responsive">
                            <table class="table table-hover table-head-fixed text-nowrap projects">
                                <thead>
                                    <tr>
                                        <th>#Pedido</th>
                                        <th>#Documento</th>
                                        <th>Cliente</th>
                                        <th>Total</th>
                                        <th>Vendedor</th>
                                        <th>Estado</th>
                                        <th class="text-nowrap text-center">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(order) in orders.data" :key="order.id">
                                        <td v-text="order.order_number"></td>
                                        <td v-text="order.customer.document"></td>
                                        <td>{{order.customer.fullName}}</td>
                                        <td v-text="order.total"></td>
                                        <td v-text="order.seller.fullName"></td>
                                        <td>
                                            <span v-if="order.state == 'A'" class="badge badge-success">{{ order.state | orderState }}</span>
                                            <span v-else class="badge badge-danger">{{ order.state | orderState }}</span>
                                        </td>
                                        <td class="text-nowrap text-center">
                                            <div>
                                                <button v-if="authUserPermissions.includes('orders.show')" @click="generatePDF(order)"
                                                    class="btn waves-effect waves-light btn-outline-primary btn-sm" title="Ver PDF">
                                                    <i class="fas fa-file-pdf"></i>
                                                </button>
                                                <template v-if="order.state == 'A'">
                                                    <button v-if="authUserPermissions.includes('orders.reject')"
                                                        @click="reject(order)"
                                                        class="btn waves-effect waves-light btn-outline-danger btn-sm" title="Rechazar">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </template>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <pagination :class="'mt-2'" :align="'center'" :limit="5" :data="orders" @pagination-change-page="getOrders"></pagination>
                        </div>
                    </div>
                    <div v-else class="alert alert-warning mx-2 text-center" style="margin-top: 18px;">
                        No hay ningún elemento para mostrar
                    </div>
                </div>

                <order-form-add-edit ref="orderFormAddEdit" @updateOrderList="updateOrderList" @generatePDF="generatePDF"></order-form-add-edit>

            </div>

        </div>

    </div>
</template>

<script>
import OrderFormAddEdit from './OrderFormAddEditComponent';

export default {
    components: {OrderFormAddEdit},

    created() {
        this.getOrders();
    },

    watch: {
        'searches.name': function (newValue, oldValue) {
            this.getOrders();
        },
        'searches.document': function (newValue, oldValue) {
            this.getOrders();
        },
        'searches.order': function (newValue, oldValue) {
            this.getOrders();
        },
        'searches.state': function (newValue, oldValue) {
            this.getOrders();
        }
    },

    data() {
        return {
            orders: {data:[]},

            searches: {
                name: '',
                document: '',
                order: '',
                state: ''
            },

            fullscreenLoading: false
        }
    },

    methods: {
        getOrders(page = 1) {
            this.fullscreenLoading = true;
            const url = `/cmsapi/operation/orders?page=${page}`;

            axios.get(url, {
                params: this.searches
            }).then(res => {
                this.fullscreenLoading = false;
                this.orders = res.data;
            }).catch(err => {
                this.fullscreenLoading = false;
                console.log(err.response.data);
            })
        },
        clearSearches() {
            this.searches = {
                name: '',
                document: '',
                order: '',
                state: ''
            };
        },
        openModalAddEdit(action, product = null) {
            this.$refs.orderFormAddEdit.showForm(action, product);
        },
        updateOrderList(action = null) {
            this.getOrders(this.orders.current_page ?? 1 );
        },
        generatePDF(order) {
            const loading = this.$vs.loading({
                type: 'points',
                color: 'blue',
                // background: '#7a76cb',
                text: 'Cargando...'
            });
            const url = `/cmsapi/operation/orders/${order.id}/generate-pdf`;
            const config = {
                responseType: 'blob'
            };

            axios.post(url, {}, config)
            .then(res => {
                loading.close();
                const blob = new Blob([res.data], {type : 'application/pdf'}); // the blob
                const urlPDF = URL.createObjectURL(blob);
                window.open(urlPDF);
            })
            .catch(err => {
                loading.close();
                if(err.response.data.msg_error || err.response.data.message) {
                    Swal.fire({
                        title: 'Error!',
                        text: err.response.data.msg_error ?? err.response.data.message,
                        icon: "error",
                        showCloseButton: true,
                        closeButtonColor: 'red',
                    });
                }
                console.error(err);
            })
        },
        reject(order) {
            const loading = this.$vs.loading({
                type: 'points',
                color: 'blue',
                // background: '#7a76cb',
                text: 'Cargando...'
            });
            const url = `/cmsapi/operation/orders/${order.id}/reject`;

            axios.put(url)
            .then(res => {
                loading.close();
                Swal.fire({
                    title: res.data.msg,
                    icon: "success",
                    timer: 1500,
                    showConfirmButton: false
                });
                this.updateOrderList();
            })
            .catch(err => {
                loading.close();
                if(err.response.data.msg_error || err.response.data.message) {
                     msg_error = err.response.data.msg_error ?? err.response.data.message;
                }

                if (msg_error) {
                    Swal.fire({
                        title: 'Error!',
                        text: msg_error,
                        icon: "error",
                        showCloseButton: true,
                        closeButtonColor: 'red',
                    });
                }
                console.error(err);
            });
        }
    },

    computed: {
        authUserPermissions() {
            return JSON.parse(sessionStorage.getItem('listPermissionsByAuthUser'));
        }
    },

    filters: {
        orderState(state) {
            switch (state) {
                case 'A':
                    return 'ACTIVO';
                    break;

                case 'I':
                    return 'RECHAZADO';
                    break;

                default:
                    return '';
                    break;
            }
        }
    }

}
</script>


