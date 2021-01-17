<template>
    <div class="modal fade" id="modalOrderFormAddEdit" tabindex="-1" role="dialog" aria-hidden="true" >
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 v-if="modalType=='add'" class="modal-title">Nuevo Pedido</h4>
                    <h4 v-else class="modal-title">Editar Pedido</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>

                    <div class="modal-body">

                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-4">
                                    <form class="needs-validation" v-on:submit.prevent="storeCustomer">
                                        <div :class="['card', switch_newcustomer ? 'card-primary' : 'card-success']">
                                            <div class="card-header">
                                                <h3 class="card-title">{{ switch_newcustomer ? 'Nuevo' : 'Buscar' }} Cliente</h3>
                                            </div>

                                            <div class="card-body">
                                                <div class="form-row">

                                                    <div class="col-sm-4 col-md-12 col-lg-9 col-xl-6 mb-3">
                                                        <vs-switch v-model="switch_newcustomer" @change="clearFormCustomer">
                                                            <template #off>
                                                                <i class="fas fa-plus-square"> Nuevo</i>
                                                            </template>
                                                            <template #on>
                                                                <i class="fas fa-plus-square"> Nuevo</i>
                                                            </template>
                                                        </vs-switch>
                                                    </div>

                                                    <div class="form-group col-12">
                                                        <el-autocomplete v-if="!switch_newcustomer"
                                                            class="inline-input"
                                                            v-model="form.customer.document"
                                                            :fetch-suggestions="querySearch"
                                                            placeholder="Buscar..."
                                                            :trigger-on-focus="false"
                                                            size="mediun"
                                                            @select="handleSelect">
                                                            <i
                                                                class="el-icon-search el-input__icon"
                                                                slot="suffix">
                                                            </i>
                                                        </el-autocomplete>
                                                        <input v-else v-model="form.customer.document" type="text" :class="['form-control', errors.document ? 'is-invalid' : '']" name="document" placeholder="Documento" required>
                                                        <small v-if="errors.document" class="form-control-feedback text-danger">
                                                            {{ errors.document[0] }}
                                                        </small>
                                                    </div>
                                                    <template v-if="switch_newcustomer || form.customer.name">
                                                        <div class="form-group col-12">
                                                            <input v-model="form.customer.name" type="text" :class="['form-control', errors.name ? 'is-invalid' : '']" :disabled="!switch_newcustomer" name="name" placeholder="Nombre" required>
                                                            <small v-if="errors.name" class="form-control-feedback text-danger">
                                                                {{ errors.name[0] }}
                                                            </small>
                                                        </div>
                                                        <div class="form-group col-12">
                                                            <input v-model="form.customer.lastname" type="text" :class="['form-control', errors.lastname ? 'is-invalid' : '']" :disabled="!switch_newcustomer" name="lastname" placeholder="Apellidos" required>
                                                            <small v-if="errors.lastname" class="form-control-feedback text-danger">
                                                                {{ errors.lastname[0] }}
                                                            </small>
                                                        </div>
                                                        <div class="form-group col-12">
                                                            <input v-model="form.customer.email" type="email" :class="['form-control', errors.email ? 'is-invalid' : '']" :disabled="!switch_newcustomer" name="email" placeholder="Email">
                                                            <small v-if="errors.email" class="form-control-feedback text-danger">
                                                                {{ errors.email[0] }}
                                                            </small>
                                                        </div>
                                                        <div class="form-group col-12">
                                                            <input v-model="form.customer.phone" type="text" :class="['form-control', errors.phone ? 'is-invalid' : '']" :disabled="!switch_newcustomer" name="phone" placeholder="Teléfono">
                                                            <small v-if="errors.phone" class="form-control-feedback text-danger">
                                                                {{ errors.phone[0] }}
                                                            </small>
                                                        </div>

                                                        <div v-if="switch_newcustomer" class="form-group col-12">
                                                            <button type="submit" class="btn btn-primary btn-sm btn-block">Registrar Cliente</button>
                                                        </div>
                                                    </template>

                                                </div>
                                            </div>

                                        </div>
                                    </form>
                                </div>

                                <div class="col-md-8">
                                    <div class="card card-info">
                                        <div class="card-header">
                                            <h3 class="card-title">Productos
                                                <span v-if="listCheckProducts.length" v-text="listCheckProducts.length" class="right badge badge-dark"></span>
                                            </h3>
                                        </div>

                                        <div class="card-body table-responsive">

                                            <vs-tooltip v-if="all_products.length" not-arrow right>
                                                <vs-button border @click.prevent="addProduct()"
                                                    square
                                                    icon
                                                    color="rgb(59,222,200)"
                                                    gradient>
                                                    <i class="fas fa-plus-square"></i>
                                                </vs-button>
                                                <template #tooltip>
                                                    Agregar Producto
                                                </template>
                                            </vs-tooltip>

                                            <template v-if="listCheckProducts.length">
                                                <table class="table table-hover table-sm">
                                                    <thead>
                                                        <tr class="bg-dark">
                                                            <th>#</th>
                                                            <th>Artículo</th>
                                                            <th>Cantidad</th>
                                                            <th>Precio</th>
                                                            <th>SubTotal</th>
                                                            <th>Acción</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr v-for="(p, index) in listCheckProducts" :key="index">
                                                            <th>{{ index+1 }}</th>
                                                            <td>
                                                                <el-select @change="selectProduct(p.id, index)" v-model="p.id" filterable placeholder="Select" size="small">
                                                                    <el-option v-for="product in all_products"
                                                                        :key="product.id"
                                                                        :label="product.name"
                                                                        :value="product.id">
                                                                    </el-option>
                                                                </el-select>
                                                            </td>
                                                            <td>
                                                                <el-input-number @change="selectProduct(p.id, index)" v-model="p.quantity" size="small"
                                                                    controls-position="right"
                                                                    :min="1"
                                                                    :max="p.maxStock ? p.maxStock : 1">
                                                                </el-input-number>
                                                            </td>
                                                            <td class="text-center">{{ p.price ? '$ '+p.price : '' }}</td>
                                                            <td class="text-center">{{ p.subTotal ? '$ '+p.subTotal : '' }}</td>
                                                            <td class="text-center">
                                                                <el-tooltip class="item" effect="dark" content="Remover Producto" placement="bottom">
                                                                    <button @click="removeProduct(index)" class="btn btn-flat btn-danger btn-xs">
                                                                        <i class="fas fa-trash"></i>
                                                                    </button>
                                                                </el-tooltip>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                                <el-row :gutter="20">
                                                    <el-col :span="16">
                                                        <vs-input border v-model="form.comments" placeholder="Comentarios" />
                                                        <small v-if="errors.comments" class="form-control-feedback text-danger">
                                                            {{ errors.comments[0] }}
                                                        </small>
                                                    </el-col>
                                                    <el-col :span="8">
                                                        <strong>Total:</strong> <span v-if="totalOrder">$ {{ form.total = totalOrder }}</span>
                                                    </el-col>
                                                </el-row>
                                            </template>
                                            <div v-else class="alert alert-warning mx-2 text-center" style="margin-top: 18px;">
                                                No se ha adicionado ningún producto a la orden
                                            </div>

                                        </div>

                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                        <button v-if="totalOrder > 0 && listCheckProducts.length && form.customer.id"
                            @click.prevent="actionStoreUpdate()"
                            type="button"
                            class="btn btn-primary"
                            v-loading.fullscreen.lock="fullscreenLoading">Guardar</button>
                    </div>

            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
