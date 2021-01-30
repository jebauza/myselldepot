<template>
    <div class="card">
        <!-- Carga de datos -->
        <!-- <div v-if="!loaded" class="overlay"><i class="fas fa-2x fa-sync-alt fa-spin"></i></div> -->

        <div class="card-header">
            <div class="card-tools">
                <button v-if="authUserPermissions.includes('customers.store')" @click="showForm('add')"
                    class="btn btn-info btn-sm">
                    <i class="fas fa-plus-square"> Nuevo Cliente</i>
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
                            <div class="form-group col-sm-6 col-md-7 col-lg-8">
                                <label class="control-label">Nombre</label>
                                <input v-model="searches.name" type="text" class="form-control" name="name" placeholder="Nombre">
                            </div>
                            <div class="form-group col-8 col-sm-4 col-md-4 col-lg-3">
                                <label class="control-label">#Documento</label>
                                <input v-model="searches.document" type="text" class="form-control" name="document" placeholder="#Documento">
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
                            <span v-show="customers.total" class="right badge badge-dark">{{ customers.total }}</span>
                        </h3>
                    </div>

                    <div v-if="customers.data.length" class="card-body">
                        <div class="card-body table-responsive">
                            <table class="table table-hover table-head-fixed text-nowrap projects">
                                <thead>
                                    <tr>
                                        <th>Nombre</th>
                                        <th>Documento</th>
                                        <th>Correo</th>
                                        <th>Teléfono</th>
                                        <th class="text-nowrap text-center">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(customer) in customers.data" :key="customer.id">
                                        <td v-text="customer.fullName"></td>
                                        <td v-text="customer.document"></td>
                                        <td v-text="customer.email"></td>
                                        <td v-text="customer.phone"></td>
                                        <td class="text-nowrap text-center">
                                            <div>
                                                <button v-if="authUserPermissions.includes('customers.update')" @click="showForm('edit', customer)"
                                                    class="btn waves-effect waves-light btn-outline-primary btn-sm" title="Editar">
                                                    <i class="fas fa-pencil-alt"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <pagination :class="'mt-2'" :align="'center'" :limit="5" :data="customers" @pagination-change-page="getCustomers"></pagination>
                        </div>
                    </div>
                    <div v-else class="alert alert-warning mx-2 text-center" style="margin-top: 18px;">
                        No hay ningún elemento para mostrar
                    </div>
                </div>

                <div class="modal fade" id="modalCustomerFormAddEdit" tabindex="-1" role="dialog" aria-hidden="true" >
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 v-if="modalType=='add'" class="modal-title">Nueva Cliente</h4>
                                <h4 v-else class="modal-title">Editar Cliente</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            <form class="needs-validation" v-on:submit.prevent="actionStoreUpdate">
                                <div class="modal-body">

                                    <div class="form-row">

                                        <div class="form-group col-sm-6">
                                            <label for="name" :class="['control-label', errors.name ? 'text-danger' : '']">Nombre</label>
                                            <input v-model="form.name" type="text" :class="['form-control', errors.name ? 'is-invalid' : '']" name="name" placeholder="Nombre" required>
                                            <small v-if="errors.name" class="form-control-feedback text-danger">
                                                {{ errors.name[0] }}
                                            </small>
                                        </div>

                                        <div class="form-group col-sm-6">
                                            <label for="lastname" :class="['control-label', errors.lastname ? 'text-danger' : '']">Apellidos</label>
                                            <input v-model="form.lastname" type="text" :class="['form-control', errors.lastname ? 'is-invalid' : '']" name="lastname" placeholder="Apellidos" required>
                                            <small v-if="errors.lastname" class="form-control-feedback text-danger">
                                                {{ errors.lastname[0] }}
                                            </small>
                                        </div>

                                        <div class="form-group col-sm-6 col-lg-4">
                                            <label for="document" :class="['control-label', errors.document ? 'text-danger' : '']">Documento</label>
                                            <input v-model="form.document" type="text" :class="['form-control', errors.document ? 'is-invalid' : '']" name="document" placeholder="Documento" required>
                                            <small v-if="errors.document" class="form-control-feedback text-danger">
                                                {{ errors.document[0] }}
                                            </small>
                                        </div>

                                        <div class="form-group col-sm-6 col-lg-4">
                                            <label for="email" :class="['control-label', errors.email ? 'text-danger' : '']">Correo</label>
                                            <input v-model="form.email" type="email" :class="['form-control', errors.email ? 'is-invalid' : '']" name="email" placeholder="Correo" required>
                                            <small v-if="errors.email" class="form-control-feedback text-danger">
                                                {{ errors.email[0] }}
                                            </small>
                                        </div>

                                        <div class="form-group col-sm-6 col-lg-4">
                                            <label for="phone" :class="['control-label', errors.phone ? 'text-danger' : '']">Teléfono</label>
                                            <input v-model="form.phone" type="text" :class="['form-control', errors.phone ? 'is-invalid' : '']" name="phone" placeholder="Teléfono" required>
                                            <small v-if="errors.phone" class="form-control-feedback text-danger">
                                                {{ errors.phone[0] }}
                                            </small>
                                        </div>

                                    </div>
                                </div>
                                <div class="modal-footer justify-content-between">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                                    <button type="submit" class="btn btn-primary">Guardar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>
