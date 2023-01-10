<template>
  <textarea v-model="selectedValue" :class="styles" rows="2" />
</template>

<script>
export default {
  name: "TextArea",

  props: {
    data: {
      type: String,
    },
  },

  emits: ["update:data"],

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
        return "px-4 py-3 rounded-md border border-grey-light-300 text-grey-light-300 focus:outline-none focus:ring-0 focus:ring-gray-200 focus:border-primary w-full";
      },
    },
  },
};
</script>
