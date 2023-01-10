<template>
  <input
    type="file"
    :id="name"
    :name="name"
    @input="handleFileUpload($event)"
  />
</template>

<script>
export default {
  name: "FileUpload",

  props: {
    name: {
      type: String,
    },
    data: {
      type: String,
    },
  },

  emits: ["update:data"],

  methods: {
    handleFileUpload(e) {
      let file = e.target.files[0];
      this.$emit("update:data", file);
    },
  },
};
</script>
