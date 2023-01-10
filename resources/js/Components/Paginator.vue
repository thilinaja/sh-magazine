<template>
  <div class="flex flex-row items-center justify-end mt-5 mr-4">
    <div class="flex items-center justify-between space-x-4 w-auto">
      <div
        class="
          grid grid-flow-col
          auto-cols-max
          items-stretch
          place-content-center
          space-x-3
        "
      >
        <Select
          class="leading-none inline border border-grey-light-300 rounded-md"
          :field="countSelectField"
          :data.sync="perPageCount"
          @update:data="handleCountClick($event)"
        />
      </div>

      <nav
        class="relative z-0 inline-flex rounded-md space-x-2"
        aria-label="Pagination"
      >
        <button
          v-for="link in links"
          :key="link"
          class="
            relative
            inline-flex
            rounded-md
            items-center
            text-xs
            font-normal
            text-body
            hover:bg-dark hover:text-grey-dark
            focus:outline-none
            h-8
            w-8
          "
          :class="{
            'bg-primary': link.active,
            'text-white': link.active,
            'text-grey-dark': !link.active,
            shadow: link.active,
            'cursor-not-allowed': link.url === null,
            'px-3 py-1': isPageNumber(link.label),
          }"
          preserve-state
          preserve-scroll
          type="button"
          :disabled="link.url === null"
          @click="handleButtonClick(link)"
        >
          <svg
            v-if="isPrevious(link.label)"
            class="
              h-8
              w-8
              p-1
              text-primary
              rounded-md
              bg-green-light bg-opacity-10
              hover:bg-light
            "
            xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 20 20"
            fill="currentColor"
            aria-hidden="true"
          >
            <path
              fill-rule="evenodd"
              d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
              clip-rule="evenodd"
            />
          </svg>

          <svg
            v-else-if="isNext(link.label)"
            class="
              h-8
              w-8
              p-1
              text-primary
              rounded-md
              bg-green-light bg-opacity-10
              hover:bg-light
            "
            xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 20 20"
            fill="currentColor"
            aria-hidden="true"
          >
            <path
              fill-rule="evenodd"
              d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
              clip-rule="evenodd"
            />
          </svg>

          <span v-else>{{ link.label }}</span>
        </button>
      </nav>
    </div>
  </div>
</template>

<script>
import Select from "./Select.vue";
export default {
  name: "Paginator",

  components: {
    Select,
  },

  props: {
    links: {
      type: Array,
      required: true,
    },

    from: {
      type: Number,
      required: true,
    },

    to: {
      type: Number,
      required: true,
    },

    total: {
      type: Number,
      required: true,
    },

    perPageCount: {
      type: [String, Number],
      required: true,
    },

    handlePageClick: {
      type: Function,
      default: null,
    },

    customCountOptions: {
      type: [Array, Boolean],
      default: false
    },
  },

  emits: ["changePage", "changeCount"],

  data() {
    let countSelectField = {
      key: "count",
      options: {
        options: {
          10: "10",
          50: "50",
          100: "100",
        },
      },
    };

    if (this.customCountOptions) {
      countSelectField.options.options = this.customCountOptions;
    }

    return {
      countSelectField: countSelectField,
    };
  },

  methods: {
    isPrevious(label) {
      return label.includes("Previous");
    },

    isNext(label) {
      return label.includes("Next");
    },

    isPageNumber(label) {
      return !label.includes("Next") && !label.includes("Previous");
    },

    handleButtonClick(link) {
      this.$emit("changePage", link);
    },

    handleCountClick(value) {
      this.$emit("changeCount", value);
    },
  },
};
</script>
