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
                                <input v-model="form.username" type="text" :class="['form-control', errors.username ? 'is-invalid' : '']" name="userName" placeholder="Usuario">
                                <small v-if="errors.username" class="form-control-feedback text-danger">
                                    {{ errors.username[0] }}
                                </small>
                            </div>
                            <div class="form-group col-md-6 col-lg-4">
                                <label for="email" :class="['control-label', errors.email ? 'text-danger' : '']">Correo</label>
                                <input v-model="form.email" type="email" :class="['form-control', errors.email ? 'is-invalid' : '']" name="email" placeholder="correo">
                                <small v-if="errors.email" class="form-control-feedback text-danger">
                                    {{ errors.email[0] }}
                                </small>
                            </div>
                            <div class="form-group col-md-6 col-lg-4">
                                <label for="password" :class="['control-label', errors.password ? 'text-danger' : '']">Contraseña</label>
                                <input v-model="form.password" type="password" :class="['form-control', errors.password ? 'is-invalid' : '']" name="password" placeholder="Contraseña">
                                <small v-if="errors.password" class="form-control-feedback text-danger">
                                    {{ errors.password[0] }}
                                </small>
                            </div>

                            <div class="col-12">
                                <div class="custom-file">
                                    <input type="file" @change="getFile" :class="['custom-file-input', errors.file ? 'is-invalid' : '']" id="customFileLangHTML">
                                    <label :class="['custom-file-label', errors.file ? 'text-danger' : '']" for="customFileLangHTML" data-browse="Elegir Foto">
                                        {{ (form.file ? form.file.name : 'Selecione Foto') }}
                                    </label>
                                    <small v-if="errors.file" class="form-control-feedback text-danger">
                                        {{ errors.file[0] }}
                                    </small>
                                </div>
                            </div>

                        </div>

                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Guardar</button>
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
                file: null
            },
            errors: {}
        }
    },
    methods: {
        showForm(action) {
            this.modalType = action;
            $('#modalUserFormAddEdit').modal('show');
        },
        getFile(e) {
            this.form.file = e.target.files[0];
        },
        actionStoreUpdate() {
            switch (this.modalType) {
                case 'add':
                    this.storeUser();
                    break;

                case 'edit':
                    console.log('edit');
                    break;
            
                default:
                    break;
            }

            $('#modalUserFormAddEdit').modal('hide');
        },
        storeUser() {
            console.log('storeUser');
        }
    },
}
</script>

<style scope>

</style>
