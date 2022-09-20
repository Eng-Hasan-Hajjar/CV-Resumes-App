<template>
  <div class="col-md-12">
    <div class="card card-outline card-secondary">
      <div class="card-header">
        <h1 class="card-title">CVs</h1>
        <a
          v-bind:href="'/admin/CV/new'"
          class="btn btn-sm btn-success float-right"
          >Add New</a
        >
      </div>
      <div class="card-body">
        <table id="cvs-table" class="table table-bordered table-hover">
          <thead>
            <tr>
              <th>No.</th>
              <th>Id</th>
              <th>First Name</th>
              <th>Profession</th>
              <th>Email</th>
              <th>Active</th>
              <th>Protected</th>
              <th>Last Update</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(cv, index) in cvs" :key="cv.id">
              <td>{{ index + 1 }}</td>
              <td>{{ cv.id }}</td>
              <td>{{ cv.first_name }}</td>
              <td>{{ cv.profession }}</td>
              <td>
                <template v-if="cv.email">
                  {{ cv.email }}
                </template>
                <template v-else> - </template>
              </td>
              <td>
                <template v-if="cv.is_active == 1"> Active </template>
                <template v-else> Deactived </template>
              </td>
              <td>
                <template v-if="cv.is_protected == 1"> Protected </template>
                <template v-else> Unprotected </template>
              </td>
              <td>
                <template v-if="cv.updated_at">
                  {{ moment(cv.updated_at) }}
                </template>
                <template v-else>
                  {{ moment(cv.created_at) }}
                </template>
              </td>
              <td class="align-content-center">
                <!-- Show modal to update CV -->
                <a
                  v-bind:href="'/admin/CV/' + cv.id"
                  class="btn btn-sm btn-info"
                  >View</a
                >
                <a href="" class="btn btn-sm btn-warning">Update</a>
                <!-- Url to display template cv -->
                <a
                  v-if="cv.is_protected"
                  v-bind:href="'/CV/first/' + cv.uuid"
                  class="btn btn-sm btn-primary"
                  >View First Template</a
                >
                <a
                  v-else
                  v-bind:href="'/CV/first/' + cv.id"
                  class="btn btn-sm btn-primary"
                  >View First Template</a
                >
                <a
                  v-if="cv.is_protected"
                  v-bind:href="'/CV/second/' + cv.uuid"
                  class="btn btn-sm btn-primary"
                  >View Second Template</a
                >
                <a
                  v-else
                  v-bind:href="'/CV/second/' + cv.id"
                  class="btn btn-sm btn-primary"
                  >View Second Template</a
                >
                <!-- Deactive a cv -->
                <button class="btn btn-sm btn-danger" @click="deleteCV(cv)">
                  Deactive
                </button>
              </td>
            </tr>
          </tbody>
        </table>
        <div
          v-if="showDeleteSuccess"
          class="alert alert-success alert-dismissible fade show"
          role="alert"
          id="alertDeleteSuccess"
        >
          CV dengan id {{ lastDeleted.id }} berhasil dihapus!
          <button type="button" class="close" @click="hideAlert()">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
      </div>
    </div>
  </div>
  <!-- Modal add/update ditaruh sini  -->
  <!-- add update kasih tambah row buat tambah custom field -->
</template>
<script>
import moment from "moment";
export default {
  data() {
    return {
      cvs: [],
      profileState: [true, "Square"], // isCircle, InnerHtml
      uri: "/admin/resource/cvs",
      showDeleteSuccess: false,
      lastDeleted: "",
    };
  },
  methods: {
    hideAlert() {
      this.showDeleteSuccess = false;
    },
    deleteCV(cv) {
      axios.delete(this.uri.concat("/" + cv.id)).then((reponse) => {
        this.lastDeleted = cv;
        this.loadData();
        this.showDeleteSuccess = true;
      });
    },
    putAsyncData(data) {
      this.cvs = data;
    },
    loadData() {
      axios.get(this.uri).then((response) => {
        let self = this;
        $.when(this.putAsyncData(response.data.cvs));
      });
    },
    moment(date) {
      return moment(date).format("DD-MMM-YYYY");
    },
  },
  mounted() {
    this.loadData();
  },
};
</script>
