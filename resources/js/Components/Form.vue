<template>
  <SidePanel :visibility="visibility" @close="closeSlide()" :width="formWidth">
    <div class="sticky top-0 z-50 bg-grey-light-200 p-6">
      <h2 class="text-2xl font-bold text-secondary" id="slide-over-title">
        {{ formTitle }}
      </h2>
      <h4 class="text-sm font-normal text-grey-dark" id="slide-over-title">
        {{ formSubtitle }}
      </h4>
      <button
        v-if="scheduledUpdate"
        @click="showScheduledUpdate()"
        class="text-sm font-small text-gray-900"
        id="slide-over-title"
      >
        You have a scheduled update for this record.
      </button>
    </div>

    <div class="mt-6 relative flex-1 px-4 sm:px-6">
      <div v-for="field in fields" :key="field['key']">
        <div
          v-if="showField(field)"
          class="
            flex flex-col
            text-grey-dark text-body
            font-normal
            space-y-2
            pt-4
          "
        >
          <label for="label">{{ field.label }}</label>

          <div v-if="field.type !== 'Table'">
            <component
              :is="field.type"
              :field="field"
              :disabled="disableField(field)"
              :placeholder="field.placeholder"
              :errors="getFieldError(field)"
              :data.sync="form[field.key]"
              @update:data="form[field.key] = $event"
              @onChange:data="observeChanges(field, $event)"
              @callback="fieldCallback(field.callback)"
            />
          </div>

          <div v-else>
            <Table
              :structure="field.options.structure"
              :records="form[field.key]"
              :recordOptions="field.options.recordOptions"
              :searchOptions="field.options.searchOptions"
              @edit="field.options.edit"
              @delete="field.options.delete"
            />
          </div>

          <InputError :message="getFieldError(field)" />
        </div>
      </div>

      <div
        class="flex flex-col space-y-2 pt-4 mt-4"
        v-if="actions.deleteForm == true"
      >
        <AlertStripe
          v-if="allowAction('delete')"
          :header="actions.deleteButtonText"
          :message="''"
          :variation="'delete'"
          @callback="deleteData(form)"
          class="
            bg-secondary bg-opacity-5
            text-left
            font-bold
            text-error
            border-0
            cursor-pointer
          "
        />
      </div>

      <div
        class="flex sticky bottom-0 z-50 bg-lightBg p-2 justify-center"
        v-if="actions.saveForm == true"
      >
        <Button
          v-if="allowAction('save')"
          :field="getSaveButtonObject()"
          :disabled="isDisabled"
          @callback="saveData(form)"
          class="self-center mx-auto my-4"
        />
      </div>
      <div
        class="flex sticky bottom-0 z-50 bg-lightBg p-2 justify-center"
        v-if="actions.customButton == true"
      >
        <Button
          v-if="allowAction('custom')"
          :field="getCustomButtonObject()"
          :disabled="isDisabled"
          @callback="customAction(form)"
          class="self-center mx-auto my-4"
        />
      </div>
    </div>
  </SidePanel>
</template>

<script>
import { defineComponent } from "vue";
import SidePanel from "./SidePanel.vue";
import TextField from "./TextField.vue";
import InputError from "./InputError.vue";
import Button from "./Button.vue";
import Table from "./Table.vue";
import TextArea from "./TextArea.vue";
import FileUpload from "./FileUpload.vue";

