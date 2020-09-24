<template>
    <div class="modal fade" id="modalUserFormAddEdit" tabindex="-1" role="dialog" aria-hidden="true" >
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 v-if="modalType=='add'" class="modal-title">Nuevo Usuario</h4>
                    <h4 v-else class="modal-title">Editar Usuario</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form class="needs-validation" v-on:submit.prevent="actionStoreUpdate">
                    <div class="modal-body">

                        <div class="form-row">
                            <div class="form-group col-md-6 col-lg-4">
                                <label for="firstName" :class="['control-label', errors.firstname ? 'text-danger' : '']">Primer Nombre</label>
                                <input v-model="form.firstname" type="text" :class="['form-control', errors.firstname ? 'is-invalid' : '']" name="firstName" placeholder="Primer Nombre" required>
                                <small v-if="errors.firstname" class="form-control-feedback text-danger">
                                    {{ errors.firstname[0] }}
                                </small>
                            </div>
                            <div class="form-group col-md-6 col-lg-3">
                                <label for="secondName" :class="['control-label', errors.secondname ? 'text-danger' : '']">Segundo Nombe</label>
                                <input v-model="form.secondname" type="text" :class="['form-control', errors.secondname ? 'is-invalid' : '']" name="secondName" placeholder="Segundo Nombe">
                                <small v-if="errors.secondname" class="form-control-feedback text-danger">
                                    {{ errors.secondname[0] }}
                                </small>
                            </div>
                            <div class="form-group col-md-6 col-lg-5">
                                <label for="lastName" :class="['control-label', errors.lastname ? 'text-danger' : '']">Apellidos</label>
                                <input v-model="form.lastname" type="text" :class="['form-control', errors.lastname ? 'is-invalid' : '']" name="lastName" placeholder="Apellidos" required>
                                <small v-if="errors.lastname" class="form-control-feedback text-danger">
                                    {{ errors.lastname[0] }}
                                </small>
                            </div>
                            <div class="form-group col-md-6 col-lg-4">
                                <label for="userName" :class="['control-label', errors.username ? 'text-danger' : '']">Usuario</label>
                                <input v-model="form.username" type="text" :class="['form-control', errors.username ? 'is-invalid' : '']" name="userName" placeholder="Usuario" required>
                                <small v-if="errors.username" class="form-control-feedback text-danger">
                                    {{ errors.username[0] }}
                                </small>
                            </div>
                            <div class="form-group col-md-6 col-lg-4">
                                <label for="email" :class="['control-label', errors.email ? 'text-danger' : '']">Correo</label>
                                <input v-model="form.email" type="email" :class="['form-control', errors.email ? 'is-invalid' : '']" name="email" placeholder="correo" required>
                                <small v-if="errors.email" class="form-control-feedback text-danger">
                                    {{ errors.email[0] }}
                                </small>
                            </div>
                            <div class="form-group col-md-6 col-lg-4">
                                <label for="password" :class="['control-label', errors.password ? 'text-danger' : '']">Contraseña</label>
                                <input v-model="form.password" type="password" :class="['form-control', errors.password ? 'is-invalid' : '']" name="password" placeholder="Contraseña" :required="modalType=='add'">
                                <small v-if="errors.password" class="form-control-feedback text-danger">
                                    {{ errors.password[0] }}
                                </small>
                            </div>

                            <div class="col-12">
                                <div class="custom-file">
                                    <input type="file" @change="getFile" :class="['custom-file-input', errors.image ? 'is-invalid' : '']" id="customFileLangHTML">
                                    <label :class="['custom-file-label', errors.image ? 'text-danger' : '']" for="customFileLangHTML" data-browse="Elegir Foto">
                                        {{ (form.image ? form.image.name : 'Selecione Foto') }}
                                    </label>
                                    <small v-if="errors.image" class="form-control-feedback text-danger">
                                        {{ errors.image[0] }}
                                    </small>
                                </div>
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
            modalType: 'add', //add, edit
            form: {
                firstname: '',
                secondname: '',
                lastname: '',
                username: '',
                email: '',
                password: '',
                image: '',
                id: ''
            },
            errors: {},

            fullscreenLoading: false
        }
    },
    methods: {
        showForm(action, user = null) {
            this.modalType = action;
            if(this.modalType === 'edit' && user) {
                this.clearForm();
                this.form = {
                    firstname: user.firstname,
                    secondname: user.secondname,
                    lastname: user.lastname,
                    username: user.username,
                    email: user.email,
                    password: '',
                    image: '',
                    id: user.id
                }
            }
            $('#modalUserFormAddEdit').modal('show');
        },
        getFile(e) {
            this.form.image = e.target.files[0];
        },
        actionStoreUpdate() {
            this.fullscreenLoading = true;
            switch (this.modalType) {
                case 'add':
                    this.storeUser();
                    break;

                case 'edit':
                    this.updateUser();
                    break;
            }
        },
        storeUser() {
            const config = { headers: { 'content-type': 'multipart/form-data' } };
            let formData = new FormData;
            for (const property in this.form) {
                if(property !== 'id') {
                    formData.append(property, this.form[property]);
                }
            }

            const url = 'cmsapi/administration/users/store';
            axios.post(url, formData, config)
            .then(res => {
                this.fullscreenLoading = false;
                this.$swal({
                    title: res.data.msg,
                    type: "success",
                    timer: 1500,
                    showCloseButton: false
                });
                this.clearForm();
                $('#modalUserFormAddEdit').modal('hide');
            })
            .catch(err => {
                this.fullscreenLoading = false;
                if(err.response.data.msg_error)
                {
                    this.$swal({
                        title: 'Error!',
                        text: err.response.data.msg_error,
                        type: "error",
                        showCloseButton: true,
                        closeButtonColor: 'red',
                    });
                }
                this.errors = err.response.data.errors;
            });
        },
        clearForm() {
            this.form = {
                firstname: '',
                secondname: '',
                lastname: '',
                username: '',
                email: '',
                password: '',
                image: '',
                id: ''
            };
            this.errors = {};
        },
        updateUser() {
            const config = { headers: { 'content-type': 'multipart/form-data' } };
            let formData = new FormData;
            for (const property in this.form) {
                if(property !== 'id') {
                    formData.append(property, this.form[property]);
                }
            }

            const url = `cmsapi/administration/users/${this.form.id}/update`;
            axios.post(url, formData, config)
            .then(res => {
                this.fullscreenLoading = false;
                this.$swal({
                    title: res.data.msg,
                    type: "warning",
                    timer: 1500
                });
                this.clearForm();
                $('#modalUserFormAddEdit').modal('hide');
            })
            .catch(err => {
                this.fullscreenLoading = false;
                if(err.response.data.msg_error)
                {
                    this.$swal({
                        title: 'Error!',
                        text: err.response.data.msg_error,
                        type: "error",
                        showCloseButton: true,
                        closeButtonColor: 'red',
                    });
                }
                this.errors = err.response.data.errors;
            });
        }
    },
}
</script>

<style scope>

</style>