</template>

<script>

export default {
    mounted() {
        this.getAllCustomers();
        this.getAllProducts();
    },
    data() {
        return {
            modalType: 'add', //add, edit

            switch_newcustomer: false,
            all_customers: [],
            form: {
                customer: {
                    document: '',
                    name: '',
                    lastname: '',
                    email: '',
                    phone: '',
                    id: ''
                },
                comments: '',
                total: 0
            },
            errors: {},

            all_products: [],
            listCheckProducts: [],

            fullscreenLoading: false
        }
    },
    methods: {
        getAllCustomers() {
            const url = '/cmsapi/operation/customers/get-all-customers';

            axios.get(url)
            .then(res => {
                this.all_customers = res.data;
            });
        },
        getAllProducts() {
            const url = '/cmsapi/configuration/products/get-all-products';

            axios.get(url)
            .then(res => {
                this.all_products = res.data;
            });
        },
        querySearch(queryString, cb) {
            let links = [];
            this.all_customers.map(customer => {
                    links.push({
                        value: customer.document,
                        link: customer.id
                    });
                });

            let results = links;
            if(queryString) {
                results = links.filter((link) => {
                    return (link.value.toLowerCase().indexOf(queryString.toLowerCase()) !== -1);
                });
            }

            // call callback function to return suggestions
            cb(results);
        },
        handleSelect(item) {
            let customer = this.all_customers.find(c => c.id == item.link);
            if(customer) {
                this.form.customer = {
                    document: customer.document,
                    name: customer.name,
                    lastname: customer.lastname,
                    email: customer.email,
                    phone: customer.phone,
                    id: customer.id
                };
            }
        },
        showForm(action, order = null) {
            if(this.modalType != action) {
                this.clearFormCustomer();
                this.clearProducts();
            }
            this.modalType = action;
            if(this.modalType === 'edit' && order) {
                /* this.form = {
                    name: product.name,
                    category: product.categorie_id,
                    stock:  product.stock,
                    price: product.price,
                    description: product.description,
                    id: product.id
                }; */
            }
            this.erros = {};
            $('#modalOrderFormAddEdit').modal('show');
        },
        storeCustomer() {
            this.fullscreenLoading = true;
            const url = '/cmsapi/operation/customers/store';
            if(this.validator()) {
                axios.post(url, this.form.customer)
                .then(res => {
                    this.switch_newcustomer = false;
                    this.getAllCustomers();
                    this.getAllProducts();
                    this.fullscreenLoading = false;
                    Swal.fire({
                        title: res.data.msg,
                        icon: "success",
                        timer: 1500,
                        showConfirmButton: false
                    });
                    this.errors = {};
                    let customer = res.data.customer;
                    this.form.customer = {
                        document: customer.document,
                        name: customer.name,
                        lastname: customer.lastname,
                        email: customer.email,
                        phone: customer.phone,
                        id: customer.id
                    };
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
            }

        },
        addProduct() {
            let isRowsCompleted = true;
            this.listCheckProducts.map(p => {
                if(!p.id || !p.quantity || !p.price || !p.subTotal) {
                    isRowsCompleted = false;
                }
            });

            if(this.listCheckProducts.length < this.all_products.length && isRowsCompleted) {
                this.listCheckProducts.push({
                    id: '',
                    quantity: 1,
                    maxStock: '',
                    price: '',
                    subTotal: ''
                });
            }else {
                this.$vs.notification({
                    square: true,
                    color: 'warn',
                    position: 'top-right',
                    title: !isRowsCompleted ? 'Hay datos incompletos en los productos seleccionados'
                                            : 'Ha seleccionado ya todos los productos existentes'
                });
            }
        },
        removeProduct(index) {
            this.$delete(this.listCheckProducts, index);
        },
        selectProduct(product_id, index) {
            let msg_error = null;
            const productSelectIndex = this.listCheckProducts.findIndex((prod, i) => (prod.id == product_id && i != index));
            const product = this.all_products.find(p => p.id == product_id);

            if(productSelectIndex !== -1 && productSelectIndex != index) {
                msg_error = `La fila número ${productSelectIndex + 1} ya contiene el producto "${product.name}"`;
            } else if (product.stock < 1) {
                msg_error = `El producto selecionado no cuenta con stock disponible`;
            } else if (product){
                this.listCheckProducts[index].price = product.price;
                this.listCheckProducts[index].maxStock = product.stock;
                this.listCheckProducts[index].subTotal = parseFloat(Math.round((product.price * this.listCheckProducts[index].quantity) * 100) / 100).toFixed(2);
            }

            if (msg_error) {
                this.$vs.notification({
                    square: true,
                    color: 'warn',
                    position: 'top-right',
                    title: msg_error
                });
                this.listCheckProducts[index].id = '';
                this.listCheckProducts[index].quantity = 1;
                this.listCheckProducts[index].maxStock = '';
                this.listCheckProducts[index].price = '';
                this.listCheckProducts[index].subTotal = '';
            }
        },
        actionStoreUpdate() {
            //this.fullscreenLoading = true;
            if(this.modalType == 'add') {
                this.storeOrder();
            }else if(this.modalType == 'edit') {
                //this.updateProduct();
            }
        },
        storeOrder() {
            this.fullscreenLoading = true;
            const url = '/cmsapi/operation/orders/store';
            let data = {
                customer_id: this.form.customer.id,
                comments: this.form.comments,
                total: this.form.total,
                products: this.listCheckProducts
            }

            axios.post(url, data)
            .then(res => {
                this.$emit('updateOrderList', 'add');
                this.fullscreenLoading = false;
                Swal.fire({
                    title: res.data.msg,
                    icon: "success",
                    timer: 1500,
                    showConfirmButton: false
                });
                $('#modalOrderFormAddEdit').modal('hide');
                this.clearFormCustomer();
                this.clearProducts();
            }).catch(err => {
                this.fullscreenLoading = false;
                let msg_error = null;
                if(err.response && err.response.status == 422) {

                    this.errors = err.response.data.errors;
                    msg_error = this.errors.msg_error_validator ? this.errors.msg_error_validator[0] : null;
                } else if(err.response.data.msg_error || err.response.data.message) {
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
            });
        },
        /* updateProduct() {
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
                $('#modalOrderFormAddEdit').modal('hide');
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
        }, */
        clearFormCustomer() {
            this.form.customer = {
                document: '',
                name: '',
                lastname: '',
                email: '',
                phone: '',
                id: ''
            };
            this.errors = {};
        },
        clearProducts() {
            this.listCheckProducts = [],
            this.form.comments = '';
            this.form.total = 0;
            this.errors = {};
        },
        validator() {
            let isReady = true;
            if(this.switch_newcustomer) {
                if(!this.form.customer.email || !(/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(this.form.customer.email))) {
                    this.errors.email = ['Email es invalido'];
                    isReady = false;
                }
            }
            return isReady
        }
    },
    computed: {
        totalOrder() {
            return this.listCheckProducts.reduce((oldValue, newValue) => {
                return parseFloat(oldValue) + parseFloat(newValue.subTotal);
            }, 0);
        }
    },
}
</script>

<style scoped>

.el-autocomplete {
    width: 100% !important;
}

.vs-tooltip-content {
    width: min-content !important;
}

.el-row {
    margin-bottom: 20px;
  }
  .el-col {
    border-radius: 4px;
  }
  .bg-purple-dark {
    background: #99a9bf;
  }
  .bg-purple {
    background: #d3dce6;
  }
  .bg-purple-light {
    background: #e5e9f2;
  }
  .grid-content {
    border-radius: 4px;
    min-height: 36px;
  }
  .row-bg {
    padding: 10px 0;
    background-color: #f9fafc;
  }

</style>


