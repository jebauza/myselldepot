<template>
    <div class="modal fade" id="modalRoleFormAddEdit" tabindex="-1" role="dialog" aria-hidden="true" >
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 v-if="modalType=='add'" class="modal-title">Nuevo Rol</h4>
                    <h4 v-else class="modal-title">Editar Rol</h4>
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
                                <label for="url" :class="['control-label', errors.url ? 'text-danger' : '']">Url</label>
                                <input v-model="form.url" type="text" :class="['form-control', errors.url ? 'is-invalid' : '']" name="url" placeholder="Url" required>
                                <small v-if="errors.url" class="form-control-feedback text-danger">
                                    {{ errors.url[0] }}
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
    data() {
        return {
            modalType: 'add',
            form: {
                name: '',
                url: '',
                id: ''
            },
            errors: {},

            fullscreenLoading: false
        }
    },
    methods: {
        showForm(action, role = null) {
            if(this.modalType != action) {
                this.clearForm();
            }
            if(this.modalType == 'edit') {
                this.form = {
                    name: role.name,
                    url: '',
                    id: role.id
                };
            }
            this.erros = {};
            $('#modalRoleFormAddEdit').modal('show');
        },
        actionStoreUpdate() {
            this.fullscreenLoading = true;
            switch (this.modalType) {
                case 'add':
                    //this.storeUser();
                    break;

                case 'edit':
                    //this.updateUser();
                    break;
            }
        },
        /* storeUser() {
            const config = { headers: { 'content-type': 'multipart/form-data' } };
            let formData = new FormData;
            for (const property in this.form) {
                if(property !== 'id') {
                    formData.append(property, this.form[property]);
                }
            }

            const url = '/cmsapi/administration/users/store';
            axios.post(url, formData, config)
            .then(res => {
                this.fullscreenLoading = false;
                Swal.fire({
                    title: res.data.msg,
                    icon: "success",
                    timer: 1500,
                    showConfirmButton: false
                });
                this.$emit('updateUserList', 'add');
                $('#modalUserFormAddEdit').modal('hide');
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
            });
        },
        updateUser() {
            const config = { headers: { 'content-type': 'multipart/form-data' } };
            let formData = new FormData;
            for (const property in this.form) {
                if(property !== 'id') {
                    formData.append(property, this.form[property]);
                }
            }

            const url = `/cmsapi/administration/users/${this.form.id}/update`;
            axios.post(url, formData, config)
            .then(res => {
                this.fullscreenLoading = false;
                Swal.fire({
                    title: res.data.msg,
                    icon: "success",
                    timer: 1500,
                    showConfirmButton: false
                });
                this.$emit('updateUserList', 'edit');
                $('#modalUserFormAddEdit').modal('hide');
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
            });
        }, */
        clearForm() {
            this.form = {
                name: '',
                url: '',
                id: ''
            };
            this.errors = {};
        }
    },
}
</script>