</template>

<script>

export default {
    created() {
        this.getCustomers();
    },

    watch: {
        'searches.name': function (newValue, oldValue) {
           this.getCustomers();
        },
        'searches.document': function (newValue, oldValue) {
            this.getCustomers();
        }
    },

    data() {
        return {
            customers: {data: []},
            searches: {
                name: '',
                document: ''
            },

            modalType: 'add',
            form: {
                name: '',
                lastname: '',
                document: '',
                email: '',
                phone: '',
                id: ''
            },
            errors: {},

            fullscreenLoading: false
        }
    },

    methods: {
        getCustomers(page = 1) {
            this.fullscreenLoading = true;
            const url = `/cmsapi/operation/customers?page=${page}`;

            axios.get(url, {
                params: this.searches
            }).then(res => {
                this.fullscreenLoading = false;
                this.customers = res.data;
            })
            .catch(err => {
                this.fullscreenLoading = false;
                console.log(err.response.data);
            })
        },
        clearSearches() {
            this.searches = {
                name: '',
                document: ''
            };
        },
        showForm(action, customer = null) {
            if(this.modalType != action) {
                this.clearForm();
            }
            this.modalType = action;
            if(this.modalType === 'edit' && customer) {
                this.form = {
                    name: customer.name,
                    lastname: customer.lastname,
                    document: customer.document,
                    email: customer.email,
                    phone: customer.phone,
                    id: customer.id
                };
            }
            this.erros = {};
            $('#modalCustomerFormAddEdit').modal('show');
        },
        clearForm() {
            this.form = {
                name: '',
                lastname: '',
                document: '',
                email: '',
                phone: '',
                id: ''
            };
            this.errors = {};
        },
        actionStoreUpdate() {
            if(this.modalType == 'add') {
                this.storeCustomer();
            }else if(this.modalType == 'edit'){
                this.updateCustomer();
            }
        },
        storeCustomer() {
            const loading = this.$vs.loading({
                type: 'points',
                color: 'blue',
                // background: '#7a76cb',
                text: 'Cargando...'
            });
            const url = '/cmsapi/operation/customers/store';

            axios.post(url, this.form)
            .then(res => {
                loading.close();
                Swal.fire({
                    title: res.data.msg,
                    icon: "success",
                    timer: 1500,
                    showConfirmButton: false
                });
                this.getCustomers();
                $('#modalCustomerFormAddEdit').modal('hide');
                this.clearForm();
            })
            .catch(err => {
                loading.close();
                if(err.response && err.response.status == 422) {
                    this.errors = err.response.data.errors;
                }else if(err.response.data.msg_error || err.response.data.message) {
                    Swal.fire({
                        title: 'Error!',
                        text: err.response.data.msg_error ?? err.response.data.message,
                        icon: "error",
                        showCloseButton: true,
                        closeButtonColor: 'red',
                    });
                }

                console.log(err.response);
            });
        },
        updateCustomer() {
            const loading = this.$vs.loading({
                type: 'points',
                color: 'blue',
                // background: '#7a76cb',
                text: 'Cargando...'
            });
            const url = `/cmsapi/operation/customers/${this.form.id}/update`;

            axios.put(url, this.form)
            .then(res => {
                loading.close();
                Swal.fire({
                    title: res.data.msg,
                    icon: "success",
                    timer: 1500,
                    showConfirmButton: false
                });
                this.getCustomers();
                $('#modalCustomerFormAddEdit').modal('hide');
                this.clearForm();
            })
            .catch(err => {
                loading.close();
                if(err.response && err.response.status == 422) {
                    this.errors = err.response.data.errors;
                }else if(err.response.data.msg_error || err.response.data.message) {
                    Swal.fire({
                        title: 'Error!',
                        text: err.response.data.msg_error ?? err.response.data.message,
                        icon: "error",
                        showCloseButton: true,
                        closeButtonColor: 'red',
                    });
                }

                console.log(err.response);
            });
        }
    },

    computed: {
        authUserPermissions() {
            return JSON.parse(sessionStorage.getItem('listPermissionsByAuthUser'));
        }
    },

}
</script>
