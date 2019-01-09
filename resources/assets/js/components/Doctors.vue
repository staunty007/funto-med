<template>
    <div>
        <section class="content">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                        <h3 class="card-title">Doctors</h3>
                        <div class="card-tools"><button @click="newModal" class="btn btn-success">Add Doctor <i class="fas fa-user-md"></i></button></div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>S/N</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Field</th>
                                <th>Created</th>
                                <th>Modify</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="staff in staffs" :key="staff.id">
                                <td>{{ staff.id}}</td>
                                <td>{{ staff.name}}</td>
                                <td>{{ staff.email}}</td>
                                <td>{{ staff.field}}</td>
                                <td>{{ staff.created_at | regDate}}</td>
                            <td>
                                <button class="btn btn-info" @click="editModal(staff)"><i class="fas fa-edit"></i></button>
                                <button class="btn btn-danger" @click="deleteStaff(staff.id)"><i class="fas fa-trash"></i></button>
                            </td>
                            </tr>
                            </tbody>
                            <tfoot>
                            <tr>
                                <th>S/N</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Field</th>
                                <th>Created</th>
                                <th>Modify</th>
                            </tr>
                            </tfoot>
                        </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
          <!-- /.card -->
                </div>
            </div>
        </section>

        <!-- Modal -->
            <div class="modal fade" id="addNew" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 v-show="!editmode" class="modal-title" id="exampleModalLabel">Add Staff</h5>
                    <h5 v-show="editmode" class="modal-title" id="exampleModalLabel">Update Staff</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            <form @submit.prevent="editmode ? updateStaff() : createStaff()">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="inputAddress2">Full Name</label>
                        <input type="text" v-model="form.name" class="form-control" id="inputName" placeholder="Full Name" :class="{'is-invalid':form.errors.has('name')}">
                        <has-error :form="form" field="name"></has-error>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                        <label for="inputEmail4">Email</label>
                        <input type="email" v-model="form.email" class="form-control" id="inputEmail4" placeholder="Email" :class="{'is-invalid':form.errors.has('email')}">
                        <has-error :form="form" field="email"></has-error>
                        </div>
                        <div class="form-group col-md-6">
                        <label for="inputPassword4">Password</label>
                        <input type="password" v-model="form.password" class="form-control" id="inputPassword4" placeholder="Password" :class="{'is-invalid':form.errors.has('password')}">
                        <has-error :form="form" field="password"></has-error>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                        <label for="inputField">Field</label>
                        <input type="text" v-model="form.field" class="form-control" id="inputField" :class="{'is-invalid':form.errors.has('field')}">
                        <has-error :form="form" field="field"></has-error>
                        </div>
                        <div class="form-group col-md-6">
                        <label for="inputType">User Type</label>
                        <select v-model="form.user_type" class="form-control">
                            <option value="1">Administrator</option>
                            <option value="2" selected>Doctor</option>
                            <option value="3">Non-Admin Staff</option>
                        </select>
                        </div>
                    </div>
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    <button v-show="!editmode" type="submit" class="btn btn-primary">Create</button>
                    <button v-show="editmode" type="submit" class="btn btn-success">Update</button>
                </div>
            </form>
                </div>
            </div>
            </div>
    </div>
</template>

<script>
    export default {
        
        data() {
            return {
                editmode: false,
                staffs: {},
                form : new Form({
                    id:'',
                    name:'',
                    email:'',
                    password:'',
                    user_type:'',
                    field:''
                })
            }
        },
        methods:{
            updateStaff(){
                this.$Progress.start()
                this.form.put('api/staff/' + this.form.id)
                .then(() => {
                    $('#addNew').modal('hide');
                    Fire.$emit('AfterCreate');
                    swal(
                    'Updated!',
                    'Staff has been updated.',
                    'success'
                    )
    
                    this.$Progress.finish()
                })
                .catch(() => {
                    this.$Progress.fail();
                })
            },
            newModal(){
                this.editmode = false;
                this.form.reset();
                $('#addNew').modal('show');
            },
            editModal(user){
                this.editmode = true;
                this.form.reset();
                $('#addNew').modal('show');
                this.form.fill(user);
            },
            deleteStaff(id){
                swal({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                        if(result.value) {
                            this.form.delete('api/staff/'+id).then(() => {
                                swal(
                                'Deleted!',
                                'Staff has been deleted.',
                                'success'
                                )
                            Fire.$emit('AfterCreate');
                       
                            }).catch(() => {
                                swal("Failed","There was something Wrong","warning");
                            })
                        }
                    })
            },
            loadStaffs() {
                axios.get('api/staff').then(({data}) => (this.staffs = data.data));
            },
            createStaff() {
                this.$Progress.start()
                this.form.post('api/staff')
                .then(() => {
                    this.$Progress.finish()
                    $('#addNew').modal('hide');
                    this.form.reset();
                    Fire.$emit('AfterCreate');
                    toast({
                    type: 'success',
                    title: 'Doctor Created Successfully'
                    })
                })
                .catch(() => {
                this.$Progress.fail()
                })
            }
        },
        created() {
            this.loadStaffs();
            Fire.$on('AfterCreate',() => {
                this.loadStaffs();
            });
        }
    }
    
</script>