export default defineComponent({
  components: {
    SidePanel,
    TextField,
    InputError,
    Button,
    Table,
    TextArea,
    FileUpload,
  },

  props: {
    formTitle: {
      type: String,
      required: true,
    },
    formSubtitle: {
      type: String,
    },
    closeConfirmation: {
      type: [String, Boolean],
    },
    scheduledUpdate: {
      type: Boolean,
    },
    formErrors: {
      type: Object,
    },
    visibility: {
      type: Boolean,
      required: true,
    },
    structure: {
      type: Array,
      required: true,
    },
    form: {
      type: Object,
      required: true,
    },
    actions: {
      type: Object,
      required: true,
    },
    recordOptions: {
      type: Object,
      required: true,
    },
    formWidth: {
      type: String,
    },
  },

  data() {
    let fields = this.getFields();

    const defaultForm = JSON.parse(JSON.stringify(this.form));
    return {
      fields: fields,
      defaultForm: defaultForm,
    };
  },

  watch: {
    form: function (newForm, oldForm) {
      this.defaultForm = JSON.parse(JSON.stringify(newForm));
      this.fields = this.getFields();
    },
    formWidth: function (newWidth, oldWidth) {
      this.width = newWidth;
    },
  },

  emits: ["close", "save", "delete", "custom", "scheduledUpdate"],

  methods: {
    closeSlide() {
      let showConfirmation = this.enableForm;

      let valid = false;
      if (showConfirmation && this.closeConfirmation) {
        if (!this.compareArrays(this.form, this.defaultForm)) {
          if (confirm(this.closeConfirmation)) {
            valid = true;
          }
        } else {
          valid = true;
        }
      } else {
        valid = true;
      }

      if (valid) {
        this.$emit("close");
      }
    },

    saveData(data) {
      this.$emit("save", data);
    },

    customAction(data) {
      this.$emit("custom", data);
    },

    showScheduledUpdate() {
      this.$emit("scheduledUpdate");
    },

    deleteData(data) {
      this.$emit("delete", data);
    },

    fieldCallback(fieldCallback) {
      fieldCallback();
    },

    compareArrays(form, defaultForm) {
      return JSON.stringify(form) === JSON.stringify(defaultForm);
    },

    getFieldError(field) {
      if (this.formErrors) {
        let key = field.key;
        if (field.validateKey) {
          key = field.validateKey;
        }
        return this.formErrors[key];
      }
      return "";
    },

    allowAction(type) {
      let valid = true;

      if (type == "save") {
        valid = this.enableForm;

        if (this.recordOptions.saveForm) {
          if (this.recordOptions.recordIds.indexOf(this.form.id) !== -1) {
            valid = false;
          }
        }
      }

      if (type == "delete") {
        if (this.checkPermission("delete")) {
          if (this.recordOptions.deleteForm) {
            if (this.recordOptions.recordIds.indexOf(this.form.id) !== -1) {
              valid = false;
            }
          }
        } else {
          valid = false;
        }
      }

      return valid;
    },

    getSaveButtonObject() {
      let button = {
        key: "button",
        label: this.actions.saveButtonText,
        placeholder: "",
        type: "Button",
        options: {},
      };

      return button;
    },

    getCustomButtonObject() {
      let button = {
        key: "button",
        label: this.actions.customButtonText,
        placeholder: "",
        type: "Button",
        options: {},
      };

      return button;
    },

    checkFormType() {
      if (this.form.hasOwnProperty("created_at")) {
        return "update";
      }
      return "create";
    },

    checkPermission(type) {
      if (!this.recordOptions.permissions[type]) {
        return false;
      }

      return true;
    },

    showField(field) {
      if (field.triggerCondition) {
        let fieldTrigger = field.triggerCondition;
        let item = fieldTrigger(this.form, field);
        return item;
      }
      return true;
    },

    disableField(field) {
      let disable = false;

      if (!this.enableForm) {
        disable = true;
      }

      if (field.disabled) {
        disable = true;
      }

      if (field.disabledCondition) {
        let conditionResponse = field.disabledCondition;
        conditionResponse = conditionResponse(this.form);
        if (conditionResponse) {
          disable = true;
        }
      }
      return disable;
    },

    observeChanges(field, event) {
      if (field.onChange) {
        field.onChange(event);
      }
    },

    getFields() {
      return this.structure.filter((field) => {
        if (field.showInForm) {
          if (field.customVisibilty) {
            let customVisibilty = field.customVisibilty;
            let valid = customVisibilty();
            if (valid) {
              return field;
            }
          } else {
            return field;
          }
        }
      });
    },
  },

  computed: {
    isDisabled() {
      if (this.compareArrays(this.form, this.defaultForm)) {
        return true;
      }
      return false;
    },

    enableForm() {
      let formType = this.checkFormType();
      return this.checkPermission(formType);
    },
  },
});
</script>
