<template>
  <input :name="randomName" :class="styles" v-model="selectedValue" :disabled="disabled" @input="onChange" type="text" :autocomplete="autofill" />
</template>

<script>
export default {
  name: "TextField",

  props: {
    data: {
      type: String,
      required: false,
    },
    variation: {
      type: String,
      default: "default",
    },
    disabled: {
      type: Boolean,
      default: false,
    },
    errors: {
      type: String,
      default: "",
    },
    autofill: {
      type: String,
      default: "on",
    },
  },

  data() {
    let fieldStyles = this.styles;

    return {
      fieldStyles: fieldStyles,
    };
  },

  watch: {
    errors: function (newErrors, oldErrors) {
      this.fieldStyles = this.styles;
    },
  },

  emits: ["update:data", "onChange:data"],

  computed: {
    selectedValue: {
      get() {
        return this.data;
      },
      set(selectedValue) {
        this.$emit("update:data", selectedValue);
      },
    },
    styles: {
      get() {
        let baseClass =
          "p-2.5 rounded-md border border-grey-light-300 text-grey-dark focus:outline-none focus:ring-0 focus:ring-200 focus:border-gray-200 w-full text-body";

        if (this.errors != "") {
          baseClass += " border-error";
        }

        return baseClass;
      },
    },
    randomName: {
      get() {
        return Math.random().toString(36).slice(5);
      }
    }
  },

  methods: {
    onChange: function () {
      this.$emit("onChange:data", this.selectedValue);
    }
  }
};
</script>
