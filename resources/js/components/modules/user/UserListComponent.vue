<template>
    <div class="card">
        <!-- Carga de datos -->
        <div v-if="!loaded" class="overlay"><i class="fas fa-2x fa-sync-alt fa-spin"></i></div>

        <div class="card-header">
            <div class="card-tools">
                <button @click="openModalAddEdit('add')" class="btn btn-info btn-sm">
                    <i class="fas fa-plus-square"> Nuevo Usuario</i>
                </button>
            </div>
        </div>

        <div class="card-body">
            <div class="container-fluid">

                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">Criterio de Busqueda</h3>
                    </div>

                    <div class="card-body">
                        <div class="form-row">
                            <div class="form-group col-sm-6 col-md-4 col-lg-3">
                                <label class="control-label">Nombre</label>
                                <input v-model="searches.name" type="text" class="form-control" name="name" placeholder="Nombre">
                            </div>
                            <div class="form-group col-sm-6 col-md-4 col-lg-3">
                                <label class="control-label">Usuario</label>
                                <input v-model="searches.username" type="text" class="form-control" name="username" placeholder="Usuario">
                            </div>
                            <div class="form-group col-sm-6 col-md-4 col-lg-3">
                                <label class="control-label">Correo</label>
                                <input v-model="searches.email" type="text" class="form-control" name="email" placeholder="Correo">
                            </div>
                            <div class="form-group col-sm-4 col-md-4 col-lg-2">
                                <label class="control-label">Estado</label>
                                <input v-model="searches.state" type="text" class="form-control" name="state" placeholder="Estado">
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
                            <span v-show="users.total" class="right badge badge-dark">{{ users.total }}</span>
                        </h3>
                    </div>

                    <div v-if="users.data.length" class="card-body">
                        <div class="card-body table-responsive">
                            <table class="table table-hover table-head-fixed text-nowrap projects">
                                <thead>
                                    <tr>
                                        <th>Foto</th>
                                        <th>Nombre</th>
                                        <th>Correo</th>
                                        <th>Usuario</th>
                                        <th>Estado</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(user, index) in users.data" :key="user.id">
                                        <td>
                                            <template>
                                                <div class="user-block">
                                                    <img v-if="user.profile_image && user.profile_image.url" :src="user.profile_image.url" :alt="user.username" class="profile-avatar-img img-fluid img-circle">
                                                    <img v-else src="/img/avatar.png" :alt="user.username" class="profile-avatar-img img-fluid img-circle">
                                                </div>
                                            </template>
                                        </td>
                                        <td v-text="user.fullName"></td>
                                        <td v-text="user.email"></td>
                                        <td v-text="user.username"></td>
                                        <td>
                                            <span v-if="user.state == 'A'" class="badge badge-success">Activo</span>
                                            <span v-else class="badge badge-danger">Inactivo</span>
                                        </td>
                                        <td>
                                            <button class="btn btn-primary btn-xs" title="ver">
                                                <i class="fas fa-folder"></i>
                                            </button>
                                            <button class="btn btn-info btn-xs" title="Editar">
                                                <i class="fas fa-pencil-alt"></i>
                                            </button>
                                            <button class="btn btn-success btn-xs" title="Permiso">
                                                <i class="fas fa-key"></i>
                                            </button>
                                            <button class="btn btn-danger btn-xs" title="Desactivar">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                            <button class="btn btn-success btn-xs" title="Activar">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <pagination :class="'mt-2'" :align="'center'" :limit="5" :data="users" @pagination-change-page="getUsers"></pagination>
                        </div>
                    </div>
                    <div v-else class="alert alert-warning mx-2 text-center" style="margin-top: 18px;">
                        No hay ningún elemento para mostrar
                    </div>
                </div>

                <user-form-add-edit ref="userFormAddEdit"></user-form-add-edit>

            </div>

        </div>

    </div>
</template>

<script>
import UserFormAddEdit from './UserFormAddEditComponent';

export default {
    components: {UserFormAddEdit},
    created() {
        this.getUsers();
    },
    watch: {
        'searches.name': function (newValue, oldValue) {
            this.getUsers();
        },
        'searches.username': function (newValue, oldValue) {
            this.getUsers();
        },
        'searches.email': function (newValue, oldValue) {
            this.getUsers();
        },
        'searches.state': function (newValue, oldValue) {
            this.getUsers();
        }
    },
    data() {
        return {
            users: {data:[]},
            searches: {
                name: '',
                username: '',
                email: '',
                state: '',
            },

            loaded: false
        }
    },
    methods: {
        getUsers(page = 1) {
            this.loaded = false;
            const url = `/cmsapi/administration/users?page=${page}`;
            axios.get(url, {
                params: this.searches
            }).then(res => {
                this.users = res.data;
                this.loaded = true;
            })
        },
        clearSearches() {
            this.searches = {
                name: '',
                username: '',
                email: '',
                state: '',
            };
        },
        openModalAddEdit(action) {
            this.$refs.userFormAddEdit.showForm(action);
        }
    },

}
</script>
