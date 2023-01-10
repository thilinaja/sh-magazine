<template>
  <div>
    <div class="py-4">
      <div class="mx-auto sm:px-6 lg:px-6">
        <div class="overflow-hidden sm:rounded-lg">
          <div class="flex flex-row justify-between mb-8">
            <h3 class="text-secondary font-bold text-title">
              Manage Magazines
            </h3>
            <!-- BUTTON-->
            <Button
              v-if="recordOptions.permissions.create"
              :field="createButton"
              @callback="addRecord()"
              class="float-right"
            />
          </div>
          <!-- TABLE -->
          <div
            class="
              overflow-hidden
              bg-white
              text-grey-dark
              shadow-xl
              sm:rounded-lg
            "
          >
            <div class="mb-8">
              <Table
                :structure="structure"
                :records="filteredRecords"
                :recordOptions="recordOptions"
                :searchOptions="searchOptions"
                @edit="editRecord"
                @delete="deleteRecord"
                @search="handleSearchOptions"
              />
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Forms -->
    <Form
      :formTitle="formTitle"
      :formSubtitle="formSubtitle"
      :closeConfirmation="closeConfirmation"
      :formErrors="formErrors"
      :visibility="isSlideInVisible"
      :structure="structure"
      :form="selectedForm"
      :actions="formActions"
      :recordOptions="recordOptions"
      @close="closeSlideIn"
      @delete="deleteRecord($event)"
      @save="save($event)"
    />
  </div>
</template>

<script>
import { defineComponent } from "vue";

import Table from "../Components/Table.vue";
import Button from "../Components/Button.vue";
import Form from "../Components/Form.vue";

