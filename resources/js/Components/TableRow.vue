<template>
  <tr class="border-b border-b-gray-100 text-secondary">
    <td
      class="p-4 whitespace-nowrap text-sm font-normal text-secondary"
      v-for="column in columns"
      :key="column['key']"
    >
      <div class="flex items-center truncate">
        {{ this.getRowValue(row, column) }}
      </div>
    </td>

    <td
      v-if="!this.recordOptions.hideActions"
      class="p-4 whitespace-nowrap text-sm font-normal text-grey-dark"
    >
      <div class="flex item-center justify-center">
        <div
          class="w-4 mr-2 text-secondary transform cursor-pointer hover:scale-110"
          v-if="allowAction('custom')"
          @click="customFunction()"
        >
          <div v-if="this.recordOptions.customOptions.isCustom">
            <component :is="customIcon" />
          </div>
          <div v-else>
            <FontAwesomeIcon :icon="customIcon" />
          </div>
        </div>
        <div
          class="
            w-4
            mr-2
            text-secondary
            transform
            cursor-pointer
            hover:scale-110
          "
          v-if="allowAction('save')"
          @click="editEntity()"
        >
          <div v-if="!editIcon">
            <svg
              xmlns="http://www.w3.org/2000/svg"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"
              />
            </svg>
          </div>
          <div v-else>
            <FontAwesomeIcon :icon="editIcon" />
          </div>
        </div>
        <div
          class="
            w-4
            mr-2
            text-warning
            transform
            hover:text-warning
            cursor-pointer
            hover:scale-110
          "
          v-if="allowAction('delete')"
          @click="deleteEntity()"
        >
          <svg
            xmlns="http://www.w3.org/2000/svg"
            fill="none"
            viewBox="0 0 24 24"
            stroke="currentColor"
            class="text-red-600"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"
            />
          </svg>
        </div>
      </div>
    </td>
  </tr>
</template>

<script>
import { defineComponent } from "vue";
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";
import DownloadQR from "./Icons/DownloadQR.vue";
import { faEye } from "@fortawesome/free-solid-svg-icons";

export default defineComponent({
  components: {
    FontAwesomeIcon,
    DownloadQR,
    faEye,
  },

  props: {
    columns: {
      type: Array,
      required: true,
    },

    row: {
      type: Object,
      required: true,
    },

    recordOptions: {
      type: Object,
      required: true,
    },

    checkedOptions: {
      type: Object,
      required: false,
    },
  },

  data() {
    return {
      customIcon:
        this.recordOptions.custom && this.recordOptions.customOptions
          ? this.recordOptions.customOptions.icon
          : faEye,
      editIcon:
        this.recordOptions.customOptions &&
        this.recordOptions.customOptions.editIcon
          ? this.recordOptions.customOptions.editIcon
          : null,
    };
  },

  emits: ["edit", "delete", "custom", "checkedOptions"],

  methods: {
    handleCheckChange(value) {
      this.checkedOptions[this.row.id] = value;
      this.$emit("checkedOptions", this.checkedOptions);
    },

    getRowValue(row, column) {
      let value = "";
      if (column.customMapping) {
        let functionName = column.customMapping;
        value = functionName(row, column);
      } else {
        value = row[column.key];
        if (column.haveOptions) {
          value = column.options.options[value];
        }
      }

      return value;
    },

    editEntity() {
      this.$emit("edit");
    },

    deleteEntity() {
      this.$emit("delete");
    },

    customFunction() {
      this.$emit("custom");
    },

    allowAction(type) {
      let valid = true;

      if (type == "save") {
        if (this.recordOptions.saveForm) {
          if (this.recordOptions.recordIds.indexOf(this.row.id) !== -1) {
            valid = false;
          }
        } else {
          valid = false;
        }
      }

      if (type == "delete") {
        if (this.recordOptions.permissions.delete) {
          if (this.recordOptions.deleteForm) {
            if (this.recordOptions.recordIds.indexOf(this.row.id) !== -1) {
              valid = false;
            }
          }
        } else {
          valid = false;
        }
      }

      if (type == "custom") {
        if (!this.recordOptions.custom) {
          valid = false;
        }
      }

      return valid;
    },
  },
});
</script>
