<template>
  <div class="col-md-12">
    <div class="row" v-bind:style="styleRow">
      <div
        v-for="profile in profiles"
        :key="profile.id"
        class="card ml-3 d-inline-block"
        style="width: 30vw"
      >
        <div class="card-body">
          <div class="row">
            <div
              class="col-4 mx-auto custom-col-image-wrapper custom-wrapper-1x1"
            >
              <template v-if="profile.photo">
                <img
                  id="profile-image"
                  class="mx-auto img-fluid img-circle custom-image-wrapped border-secondary p-1"
                  :src="'/storage/' + profile.photo"
                  alt="User profile picture"
                  style="border: 1px solid; transition: border-radius 0.3s ease"
                />
              </template>
              <template v-else>
                <img
                  id="profile-image"
                  class="mx-auto img-fluid img-circle custom-image-wrapped border-secondary p-1"
                  v-bind:src="'https://img.icons8.com/carbon-copy/100/000000/no-image.png'"
                  alt="User profile picture"
                  style="border: 1px solid; transition: border-radius 0.3s ease"
                />
              </template>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12 text-center mt-2">
              {{ profile.first_name }} {{ profile.last_name }}
            </div>
          </div>
          <div class="row">
            <div class="col-md-12 mx-auto">
              <table class="table">
                <thead></thead>
                <tbody>
                  <tr>
                    <td>Profession</td>
                    <td>{{ profile.profession ? profile.profession : "-" }}</td>
                  </tr>
                  <tr>
                    <td>Email</td>
                    <td>{{ profile.email ? profile.email : "-" }}</td>
                  </tr>
                  <tr>
                    <td>Address</td>
                    <td>{{ profile.address ? profile.address : "-" }}</td>
                  </tr>
                  <tr>
                    <td>Phone</td>
                    <td>{{ profile.phone ? profile.phone : "-" }}</td>
                  </tr>
                  <tr v-if="profile.gender">
                    <td>Gender</td>
                    <td>{{ profile.gender }}</td>
                  </tr>
                  <tr v-if="profile.birth_date">
                    <td>Birth Date</td>
                    <td>{{ profile.birth_date }}</td>
                  </tr>
                  <tr
                    v-for="attribute in profile.profile_attribute_lines"
                    :key="attribute.id"
                  >
                    <td>{{ attribute.name }}</td>
                    <td>{{ attribute.value }}</td>
                  </tr>
                  <tr>
                    <td colspan="2" class="text-center">
                      <button
                        type="submit"
                        class="btn btn-success"
                        v-on:click="updateForm('profile_id', profile.id)"
                        data-toggle="modal"
                        data-target="#modal-confirmation"
                      >
                        Select profile
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

    <div class="modal fade" id="modal-confirmation">
      <div class="modal-dialog modal-md">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Select profile</h5>
            <button
              type="button"
              class="close"
              data-dismiss="modal"
              aria-label="Close"
            >
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body text-center">
            <p>Select profile as a base?</p>
          </div>
          <div class="modal-footer">
            <button
              id="close-modal"
              type="button"
              class="btn btn-danger"
              data-dismiss="modal"
              aria-label="close"
            >
              No
            </button>
            <a v-bind:href="'/admin/CV/new/identity'" class="btn btn-success">
              Yes
            </a>
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
  data() {
    return {
      styleRow: {
        display: "block",
        overflowX: "auto",
        whiteSpace: "nowrap",
      },
      newCv: [],
      profiles: [],
      uri: "/admin/resource/profiles",
    };
  },
  methods: {
    putAsyncData(data) {
      this.profiles = data;
    },
    loadData() {
      axios.get(this.uri).then((response) => {
        let self = this;
        $.when(this.putAsyncData(response.data.profiles));
      });
    },
    updateForm(input, value) {
      this.newCV = value;

      let storedCv = this.openStorage();
      if (!storedCv) storedCv = {};

      storedCv[input] = value;
      this.saveStorage(storedCv);
    },
    saveStorage(form) {
      localStorage.setItem("newCv", JSON.stringify(form));
    },
    openStorage() {
      return JSON.parse(localStorage.getItem("newCv"));
    },
  },
  mounted() {
    this.loadData();
  },
  created() {
    const storedCv = this.openStorage();
    if (storedCv) {
      this.newCv = { ...this.newCv, ...storedCv };
    }
  },
};
</script>