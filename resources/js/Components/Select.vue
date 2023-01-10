<template>
  <select v-model="selectedItem" :class="styles" :disabled="disabled">
    <option class="text-primary p-2.5" value="">{{ emptyText }}</option>
    <option class="text-primary p-2.5" v-for="item in items" :key="item['key']" :value="item['key']">
      {{ item["label"] }}
    </option>
  </select>
</template>

<script>
export default {
  name: "Select",

  props: {
    field: {
      type: Object,
      required: true,
    },

    data: {
      type: [String, Number],
    },

    disabled: {
      type: Boolean,
      default: false,
    },

    variation: {
      type: String,
      default: "default",
    },
  },

  emits: ["update:data"],

  data() {
    return {
      options: this.field.options,
    };
  },

  computed: {
    items() {
      let items = [];

      if (this.disabled && this.options.useDiffOptions) {
        for (var key in this.options.useDiffOptions) {
          items.push({
            key: key,
            label: this.options.useDiffOptions[key],
          });
        }
        return items; 
      }

      if (this.options.filterOptions) {
        this.options.options = this.getNewOptions();
      }

      let customLabel = this.options.customLabel;
      for (var key in this.options.options) {
        if (this.options.useCustomLabel) {
          let item = customLabel(this.options.options[key]);
          items.push(item);
        } else {
          items.push({
            key: key,
            label: this.options.options[key],
          });
        }
      }

      return items;
    },

    selectedItem: {
      get() {
        let value = "";
        if (this.data != "" || this.data == 0) {
          value = this.data;
        }

        return value;
      },
      set(selectedItem) {
        if (selectedItem == "") {
          selectedItem = "";
        }

        this.$emit("update:data", selectedItem);
      },
    },

    emptyText: {
      get() {
        let value = this.field.options.emptyOptionText;
        if (!value) {
          value = "Please Select";
        }
        return value;
      },
    },

    styles: {
      get() {

        let baseClass = "leading-normal py-2.5 rounded-md border border-grey-light-300 text-grey-dark text-body focus:outline-none focus:ring-0 focus:ring-gray-200 focus:border-primary w-full";

        if (this.variation == "default") {
          baseClass +=
            " focus:outline-none focus:ring-0 focus:ring-200 focus:border-primary ";
        }

        if (this.variation == "custom-label") {
          baseClass +=
            " focus:outline-none focus:ring-0 focus:ring-200 focus:border-primary ";
        }

        return baseClass;
      },
    },
  },

  methods: {
    getNewOptions: function () {
      let newOptions = this.options.filterOptions;
      return newOptions();
    },
  },
};
</script>
