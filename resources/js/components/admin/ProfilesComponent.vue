<template>
    <div class="row">
        <div class="col-md-12">
            <div class="card card-outline card-secondary">
                <div class="card-header">
                    <h1 class="card-title">Profiles</h1>
                    <a href="" class="btn btn-sm btn-success float-right" data-toggle="modal" data-target="#modal-add-new">Add New</a>
                </div>
                <div class="card-body">
                    <table id="profiles-table" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Profession</th>
                                <th>CV</th>
                                <th>Last Update</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(profile,index) in profiles" :key="profile.id">
                                <td>{{ profile.id }}</td>
                                <td>{{ profile.first_name }}</td>
                                <td>{{ profile.last_name }}</td>
                                <td>{{ profile.profession }}</td>
                                <td>
                                    <template v-if="profile.cvs.length != 0">
                                        <p v-for="cv in profile.cvs" :key="cv.id">
                                            CV Id: {{ cv.id }}
                                        </p>
                                    </template>
                                    <template v-else>
                                        -
                                    </template>
                                </td>
                                <td>
                                    <template v-if="profile.updated_at">
                                        {{ profile.updated_at }}
                                    </template>
                                    <template v-else>
                                        {{ profile.created_at }}
                                    </template>
                                </td>
                                <td class="align-content-center">
                                    <a :href="'/admin/profile/'+profile.id" class="btn btn-sm btn-primary">View</a>
                                    <a href="javascript:void(0)" class="btn btn-sm btn-danger" @click="deleteData(index)">Delete</a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="modal fade" id="modal-add-new">
            <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add new Profile</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="first_name">First Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="first_name" placeholder="Enter first name" v-model="profile.first_name">
                    </div>
                    <div class="form-group">
                        <label for="last_name">Last Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="last_name" placeholder="Enter last name" v-model="profile.last_name">
                    </div>
                    <div class="form-group">
                        <label for="profession">Profession <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="profession" placeholder="Enter profession" v-model="profile.profession">
                    </div>
                    <div class="form-group">
                        <label for="photo">Photo</label>
                        <div class="input-group">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="photo" style="cursor: pointer;">
                                <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="address">Address</label>
                        <textarea type="text" class="form-control" id="address" placeholder="Enter address" v-model="profile.address"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" placeholder="Enter email" v-model="profile.email">
                    </div>
                    <div class="form-group">
                        <label for="birth_date">Birth Date</label>
                        <input type="date" class="form-control" id="birth_date" v-model="profile.birth_date">
                    </div>
                    <div class="form-group">
                        <label for="phone">Phone</label>
                        <input type="text" class="form-control" id="phone" placeholder="Enter phone" v-model="profile.phone">
                    </div>
                    <div class="form-group">
                        <label for="gender">Gender</label>
                        <input type="text" class="form-control" id="gender" placeholder="Enter gender in string" v-model="profile.gender">
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button id="close-modal" type="button" class="btn btn-default" data-dismiss="modal" aria-label="close">Close</button>
                    <button type="button" class="btn btn-primary" v-on:click="sendNewData" data-dismiss="modal" aria-label="close">Create new profile</button>
                </div>
            </div>
            <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->
    </div>
</template>

<script>
    export default {
        data(){
            return{
                profile:{
                    first_name:'',
                    last_name:'',
                    profession:'',
                    photo:'',
                    address:'',
                    email:'',
                    birth_date:'',
                    phone:'',
                    gender:'',
                    user_id:''
                },
                profiles:[],
                profileState: [true, 'Square'], // isCircle, InnerHtml
                uri: '/admin/resource/profiles'
            }
        },
        methods: {
            tableInit(){
                // $("#profiles-table").DataTable({
                //     "responsive": true,
                //     "lengthChange": true,
                //     "autoWidth": false,
                //     "destroy": true,
                //     "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
                // }).buttons().container().appendTo('#profiles-table_wrapper .col-md-6:eq(0)');
            },
            successInit(message){                
                    this.$toastr.success(message,'Success',{
                    timeOut: 4000,
                    progressBar: true
                });
            },
            putAsyncData(data){
                this.profiles = data;
            },
            loadData(){
                axios.get(this.uri)
                .then(response=>{
                    let self = this
                    $.when(this.putAsyncData(response.data.profiles)).then(function(){
                        // self.tableInit();
                        $("#profiles-table").DataTable();
                    });
                });
            },
            resetData(){
                this.profile.first_name='',
                this.profile.last_name='',
                this.profile.profession='',
                this.profile.photo='',
                this.profile.address='',
                this.profile.email='',
                this.profile.birth_date='',
                this.profile.phone='',
                this.profile.gender='',
                this.profile.user_id=''
            },
            sendNewData(){
                let formData = new FormData();
                let photo = $('#photo')[0].files[0];
                formData.append('first_name', this.profile.first_name);
                formData.append('last_name', this.profile.last_name);
                formData.append('profession', this.profile.profession);
                if (photo){
                    formData.append('photo', photo);
                }
                formData.append('address', this.profile.address);
                formData.append('email', this.profile.email);
                formData.append('birth_date', this.profile.birth_date);
                formData.append('phone', this.profile.phone);
                formData.append('gender', this.profile.gender);
                formData.append('user_id', 1);
                axios.post(this.uri, formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                })
                .then(response=>{
                    this.loadData();
                    this.resetData();
                    this.successInit(response.data.status);
                })
                .catch(error=>{
                    toastr.error(error.data);
                });
            },
            deleteData(index){
                this.$swal({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Delete',
                    cancelButtonText: 'Cancel',
                    reverseButtons: true,
                }).then((result) =>{
                    if (result.isConfirmed){
                        axios.delete(this.uri+"/"+this.profiles[index].id)
                        .then(response => {
                            this.$delete(this.profiles, index);
                            this.$swal({
                                title: 'Deleted!',
                                text: 'Profile has been successfully deleted',
                                icon: 'success'
                            })
                            toastr.success('Profile with ID ' + this.profiles[index].id + ' has been successfully deleted')
                        }).catch(error=>{
                            toastr.error(error.data);
                        })
                    }
                });
            },
            changeImageProfileToSquare(event) {
                $('#profile-image').toggleClass('img-circle');
                if (this.profileState[0]){
                    this.profileState = [false, 'Circle'];
                } else {
                    this.profileState = [true, 'Square'];
                }
            }
        },
        mounted() {
            this.loadData();
            console.log('Component mounted.');
        }
    }
</script>