export default defineComponent({
  props: {
    magazines: {
      type: Object,
      required: true,
    },
  },

  components: {
    Table,
    Button,
    Form,
  },

  data() {
    let createButton = {
      key: "button",
      label: "Create Magazine",
      placeholder: "",
      type: "Button",
      options: {},
    };

    let structure = [
      {
        key: "id",
        label: "Magazine ID",
        placeholder: "",
        type: "TextField",
        haveOptions: false,
        options: [],
        showInForm: false,
        showInList: false,
        sortable: true,
      },
      {
        key: "name",
        label: "Name",
        placeholder: "",
        type: "TextField",
        haveOptions: false,
        options: [],
        showInForm: true,
        showInList: true,
      },
      {
        key: "summary",
        label: "Summary",
        placeholder: "",
        type: "TextArea",
        haveOptions: false,
        options: [],
        showInForm: true,
        showInList: true,
      },
      {
        key: "pdf_path",
        label: "PDF Path",
        placeholder: "",
        type: "TextArea",
        haveOptions: false,
        options: [],
        showInForm: true,
        sortable: false,
        showInList: true,
        disabled: true,
        customVisibilty: this.isEdit,
      },
      {
        key: "view_count",
        label: "Total View Count",
        placeholder: "",
        type: "TextField",
        haveOptions: false,
        options: [],
        showInForm: true,
        showInList: true,
        sortable: true,
        disabled: true,
        customVisibilty: this.isEdit,
      },
      {
        key: "average_time",
        label: "Average Time Read",
        placeholder: "",
        type: "TextField",
        haveOptions: false,
        options: [],
        showInForm: true,
        showInList: true,
        sortable: true,
        disabled: true,
        customVisibilty: this.isEdit,
      },
      {
        key: "pdf",
        label: "PDF",
        placeholder: "",
        type: "FileUpload",
        haveOptions: false,
        options: [],
        showInForm: true,
        sortable: true,
        showInList: false,
        customVisibilty: this.isCreate,
      },
      {
        key: "thumbnail",
        label: "Thumbnail",
        placeholder: "",
        type: "FileUpload",
        haveOptions: false,
        options: [],
        showInForm: true,
        sortable: true,
        showInList: false,
        customVisibilty: this.isCreate,
      },
      {
        key: "uploaded_at",
        label: "Uploaded Date",
        placeholder: "",
        type: "TextField",
        haveOptions: false,
        options: [],
        showInForm: true,
        showInList: true,
        sortable: true,
        disabled: true,
        customVisibilty: this.isEdit,
      },
    ];

    let defaultForm = {
      id: "",
      name: "",
      summary: "",
      pdf: "",
      thumbnail: "",
      pdf_path: "",
      view_count: "",
      average_time: "",
      uploaded_at: "",
    };

    let formActions = {
      saveForm: true,
      saveButtonText: "",
      deleteForm: false,
      deleteButtonText: "",
    };

    let recordOptions = {
      permissions: {
        create: true,
        update: true,
        delete: true,
      },
      saveForm: true,
      deleteForm: true,
      custom: false,
      recordIds: [],
    };

    let searchOptions = {
      search: true,
      hidePagination: false,
      url: null,
      perPageCount: 10,
      sortOrder: "desc",
      sortOption: "id",
      keyword: "",
      keywordOptions: ["name"],
      filterOptions: {},
    };

    return {
      recordOptions: recordOptions,
      searchOptions: searchOptions,
      filteredRecords: this.magazines,
      isSlideInVisible: false,
      formTitle: "",
      formSubtitle:
        "All the fields are mandatory unless it is mentioned otherwise",
      closeConfirmation: "",
      formErrors: [],
      structure: structure,
      defaultForm: defaultForm,
      selectedForm: JSON.parse(JSON.stringify(defaultForm)),
      formActions: formActions,
      createButton: createButton,
    };
  },

  watch: {
    magazines: function (newMagazines, oldMagazines) {
      this.filteredRecords = newMagazines;
    },
  },

  methods: {
    save: function (data) {
      const method = data.id != "" ? "put" : "post";
      const url =
        data.id != ""
          ? route("magazines.update", data.id)
          : route("magazines.store");

      let form = this.$inertia.form(data);
      form[method](url, {
        onError: () => {
          this.formErrors = form.errors;
        },
        onSuccess: () => {
          this.selectedForm = JSON.parse(JSON.stringify(this.defaultForm));
          this.formErrors = {};
          this.closeSlideIn();

          if (method == "put") {
            this.getRecords();
          }
        },
      });
    },

    closeSlideIn: function () {
      this.selectedForm = JSON.parse(JSON.stringify(this.defaultForm));
      this.isSlideInVisible = false;
    },

    handleSearchOptions(searchOptions) {
      this.searchOptions = searchOptions;
      this.getRecords();
    },

    async getRecords() {
      let link =
        this.searchOptions.url == null
          ? "/magazines"
          : this.searchOptions.url.url;

      this.$inertia.visit(link, {
        method: "get",
        data: {
          data: this.searchOptions,
        },
        preserveState: true,
        only: ["magazines"],
      });
    },

    addRecord() {
      this.formTitle = "Create Magazine";
      this.closeConfirmation =
        "Are you sure you want to close the panel, without creating the Magazine?";
      this.isSlideInVisible = true;
      this.selectedForm = JSON.parse(JSON.stringify(this.defaultForm));
      this.formActions.deleteForm = false;
      this.formActions.saveButtonText = "Create Magazine";
    },

    editRecord(record) {
      this.formTitle = "Edit Magazine";
      this.closeConfirmation =
        "Are you sure you want to close the panel, without updating magazine's details?";
      this.selectedForm = record;
      this.isSlideInVisible = true;
      this.formActions.deleteForm = true;
      this.formActions.saveButtonText = "Save Changes";
      this.formActions.deleteButtonText = "Delete Magazine";
    },

    deleteRecord: function (record) {
      if (confirm("Are you sure you want to delete this Magazine?")) {
        this.$inertia.delete(`/magazines/${record.id}`, {
          onSuccess: () => {
            this.closeSlideIn();
            this.reloadRecords();
          },
        });
      }
    },

    isCreate() {
      if (this.selectedForm.id == "") {
        return true;
      }
      return false;
    },

    isEdit() {
      if (this.selectedForm.id != "") {
        return true;
      }
      return false;
    },
  },
});
</script>