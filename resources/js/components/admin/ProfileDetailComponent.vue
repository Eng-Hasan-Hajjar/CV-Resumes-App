<template>
    <div class="row">
        <div class="col-md-8 order-1 order-md-0">
            <div class="card card-outline card-secondary">
                <div class="card-header">
                    <h1 class="card-title">Profile</h1>
                    <button id="toggle-edit-button" class="btn btn-sm btn-success float-right" @click="toggleEdit()">Edit</button>
                    <button id="trigger-update-profile-button" class="btn btn-sm btn-primary float-right ml-1" style="display:none" @click="triggerUpdateProfile()">Save</button>
                    <button id="toggle-cancel-edit-button" class="btn btn-sm btn-secondary float-right" style="display:none" @click="toggleEdit()">Cancel</button>
                </div>
                <div class="card-body">
                    <div id="profile-data" class="row">
                        <div class="col-md-12">
                            <span class="font-weight-bold">Biodata</span>
                        </div>
                        <div class="col-md-6">
                            <span class="font-weight-normal">First Name</span>
                            <h5>{{ profile.first_name }}</h5>
                        </div>
                        <div class="col-md-6">
                            <span class="font-weight-normal">Last Name</span>
                            <h5>{{ profile.last_name }}</h5>
                        </div>
                        <div class="col-md-6">
                            <span class="font-weight-normal">Birth Date</span>
                            <h5>
                                <template v-if="profile.birth_date">
                                    {{ profile.birth_date }}
                                </template>
                                <template v-else>
                                    -
                                </template>
                            </h5>
                        </div>
                        <div class="col-md-6">
                            <span class="font-weight-normal">Gender</span>
                            <h5>
                                <template v-if="profile.gender">
                                    {{ profile.gender }}
                                </template>
                                <template v-else>
                                    -
                                </template>
                            </h5>
                        </div>
                        <div class="col-md-6">
                            <span class="font-weight-normal">Profession</span>
                            <h5>
                                <template v-if="profile.profession">
                                    {{ profile.profession }}
                                </template>
                                <template v-else>
                                    -
                                </template>
                            </h5>
                        </div>
                        <div class="col-md-12 mt-3">
                            <span class="font-weight-bold">Contact</span>
                        </div>
                        <div class="col-md-6">
                            <span class="font-weight-normal">Email</span>
                            <h5>
                                <template v-if="profile.email">
                                    {{ profile.email }}
                                </template>
                                <template v-else>
                                    -
                                </template>
                            </h5>
                        </div>
                        <div class="col-md-6">
                            <span class="font-weight-normal">Phone</span>
                            <h5>
                                <template v-if="profile.phone">
                                    {{ profile.phone }}
                                </template>
                                <template v-else>
                                    -
                                </template>
                            </h5>
                        </div>
                        <div class="col-md-12">
                            <span class="font-weight-normal">Address</span>
                            <h5>
                                <template v-if="profile.address">
                                    {{ profile.address }}
                                </template>
                                <template v-else>
                                    -
                                </template>
                            </h5>
                        </div>
                    </div>
                    <div id="profile-edit" class="row" style="display:none">
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="first_name">First Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="first_name" placeholder="Enter first name" v-model="updateProfile.first_name">
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="last_name">Last Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="last_name" placeholder="Enter last name" v-model="updateProfile.last_name">
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                                <div class="form-group">
                                <label for="profession">Profession <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="profession" placeholder="Enter profession" v-model="updateProfile.profession">
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="address">Address</label>
                                <textarea type="text" class="form-control" id="address" placeholder="Enter address" v-model="updateProfile.address"></textarea>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" id="email" placeholder="Enter email" v-model="updateProfile.email">
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="birth_date">Birth Date</label>
                                <input type="date" class="form-control" id="birth_date" v-model="updateProfile.birth_date">
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="phone">Phone</label>
                                <input type="text" class="form-control" id="phone" placeholder="Enter phone" v-model="updateProfile.phone">
                            </div>
                        </div>
                        <div class="col-12 col-md-6"><div class="form-group">
                                <label for="gender">Gender</label>
                                <input type="text" class="form-control" id="gender" placeholder="Enter gender in string" v-model="updateProfile.gender">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 order-0 order-md-1">
            <div class="card card-outline card-secondary">
                <div class="card-header">
                    <h1 class="card-title">Photo</h1>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-8 offset-2 text-center custom-col-image-wrapper custom-wrapper-1x1 p-0">
                            <template v-if="profile.photo">
                                <img id="profile-image" class="mx-auto img-circle custom-image-wrapped border-secondary p-1"
                                    v-bind:src="'/storage/'+profile.photo"
                                    alt="User profile picture"
                                    style="border: 3px solid; transition: border-radius .3s ease">
                            </template>
                            <template v-else>
                                <img id="profile-image" class="mx-auto img-circle custom-image-wrapped border-secondary p-1"
                                    v-bind:src="'https://img.icons8.com/carbon-copy/100/000000/no-image.png'"
                                    alt="User profile picture"
                                    style="border: 3px solid; transition: border-radius .3s ease">
                            </template>
                        </div>
                        <div class="col-12 mt-4">
                            <div class="row">
                                <div class="col-4">
                                    <button class="btn btn-default" v-on:click="changeImageProfileToSquare(this)">{{ profileState[1] }}</button>
                                </div>
                                <div class="col-4">
                                    <input id="photo-profile-input-file" type="file" accept="image/*" class="d-none" @change="updatePhotoProfile">
                                    <button class="btn btn-primary" @click="openPhotoProfileInput()">Change</button>
                                </div>
                                <div class="col-4">
                                    <button class="btn btn-danger" @click="triggerRemovePhotoProfile()">Remove</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-8 order-2">
            <div class="card card-outline card-secondary">
                <div class="card-header">
                    <h1 class="card-title">Profile Attribute Line</h1>
                    <button id="toggle-edit-attribute-line-button" class="btn btn-sm btn-success float-right ml-1" @click="toggleEditAttributeLine()">Edit</button>
                    <button id="toggle-add-attribute-line-button" class="btn btn-sm btn-primary float-right"  data-toggle="modal" data-target="#modal-add-new">Add</button>
                    <button id="toggle-cancel-add-attribute-line-button" class="btn btn-sm btn-secondary float-right" style="display:none" @click="toggleAddAttributeLine()">Cancel</button>
                    <button id="trigger-update-attribute-line-button" class="btn btn-sm btn-primary float-right ml-1" :style="profileAttributeLineTrashList.length == 0 ? isEditAttributeLine == true ? '' : 'display:none' : 'display:none'" @click="triggerUpdateAttributeLine()">Save</button>
                    <button v-if="profileAttributeLineTrashList.length!=0" class="btn btn-sm btn-danger float-right ml-1" :style="profileAttributeLineTrashList.length == 0 ? 'display:none' : ''" @click="triggerDeleteAttributeLine()">Delete selected</button>
                    <button id="toggle-cancel-edit-attribute-line-button" class="btn btn-sm btn-secondary float-right" style="display:none" @click="toggleEditAttributeLine()">Cancel</button>
                </div>
                <div class="card-body">
                    <div id="profile-attribute-line-data" class="row">
                        <div class="col-md-12">
                            <span class="font-weight-bold">Attribute Line</span>
                        </div>
                        <template v-if="dataLoaded">
                            <template v-if="profile.profile_attribute_line.length">
                                <template v-for="attributeLine in profile.profile_attribute_line">
                                    <div class="col-md-12" :key="attributeLine.id">
                                        <span class="font-weight-normal">{{ attributeLine.name }}</span> <span class="float-right">Order {{attributeLine.order}}</span>
                                        <h5>{{ attributeLine.value }}</h5>
                                    </div>
                                </template>
                            </template>
                            <template v-else>
                                <div class="col-md-12">
                                    -
                                </div>
                            </template>
                        </template>
                    </div>
                    <div id="profile-attribute-line-edit" class="row" style="display:none">
                        <template v-if="dataLoaded">
                            <template v-if="updateAttributeLine.length">
                                <template v-for="attributeLine in updateAttributeLine">
                                    <div class="col-12 col-md-4">
                                        <div class="form-group">
                                            <label for="address">Name</label>
                                            <input type="text" class="form-control" placeholder="Enter address" v-model="attributeLine.name"></input>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-4">
                                        <div class="form-group">
                                            <label for="address">Value</label>
                                            <input type="text" class="form-control" placeholder="Enter address" v-model="attributeLine.value"></input>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-2">
                                        <div class="form-group">
                                            <label for="address">Order</label>
                                            <input type="number" class="form-control" placeholder="Enter address" v-model="attributeLine.order"></input>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-2">
                                        <div class="form-group">
                                            <label for="address">Delete</label>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input delete-checked" @change="triggerToTrash(attributeLine.id)" style="cursor:pointer">
                                            </div>
                                        </div>
                                    </div>
                                </template>
                            </template>
                            <template v-else>
                                <div class="col-md-12">
                                    -
                                </div>
                            </template>
                        </template>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="modal-add-new">
            <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add new Attribute Line</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" @click="resetNewProfileAttributeLineData">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12 col-md-4">
                            <div class="form-group">
                                <label for="first_name">Name<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" placeholder="Enter name" v-model="newAttributeLine.name">
                            </div>
                        </div>
                        <div class="col-12 col-md-4">
                            <div class="form-group">
                                <label for="last_name">Value <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" placeholder="Enter value" v-model="newAttributeLine.value">
                            </div>
                        </div>
                        <div class="col-12 col-md-4">
                            <div class="form-group">
                                <label for="profession">Order <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" placeholder="Enter order" v-model="newAttributeLine.order">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button id="close-modal" type="button" class="btn btn-default" data-dismiss="modal" aria-label="close" @click="resetNewProfileAttributeLineData">Close</button>
                    <button type="button" class="btn btn-primary" v-on:click="sendNewProfileAttributeLine" data-dismiss="modal" aria-label="close">Create new profile</button>
                </div>
            </div>
            <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
    </div>
