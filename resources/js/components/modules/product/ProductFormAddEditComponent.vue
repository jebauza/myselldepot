<template>
    <div class="modal fade" id="modalProductFormAddEdit" tabindex="-1" role="dialog" aria-hidden="true" >
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 v-if="modalType=='add'" class="modal-title">Nuevo Producto</h4>
                    <h4 v-else class="modal-title">Editar Producto</h4>
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
                                <label for="category" :class="['control-label', errors.category ? 'text-danger' : '']">Categoría</label>
                                <div :class="['row', errors.category ? 'bg-danger py-2' : '']">
                                    <el-select v-model="form.category" filterable class="col-12" placeholder="Seleccione una categoría">
                                        <el-option v-for="category in allCategories" :key="category.id"
                                            :label="category.name"
                                            :value="category.id">
                                        </el-option>
                                    </el-select>
                                </div>
                                <small v-if="errors.category" class="form-control-feedback text-danger">
                                    {{ errors.category[0] }}
                                </small>
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="stock" :class="['control-label', errors.stock ? 'text-danger' : '']">Stock</label>
                                <input v-model="form.stock" type="number" :class="['form-control', errors.stock ? 'is-invalid' : '']" name="stock" placeholder="Stock" required>
                                <small v-if="errors.stock" class="form-control-feedback text-danger">
                                    {{ errors.stock[0] }}
                                </small>
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="price" :class="['control-label', errors.price ? 'text-danger' : '']">Precio</label>
                                <input v-model="form.price" type="text" :class="['form-control', errors.price ? 'is-invalid' : '']" name="price" placeholder="10.95" required>
                                <small v-if="errors.price" class="form-control-feedback text-danger">
                                    {{ errors.price[0] }}
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
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
</template>

<script>

export default {
    mounted() {
        this.getAllCategories();
    },
    data() {
        return {
            modalType: 'add', //add, edit

            allCategories: [],
            form: {
                name: '',
                category: '',
                stock: 1,
                price: '',
                description: '',
                id: ''
            },
            errors: {},

            fullscreenLoading: false
        }
    },
    methods: {
        getAllCategories() {
            const url = `/cmsapi/configuration/categories/get-all-categories`;
            axios.get(url)
            .then(res => {
                this.allCategories = res.data;
            });
        },
        showForm(action, product = null) {
            if(this.modalType != action) {
                this.clearForm();
            }
            this.modalType = action;
            if(this.modalType === 'edit' && product) {
                this.form = {
                    name: product.name,
                    category: product.categorie_id,
                    stock:  product.stock,
                    price: product.price,
                    description: product.description,
                    id: product.id
                };
            }
            this.erros = {};
            $('#modalProductFormAddEdit').modal('show');
        },
        actionStoreUpdate() {
            this.fullscreenLoading = true;
            if(this.modalType == 'add') {
                this.storeProduct();
            }else if(this.modalType == 'edit') {
                this.updateProduct();
            }
        },
        storeProduct() {
            const url = '/cmsapi/configuration/products/store';

            axios.post(url, this.form)
            .then(res => {
                this.fullscreenLoading = false;
                Swal.fire({
                    title: res.data.msg,
                    icon: "success",
                    timer: 1500,
                    showConfirmButton: false
                });
                this.$emit('updateProductList', 'add');
                $('#modalProductFormAddEdit').modal('hide');
                this.clearForm();
            }).catch(err => {
                this.fullscreenLoading = false;
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
            });
        },
        updateProduct() {
            const url = `/cmsapi/configuration/products/${this.form.id}/update`;

            axios.put(url, this.form)
            .then(res => {
                this.fullscreenLoading = false;
                Swal.fire({
                    title: res.data.msg,
                    icon: "success",
                    timer: 1500,
                    showConfirmButton: false
                });
                this.$emit('updateProductList', 'edit');
                $('#modalProductFormAddEdit').modal('hide');
                this.clearForm();
            }).catch(err => {
                this.fullscreenLoading = false;
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
            });
        },
        clearForm() {
            this.form = {
                name: '',
                category: '',
                stock: 1,
                price: '',
                description: '',
                id: ''
            };
            this.errors = {};
        }
    },
}
</script>


