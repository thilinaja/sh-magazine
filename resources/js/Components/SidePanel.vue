<template>
  <div class="fixed z-50 inset-0 overflow-hidden" v-bind:class="{ hidden: !visibility }">
    <div class="absolute inset-0 overflow-hidden">
      <div
        class="absolute inset-0 bg-black bg-opacity-25 transition-opacity"
        aria-hidden="true"
      ></div>
      <div class="fixed inset-y-0 right-0 pl-10 max-w-full flex">
        <div class="relative w-screen " :class="formClass">
          <div class="absolute top-0 left-0 -ml-8 pt-4 pr-2 flex sm:-ml-10 sm:pr-4">
            <button
              type="button"
              class="rounded-md text-gray-300 hover:text-white focus:outline-none focus:ring-2 focus:ring-white"
              @click="closeSlide()"
            >
              <span class="sr-only">Close panel</span>
              <svg
                class="h-6 w-6"
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
                aria-hidden="true"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M6 18L18 6M6 6l12 12"
                />
              </svg>
            </button>
          </div>

          <div class="h-full flex flex-col bg-white shadow-xl overflow-y-scroll">
            <slot>
            </slot>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { defineComponent } from "vue";

export default defineComponent({
  name: "SidePanel",

  props: {
    visibility: {
      type: Boolean,
      required: true,
    },
    width: {
      type: Boolean,
      required: false,
    },
  },

  emits: ["close"],

  methods: {
    closeSlide() {
      this.$emit("close");
    },
  },

  computed: {
    formClass: {
      get() {
        let formClass = this.width ? this.width : 'max-w-screen-sm';
        return formClass;
      },
    },
  },
});
</script>
