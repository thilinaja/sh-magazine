<template>
  <button :type="type" :disabled="disabled" :class="styles" @click="buttonClick()">
    {{ label }}
    <span v-if="icon" :class="iconClass"> + </span>
    <span v-if="customIcon">
      <FontAwesomeIcon :icon="iconObject" />
    </span>
  </button>
</template>

<script>
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";
import { faEye } from "@fortawesome/free-solid-svg-icons";

export default {
  name: "Button",

  components: {
    FontAwesomeIcon,
    faEye,
  },

  props: {
    field: {
      type: Object,
      required: true,
    },
    disabled: {
      type: Boolean,
      default: false,
    },
  },

  emits: ["callback"],

  data() {
    return {
      variation: this.field.options.variation
        ? this.field.options.variation
        : "solid",
      label: this.field.label ? this.field.label : "",
      type: this.field.options.type ? this.field.options.type : "submit",
      icon: this.field.options.icon ? this.field.options.icon : false,
      customIcon: this.field.options.customIcon
        ? this.field.options.customIcon
        : false,
      color: this.field.options.color ? this.field.options.color : "primary",
    };
  },

  watch: {
    field: function (newField, oldField) {
      this.variation = newField.options.variation
        ? newField.options.variation
        : "solid";
      this.label = newField.label ? newField.label : "";
      this.type = newField.options.type ? newField.options.type : "submit";
      this.icon = newField.options.icon ? newField.options.icon : false;
      this.color = newField.options.color ? newField.options.color : "primary";
    },
  },

  methods: {
    buttonClick() {
      this.$emit("callback");
    },
  },

  computed: {
    styles: {
      get() {
        let baseClass = "inline-flex items-center rounded font-bold py-4";

        if (this.icon) {
          baseClass += ` px-4`;
        } else if (this.customIcon) {
          baseClass += ` px-2`;
        } else {
          baseClass += ` px-12`;
        }

        if (this.variation == "solid") {
          baseClass += ` hidden sm:inline-flex ml-5 text-white font-bold rounded text-body px-5 py-2.5 text-center items-center mr-3`;

          if (this.color == "primary") {
            baseClass += ` bg-primary border-2 border-primary `;
          }
        }
        if(this.variation =="solid-wide"){
           baseClass += ` rounded py-2.5 px-28 text-white font-bold text-body bg-primary mr-6 mt-8 `
        }

        if (this.variation == "outlined") {
          baseClass += ` text-primary py-sm px-xl leading-none rounded border-2 `;

          if (this.color == "primary") {
            baseClass += ` bg-white border-primary`;
          }
        }

        return baseClass;
      },
    },
    iconClass: {
      get() {
        return this.label == null ? "" : "pl-6";
      },
    },
    iconObject: {
      get() {
        if (this.customIcon == "eye") {
          return faEye;
        }
      },
    },
  },
};
</script>
