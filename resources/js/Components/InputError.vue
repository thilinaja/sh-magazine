<template>
  <span class="mt-2 text-red-500 text-xs font-bold"> {{ message }} </span>
</template>
<script>
export default {
  name: "InputError",

  props: {
    message: {
      type: String,
    },
  },
};
</script>
