<template>
  <div class="card overflow-auto">
    <div class="card-header">
      <div class="card-title">Skill</div>
    </div>
    <div class="card-body">
      <table class="table text-center">
        <thead>
          <tr>
            <th></th>
            <th
              v-for="(attribute_line, index) in attribute_lines"
              v-bind:key="index"
            >
              {{ attribute_line }}
              <i
                class="fas fa-times fa-xs"
                @click="deleteAttr(index)"
                :style="{ color: 'darkgray' }"
              ></i>
            </th>
            <th v-if="showInputAttributeLine">
              <form @submit.prevent="addAttributeLine">
                <input
                  type="text"
                  name="newAttributeLine"
                  v-model="newAttributeLine"
                />
              </form>
            </th>
            <th>
              <button
                class="btn btn-primary"
                @click="toggleShowInputAttributeLine()"
              >
                <div v-if="showInputAttributeLine">
                  <i class="fas fa-check"></i>
                </div>
                <div v-else>
                  <i class="fas fa-plus"></i>
                </div>
              </button>
            </th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(record, recIndex) in records" v-bind:key="record.order">
            <td>{{ recIndex + 1 }}.</td>
            <td
              v-for="(attribute, attrIndex) in attribute_lines"
              v-bind:key="attrIndex"
            >
              <input
                type="text"
                v-model="
                  record.custom_field_record_attribute_line_values[attrIndex]
                "
              />
            </td>
          </tr>
          <tr>
            <td>
              <button class="btn btn-primary" @click="addRecord">
                <i class="fas fa-plus"></i>
              </button>
            </td>
          </tr>
        </tbody>
      </table>
      <button
        type="button"
        class="btn btn-primary col-6 offset-6 mt-3"
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
      records: [],
      attribute_lines: ["Name", "Description"],
      showInputAttributeLine: false,
      newAttributeLine: "",
      apiUrl: "/admin/resource",
    };
  },
  methods: {
    toggleShowInputAttributeLine() {
      if (this.showInputAttributeLine == true) {
        this.addAttributeLine();
      } else {
        this.showInputAttributeLine = true;
      }
    },
    addAttributeLine() {
      if (this.newAttributeLine != "") {
        this.attribute_lines.push(this.newAttributeLine);
        this.newAttributeLine = "";
      }
      this.showInputAttributeLine = false;
    },
    deleteAttr(index) {
      this.attribute_lines.splice(index, 1);
      this.records.forEach((record) => {
        record.custom_field_record_attribute_line_values.splice(index, 1);
      });
    },
    addRecord() {
      this.records.push({
        custom_field_record_attribute_line_values: [],
      });
    },

    submit() {
      let formData = new FormData();
      formData.append("nama", "Skill");
      formData.append("order", 3);
      formData.append("cv_id", window.location.pathname.split("/")[4]);
      formData.append("is_active", 1);

      let customFieldAttributeLines = [];
      this.attribute_lines.forEach((element, index) => {
        let nama, order, is_active;
        nama = element;
        order = index + 1;
        is_active = true;
        let el = {
          nama: nama,
          order: order,
          is_active: is_active,
        };
        customFieldAttributeLines.push(el);
      });

      formData.append(
        "customFieldAttributeLines",
        JSON.stringify(customFieldAttributeLines)
      );

      let customFieldRecords = [];
      this.records.forEach((record, index) => {
        let order, custom_field_record_attribute_line_values, compiledRecord;
        order = index + 1;
        compiledRecord = {
          order: order,
          custom_field_record_attribute_line_values: [],
        };
        record.custom_field_record_attribute_line_values.forEach(
          (val, index) => {
            let value, custom_field_attribute_line_id;
            value = val;
            custom_field_attribute_line_id = this.attribute_lines[index];
            let el = {
              value: value,
              custom_field_attribute_line_id: custom_field_attribute_line_id,
            };
            compiledRecord["custom_field_record_attribute_line_values"].push(
              el
            );
          }
        );
        customFieldRecords.push(compiledRecord);
      });

      formData.append("customFieldRecords", JSON.stringify(customFieldRecords));

      axios
        .post(this.apiUrl.concat("/custom-field"), formData)
        .then((response) => {
          const cv = response.data.customFieldCategory;
          console.log(cv);
          window.location.href = "/admin/CV/new/" + cv.cv_id + "/extra";
        })
        .catch((error) => {
          console.log(error);
        });
    },
  },
};
</script>