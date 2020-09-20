<template>
    <div class="card">
        <!-- Carga de datos -->
        <div v-if="!loaded" class="overlay"><i class="fas fa-2x fa-sync-alt fa-spin"></i></div>

        <div class="card-header">
            <div class="card-tools">
                <button class="btn btn-info btn-sm">
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
                            <div class="form-group col-sm-6">
                                <label class="control-label">Nombre</label>
                                <input v-model="filterItems.name" type="text" class="form-control" name="name" placeholder="Nombre">
                            </div>
                            <div class="form-group col-sm-6">
                                <label class="control-label">Usuario</label>
                                <input v-model="filterItems.user" type="text" class="form-control" name="user" placeholder="Usuario">
                            </div>
                            <div class="form-group col-sm-6">
                                <label class="control-label">Correo</label>
                                <input v-model="filterItems.email" type="text" class="form-control" name="email" placeholder="Correo">
                            </div>
                            <div class="form-group col-sm-6">
                                <label class="control-label">Estado</label>
                                <input v-model="filterItems.state" type="text" class="form-control" name="state" placeholder="Estado">
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <div class="row">
                            <div class="col-md-4 offset-4">
                                <button class="btn btn-flat btn-info btnWidth">Buscar</button>
                                <button class="btn btn-flat btn-default btnWidth">Limpiar</button>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">Bandeja de Resultados</h3>
                    </div>

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
                                <tr>
                                    <td>
                                        <img src="#" alt="">
                                    </td>
                                    <td>Jorge BAuza</td>
                                    <td>ebauza@mobilendo.com</td>
                                    <td>ebauza</td>
                                    <td>
                                        <span class="badge badge-success">Activo</span>
                                    </td>
                                    <td>
                                        <button class="btn btn-primary btn-xs">
                                            <i class="fas fa-folder"></i> ver
                                        </button>
                                        <button class="btn btn-info btn-xs">
                                            <i class="fas fa-pencil-alt"></i> Editar
                                        </button>
                                        <button class="btn btn-success btn-xs">
                                            <i class="fas fa-key"></i> Permiso
                                        </button>
                                        <button class="btn btn-danger btn-xs">
                                            <i class="fas fa-trash"></i> Desactivar
                                        </button>
                                        <button class="btn btn-success btn-xs">
                                            <i class="fas fa-check"></i> Activar
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                    </div>

                </div>

            </div>

        </div>

    </div>
</template>

<script>
export default {
    created() {
        this.getUsers();
    },
    data() {
        return {
            users: [],
            filterItems: {
                name: '',
                user: '',
                email: '',
                state: '',
            },

            loaded: true
        }
    },
    methods: {
        getUsers() {
            const url = '/cmsapi/administration/users';
            axios.get(url, {
                params: this.filterItems
            }).then(res => {
                console.log(res);
            })
        },
        clearFilters() {
            this.filterItems = {
                name: '',
                user: '',
                email: '',
                state: '',
            };
        },
    },

}
</script>
