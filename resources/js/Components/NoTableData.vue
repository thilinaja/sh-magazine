<template>
  <tr>
    <td>
      {{ message }}
    </td>
  </tr>
</template>

<script>
export default {
  props: {
    message: {
      type: String,
      required: true,
    },
  },
};
</script>
