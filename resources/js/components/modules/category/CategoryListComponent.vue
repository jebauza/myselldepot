<template>
    <div class="card">
        <!-- Carga de datos -->
        <div v-if="!loaded" class="overlay"><i class="fas fa-2x fa-sync-alt fa-spin"></i></div>

        <div class="card-header">
            <div v-if="authUserPermissions.includes('users.create')" class="card-tools">
                <button @click="showForm('add')" class="btn btn-info btn-sm">
                    <i class="fas fa-plus-square"> Nueva Categoría</i>
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
                            <div class="form-group col-sm-4 col-md-4">
                                <label class="control-label">Nombre</label>
                                <input v-model="searches.name" type="text" class="form-control" name="name" placeholder="Nombre">
                            </div>
                            <div class="form-group col-10 col-sm-6 col-md-7 col-lg-7">
                                <label class="control-label">Descripción</label>
                                <input v-model="searches.description" type="text" class="form-control" name="description" placeholder="Descripción">
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
                            <span v-show="categories.total" class="right badge badge-dark">{{ categories.total }}</span>
                        </h3>
                    </div>

                    <div v-if="categories.data.length" class="card-body">
                        <div class="card-body table-responsive">
                            <table class="table table-hover table-head-fixed text-nowrap projects">
                                <thead>
                                    <tr>
                                        <th>Nombre</th>
                                        <th>Descripción</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="category in categories.data" :key="category.id">
                                        <td v-text="category.name"></td>
                                        <td v-text="category.description"></td>
                                        <td>
                                            <button @click="showForm('edit', category)" class="btn btn-flat btn-info btn-xs" title="Editar">
                                                <i class="fas fa-pencil-alt"></i>
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <pagination :class="'mt-2'" :align="'center'" :limit="5" :data="categories" @pagination-change-page="getCategories"></pagination>
                        </div>
                    </div>
                    <div v-else class="alert alert-warning mx-2 text-center" style="margin-top: 18px;">
                        No hay ningún elemento para mostrar
                    </div>
                </div>

                <div class="modal fade" id="modalCategoryFormAddEdit" tabindex="-1" role="dialog" aria-hidden="true" >
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 v-if="modalType=='add'" class="modal-title">Nueva Categoría</h4>
                                <h4 v-else class="modal-title">Editar Categoría</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            <form class="needs-validation" v-on:submit.prevent="actionStoreUpdate">
                                <div class="modal-body">

                                    <div class="form-row">

                                        <div class="form-group col-12">
                                            <label for="name" :class="['control-label', errors.name ? 'text-danger' : '']">Nombre</label>
                                            <input v-model="form.name" type="text" :class="['form-control', errors.name ? 'is-invalid' : '']" name="name" placeholder="Nombre" required>
                                            <small v-if="errors.name" class="form-control-feedback text-danger">
                                                {{ errors.name[0] }}
                                            </small>
                                        </div>
                                        <div class="form-group col-12">
                                            <label for="description" :class="['control-label', errors.description ? 'text-danger' : '']">Descripción</label>
                                            <textarea v-model="form.description" :class="['form-control', errors.description ? 'is-invalid' : '']" name="description"></textarea>
                                            <small v-if="errors.description" class="form-control-feedback text-danger">
                                                {{ errors.description[0] }}
                                            </small>
                                        </div>

                                    </div>
                                </div>
                                <div class="modal-footer justify-content-between">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                                    <button type="submit" class="btn btn-primary" v-loading.fullscreen.lock="fullscreenLoading">Guardar</button>
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
        this.getCategories();
    },
    watch: {
        'searches.name': function (newValue, oldValue) {
            this.getCategories();
        },
        'searches.description': function (newValue, oldValue) {
            this.getCategories();
        },
    },
    data() {
        return {
            categories: {data:[]},
            searches: {
                name: '',
                description: ''
            },

            modalType: 'add',
            form: {
                name: '',
                description: '',
                id: ''
            },
            errors: {},

            fullscreenLoading: false,
            loaded: false
        }
    },
    methods: {
        getCategories(page = 1) {
            this.loaded = false;
            const url = `/cmsapi/configuration/categories?page=${page}`;
            axios.get(url, {
                params: this.searches
            }).then(res => {
                this.categories = res.data;
                this.loaded = true;
            })
        },
        clearSearches() {
            this.searches = {
                name: '',
                username: ''
            };
        },
        showForm(action, category = null) {
            if(this.modalType != action) {
                this.clearForm();
            }
            this.modalType = action;
            if(this.modalType === 'edit' && category) {
                this.form = {
                    name: category.name,
                    description: category.description,
                    id: category.id
                }
            }
            this.erros = {};
            $('#modalCategoryFormAddEdit').modal('show');
        },
        clearForm() {
            this.form = {
                name: '',
                description: '',
                id: ''
            };
            this.errors = {};
        },
        actionStoreUpdate() {
            if(this.modalType == 'add') {
                this.storeCategory();
            }else if(this.modalType == 'edit'){
                this.updateCategory();
            }
        },
        storeCategory() {
            this.fullscreenLoading = true;
            const url = '/cmsapi/configuration/categories/store';

            axios.post(url, this.form)
            .then(res => {
                this.fullscreenLoading = false;
                Swal.fire({
                    title: res.data.msg,
                    icon: "success",
                    timer: 1500,
                    showConfirmButton: false
                });
                this.getCategories();
                $('#modalCategoryFormAddEdit').modal('hide');
                this.clearForm();
            })
            .catch(err => {
                this.fullscreenLoading = false;
                if(err.response.data.msg_error)
                {
                    Swal.fire({
                        title: 'Error!',
                        text: err.response.data.msg_error,
                        icon: "error",
                        showCloseButton: true,
                        closeButtonColor: 'red',
                    });
                }
                this.errors = err.response.data.errors;
            })
        },
        updateCategory() {
            this.fullscreenLoading = true;
            const url = `/cmsapi/configuration/categories/${this.form.id}/update`;

            axios.put(url, this.form)
            .then(res => {
                this.fullscreenLoading = false;
                Swal.fire({
                    title: res.data.msg,
                    icon: "success",
                    timer: 1500,
                    showConfirmButton: false
                });
                this.getCategories();
                $('#modalCategoryFormAddEdit').modal('hide');
                this.clearForm();
            })
            .catch(err => {
                this.fullscreenLoading = false;
                if(err.response.data.msg_error)
                {
                    Swal.fire({
                        title: 'Error!',
                        text: err.response.data.msg_error,
                        icon: "error",
                        showCloseButton: true,
                        closeButtonColor: 'red',
                    });
                }
                this.errors = err.response.data.errors;
            })
        }
    },

    computed: {
        authUserPermissions() {
            return JSON.parse(sessionStorage.getItem('listPermissionsByAuthUser'));
        }
    },

}
</script>
