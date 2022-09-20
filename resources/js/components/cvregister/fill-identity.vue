<template>
  <div class="card">
    <div class="card-header">
      <div class="card-title">Profile</div>
    </div>
    <div class="card-body">
      <div class="form-group">
        <label for="first_name"
          >First Name <span class="text-danger">*</span></label
        >
        <input
          type="text"
          class="form-control"
          id="first_name"
          placeholder="Enter first name"
          v-model="profile.first_name"
        />
      </div>
      <div class="form-group">
        <label for="last_name"
          >Last Name <span class="text-danger">*</span></label
        >
        <input
          type="text"
          class="form-control"
          id="last_name"
          placeholder="Enter last name"
          v-model="profile.last_name"
        />
      </div>
      <div class="form-group">
        <label for="profession"
          >Profession <span class="text-danger">*</span></label
        >
        <input
          type="text"
          class="form-control"
          id="profession"
          placeholder="Enter profession"
          v-model="profile.profession"
        />
      </div>
      <div class="form-group">
        <label for="photo">Photo</label>
        <div
          v-if="use_profile_photo == 0"
          class="form-check form-check-inline ml-3"
        >
          <input
            type="checkbox"
            @click="useProfilePhoto"
            class="form-check-input"
          />
          <label class="form-check-label" for="exampleCheck1"
            >Use profile image</label
          >
          <!-- <button @click="useProfilePhoto">Use profile image</button> -->
        </div>
        <div
          v-if="
            profile.photo != null &&
            previewImage == null &&
            use_profile_photo == 1
          "
          class="col-md-5 row"
        >
          <div class="col-md-12">
            <img
              v-bind:src="'/storage/' + profile.photo"
              v-bind:style="imgSize"
            />
          </div>
          <div class="col-md-4 mx-auto">
            <button @click="removeImage" class="btn btn-outline-secondary">
              Remove Image
            </button>
          </div>
        </div>

        <div v-if="previewImage != null" class="col-md-5 row">
          <div class="col-md-12">
            <img v-bind:src="previewImage" v-bind:style="imgSize" />
          </div>
          <div class="col-md-4 mx-auto">
            <button @click="removeImage" class="btn btn-outline-secondary">
              Remove Image
            </button>
          </div>
        </div>

        <div class="custom-file">
          <input
            class="form-control-file"
            type="file"
            id="customFile"
            style="cursor: pointer"
            accept="image/*"
            @change="onFileChange($event)"
          />
          <label class="custom-file-label" for="customFile">Choose file</label>
        </div>
      </div>
      <div class="form-group">
        <label for="address">Address</label>
        <textarea
          type="text"
          class="form-control"
          id="address"
          placeholder="Enter address"
          v-model="profile.address"
        ></textarea>
      </div>
      <div class="form-group">
        <label for="email">Email</label>
        <input
          type="email"
          class="form-control"
          id="email"
          placeholder="Enter email"
          v-model="profile.email"
        />
      </div>
      <div class="form-group">
        <label for="birth_date">Birth Date</label>
        <input
          type="date"
          class="form-control"
          id="birth_date"
          v-model="profile.birth_date"
        />
      </div>
      <div class="form-group">
        <label for="phone">Phone</label>
        <input
          type="text"
          class="form-control"
          id="phone"
          placeholder="Enter phone"
          v-model="profile.phone"
        />
      </div>
      <div class="form-group">
        <label for="gender">Gender</label>
        <input
          type="text"
          class="form-control"
          id="gender"
          placeholder="Enter gender in string"
          v-model="profile.gender"
        />
      </div>
      <div class="form-group">
        <input
          type="checkbox"
          v-model="profile.is_protected"
          class="form-check-input"
          id="is_protected"
        />
        <label class="form-check-label" for="is_protected"
          >Protect this CV</label
        >
      </div>
      <button
        type="button"
        class="btn btn-primary col-6 offset-6"
        @click="submit"
      >
        Next section
      </button>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      imgSize: {
        maxHeight: "300px",
      },
      previewImage: null,
      apiUrl: "/admin/resource",
      profile: [],
      idProf: "",
      use_profile_photo: false,
      cv_photo: null,
    };
  },
  methods: {
    useProfilePhoto() {
      this.use_profile_photo = true;
      this.cv_photo = null;
      this.previewImage = null;
    },
    removeImage() {
      this.previewImage = null;
      this.use_profile_photo = false;
      this.cv_photo = null;
    },
    putAsyncData(data) {
      this.profile = data;
      this.profile.profile_id = this.idProf;
    },
    loadProfile() {
      this.idProf = JSON.parse(localStorage.getItem("newCv")).profile_id;
      axios
        .get(this.apiUrl.concat("/profiles/" + this.idProf))
        .then((response) => {
          let self = this;
          $.when(this.putAsyncData(response.data.profile)).then(function () {});
        });
    },
    onFileChange(e) {
      const image = e.target.files[0] || e.dataTransfer.files[0];
      const reader = new FileReader();
      reader.readAsDataURL(image);
      reader.onload = (e) => {
        this.previewImage = e.target.result;
      };
      this.use_profile_photo = false;
      this.cv_photo = image;
    },
    submit() {
      let formData = new FormData();

      if (this.previewImage != null) {
        formData.append("photo", this.cv_photo);
      } else if (this.use_profile_photo == true) {
        formData.append("use_profile_photo", 1);
      }

      formData.append("first_name", this.profile.first_name);
      formData.append("last_name", this.profile.last_name);
      formData.append("profession", this.profile.profession);
      formData.append("address", this.profile.address);
      formData.append("email", this.profile.email);
      formData.append("birth_date", this.profile.birth_date);
      formData.append("phone", this.profile.phone);
      formData.append("gender", this.profile.gender);
      if (this.profile.is_protected == true) {
        formData.append("is_protected", 1);
      } else {
        formData.append("is_protected", 0);
      }
      formData.append("profile_id", this.profile.profile_id);
      formData.append("password", this.profile.password);
      formData.append("is_active", 1);

      axios
        .post(this.apiUrl.concat("/cvs"), formData)
        .then((response) => {
          const cv = response.data.cv;
          console.log(cv);
          console.log(this.profile);
          window.location.href = "/admin/CV/new/" + cv.id + "/experience";
        })
        .catch((error) => {
          console.log(error);
          console.log(this.profile);
        });
    },
  },
  mounted() {
    bsCustomFileInput.init();
    this.loadProfile();
  },
};
</script>