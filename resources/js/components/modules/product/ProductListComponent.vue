<template>
    <div class="card">
        <!-- Carga de datos -->
        <div v-if="!loaded" class="overlay"><i class="fas fa-2x fa-sync-alt fa-spin"></i></div>

        <div class="card-header">
            <div class="card-tools">
                <button v-if="authUserPermissions.includes('products.store')" @click="openModalAddEdit('add')"
                    class="btn btn-info btn-sm">
                    <i class="fas fa-plus-square"> Nuevo Producto</i>
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
                            <div class="form-group col-sm-6">
                                <label class="control-label">Nombre</label>
                                <input v-model="searches.name" type="text" class="form-control" name="name" placeholder="Nombre">
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="permissions" :class="['control-label']">Categorias</label>
                                <multiselect
                                    v-model="searches.categories"
                                    :options="allCategories"
                                    placeholder="Categorias"
                                    label="name"
                                    track-by="id"
                                    :multiple="true"
                                    :close-on-select="false"
                                    :clear-on-select="false"
                                    :preserve-search="true">
                                </multiselect>
                            </div>
                            <div class="form-group col-10 col-sm-10">
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
                            <span v-show="products.total" class="right badge badge-dark">{{ products.total }}</span>
                        </h3>
                    </div>

                    <div v-if="products.data.length" class="card-body">
                        <div class="card-body table-responsive">
                            <table class="table table-hover table-head-fixed text-nowrap projects">
                                <thead>
                                    <tr>
                                        <th>Nombre</th>
                                        <th>Descripción</th>
                                        <th>Stock</th>
                                        <th>Precio</th>
                                        <th>Categoría</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(product) in products.data" :key="product.id">
                                        <td v-text="product.name"></td>
                                        <td v-text="product.description"></td>
                                        <td v-text="product.stock"></td>
                                        <td v-text="product.price"></td>
                                        <td>{{ product.category ? product.category.name : '' }}</td>

                                        <td>
                                            <button v-if="authUserPermissions.includes('products.update')" @click="openModalAddEdit('edit', product)"
                                                class="btn btn-flat btn-info btn-xs" title="Editar">
                                                <i class="fas fa-pencil-alt"></i>
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <pagination :class="'mt-2'" :align="'center'" :limit="5" :data="products" @pagination-change-page="getProducts"></pagination>
                        </div>
                    </div>
                    <div v-else class="alert alert-warning mx-2 text-center" style="margin-top: 18px;">
                        No hay ningún elemento para mostrar
                    </div>
                </div>

                <product-form-add-edit ref="productFormAddEdit" @updateProductList="updateProductList"></product-form-add-edit>

            </div>

        </div>

    </div>
</template>

<script>
import Multiselect from 'vue-multiselect';
import ProductFormAddEdit from './ProductFormAddEditComponent';

export default {
    components: {Multiselect,ProductFormAddEdit},
    created() {
        this.getProducts();
    },
    watch: {
        'searches.name': function (newValue, oldValue) {
            this.getProducts();
        },
        'searches.description': function (newValue, oldValue) {
            this.getProducts();
        },
        'searches.categories': function (newValue, oldValue) {
            this.getProducts();
        }
    },
    data() {
        return {
            products: {data:[]},

            allCategories: [],
            searches: {
                name: '',
                description: '',
                categories: []
            },

            fullscreenLoading: false,
            loaded: false
        }
    },
    methods: {
        getProducts(page = 1) {
            this.loaded = false;
            const url = `/cmsapi/configuration/products?page=${page}`;

            const {name, description, categories} = this.searches;
            axios.get(url, {
                params: {
                    name: name,
                    description: description,
                    categories: categories.map(item => item.id)
                }
            }).then(res => {
                this.getAllCategories();
                this.products = res.data;
                this.loaded = true;
            })
        },
        getAllCategories() {
            const url = `/cmsapi/configuration/categories/get-all-categories`;
            axios.get(url)
            .then(res => {
                this.allCategories = res.data;
            });
        },
        clearSearches() {
            this.searches = {
                name: '',
                description: '',
                categories: []
            };
        },
        openModalAddEdit(action, product = null) {
            this.$refs.productFormAddEdit.showForm(action, product);
        },
        updateProductList(action = null) {
            this.getProducts(this.products.current_page ?? 1 );
        },

    },

    computed: {
        authUserPermissions() {
            return JSON.parse(sessionStorage.getItem('listPermissionsByAuthUser'));
        }
    },

}
</script>

<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