</template>

<script>
    export default {
        props: ['profileId'],
        data(){
            return{
                dataLoaded: false,
                isEdit: false,
                isEditAttributeLine: false,
                profile:{},
                updateProfile:{},
                updateAttributeLine:[],
                newAttributeLine:{},
                profileAttributeLineTrashList: [],
                profileState: [true, 'Square'], // isCircle, InnerHtml
                uri: '/admin/resource/profiles/'+this.profileId,
            }
        },
        methods: {
            loadData(){
                axios.get(this.uri)
                .then(response=>{
                    this.profile = response.data.profile;
                    this.dataLoaded = true;
                });
            },
            updatePhotoProfile(){
                let photo = $('#photo-profile-input-file')[0].files[0];

                let formData = new FormData();

                formData.append("_method", 'PATCH');

                if (photo) {
                    formData.append('status', 'update-photo');
                    formData.append('photo', photo);
                } else formData.append('status', 'remove-photo');

                axios.post(this.uri, formData, {
                    headers: {
                        'Description-Type': 'multipart/form-data'
                    }
                }).then(response=>{
                    $('#photo-profile-input-file').val(''); // Reset data
                    this.loadData(); 
                    if (response.data.error) this.failInit(response.data.status);
                    else this.successInit(response.data.status);
                })
            },
            sendUpdateProfile(){
                let formData = new FormData();

                formData.append("_method", 'PATCH');

                formData.append('status', 'update-profile');
                
                formData.append('first_name', this.updateProfile.first_name);
                formData.append('last_name', this.updateProfile.last_name);
                formData.append('profession', this.updateProfile.profession);
                formData.append('address', this.updateProfile.address);
                formData.append('email', this.updateProfile.email);
                formData.append('birth_date', this.updateProfile.birth_date);
                formData.append('phone', this.updateProfile.phone);
                formData.append('gender', this.updateProfile.gender);
                formData.append('user_id', 1);

                axios.post(this.uri, formData, {
                    headers: {
                        'Description-Type': 'multipart/form-data'
                    }
                }).then(response=>{
                    this.resetUpdateProfileData();
                    this.loadData();
                    this.successInit(response.data.status);
                    this.toggleEdit();
                });
            },
            sendUpdateProfileAttributeLine(){
                let formData = new FormData();

                formData.append("_method", 'PATCH');

                formData.append('profile_attribute_lines', JSON.stringify(this.updateAttributeLine));

                axios.post(this.uri+'/profile-attribute-line', formData, {
                    headers: {
                        'Description-Type': 'multipart/form-data'
                    }
                }).then(response=>{
                    this.loadData();
                    this.successInit(response.data.status);
                    this.toggleEditAttributeLine();
                }).catch(error=>{
                    for (var key in error.response.data.detail){
                        this.failInit(error.response.data.detail[key])
                    }
                });
            },
            sendDeleteProfileAttributeLine(){
                let formData = new FormData();

                formData.append("_method", 'DELETE');

                formData.append('profile_attribute_lines_id', JSON.stringify(this.profileAttributeLineTrashList));

                axios.post(this.uri+'/profile-attribute-line', formData, {
                    headers: {
                        'Description-Type': 'multipart/form-data'
                    }
                }).then(response=>{
                    this.loadData();
                    this.successInit(response.data.status);
                    this.toggleEditAttributeLine();
                }).catch(error=>{
                    for (var key in error.response.data.detail){
                        this.failInit(error.response.data.detail[key])
                    }
                });
            },
            sendNewProfileAttributeLine(){
                let formData = new FormData();

                formData.append('name', this.newAttributeLine.name);
                formData.append('value', this.newAttributeLine.value);
                formData.append('order', this.newAttributeLine.order);
                formData.append('profile_id', this.profileId);

                axios.post(this.uri+'/profile-attribute-line', formData, {
                    headers: {
                        'Description-Type': 'multipart/form-data'
                    }
                }).then(response=>{
                    this.loadData();
                    this.successInit(response.data.status);
                    this.resetNewProfileAttributeLineData();
                }).catch(error=>{
                    for (var key in error.response.data.detail){
                        this.failInit(error.response.data.detail[key])
                    }
                });
            },
            triggerUpdateProfile(){
                this.$swal({
                    title: 'Are you sure?',
                    text: "Previous data will be replaced with current data",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Submit',
                    cancelButtonText: 'Cancel',
                    reverseButtons: true,
                }).then((result)=>{
                    if (result.isConfirmed){
                        this.sendUpdateProfile();
                    }
                });
            },
            triggerUpdateAttributeLine(){
                this.$swal({
                    title: 'Are you sure?',
                    text: "Previous data will be replaced with current data",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Submit',
                    cancelButtonText: 'Cancel',
                    reverseButtons: true,
                }).then((result)=>{
                    if (result.isConfirmed){
                        this.sendUpdateProfileAttributeLine();
                    }
                });
            },
            triggerDeleteAttributeLine(){
                this.$swal({
                    title: 'Are you sure?',
                    text: "Data will be deleted (soft deleted though)",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Delete',
                    cancelButtonText: 'Cancel',
                    reverseButtons: true,
                }).then((result)=>{
                    if (result.isConfirmed){
                        this.sendDeleteProfileAttributeLine();
                    }
                });
            },
            resetUpdateProfileData(){
                this.updateProfile = {};
            },
            resetNewProfileAttributeLineData(){
                this.newAttributeLine = {};
            },
            openPhotoProfileInput(){
                $('#photo-profile-input-file').click()
            },
            triggerRemovePhotoProfile(){
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
                        this.updatePhotoProfile();
                    }
                });
            },
            successInit(message){                
                    this.$toastr.success(message,'Success',{
                    timeOut: 4000,
                    progressBar: true
                });
            },
            failInit(message){                
                    this.$toastr.error(message,'Fail',{
                    timeOut: 4000,
                    progressBar: true
                });
            },
            changeImageProfileToSquare(event) {
                $('#profile-image').toggleClass('img-circle');
                if (this.profileState[0]){
                    this.profileState = [false, 'Circle'];
                } else {
                    this.profileState = [true, 'Square'];
                }
            },
            toggleEdit(){
                if(this.isEdit){
                    $('#profile-data').show('slow');
                    $('#profile-edit').hide('slow');
                    $('#toggle-edit-button').show();
                    $('#toggle-cancel-edit-button').hide();
                    $('#trigger-update-profile-button').hide();
                    this.isEdit = false;
                } else {
                    this.updateProfile = JSON.parse(JSON.stringify(this.profile, function(key,val){
                        return (val == null) ? "" : val
                    }));
                    $('#profile-data').hide('slow');
                    $('#profile-edit').show('slow');
                    $('#toggle-edit-button').hide();
                    $('#toggle-cancel-edit-button').show();
                    $('#trigger-update-profile-button').show();
                    this.isEdit = true;
                }
            },
            toggleEditAttributeLine(){
                if(this.isEditAttributeLine){
                    $('#profile-attribute-line-data').show('slow');
                    $('#profile-attribute-line-edit').hide('slow');
                    $('#toggle-edit-attribute-line-button').show();
                    $('#toggle-add-attribute-line-button').show();
                    $('#toggle-cancel-edit-attribute-line-button').hide();
                    $('#trigger-update-attribute-line-button').hide();
                    this.isEditAttributeLine = false;
                    this.profileAttributeLineTrashList = [];
                    $('.delete-checked').prop('checked', false);
                } else {
                    let self = this;
                    $.when(this.updateAttributeLine = JSON.parse(JSON.stringify(this.profile.profile_attribute_line))).then(
                        function(){
                            $('#profile-attribute-line-data').hide('slow');
                            $('#profile-attribute-line-edit').show('slow');
                            $('#toggle-edit-attribute-line-button').hide();
                            $('#toggle-add-attribute-line-button').hide();
                            $('#toggle-cancel-edit-attribute-line-button').show();
                            $('#trigger-update-attribute-line-button').show();
                            self.isEditAttributeLine = true;
                        }
                    )
                }
            },
            triggerToTrash(id){
                let index = this.profileAttributeLineTrashList.indexOf(id);
                if (index<0) this.profileAttributeLineTrashList.push(id);
                else this.profileAttributeLineTrashList.splice(index,1);
            }
        },
        mounted() {
            this.loadData();
            console.log('Component mounted.')
        }
    }
</script>
