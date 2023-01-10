<template>
  <div class="bg-white shadow-xl w-80 flex-none cursor-pointer rounded" @click="viewPdf()">
    
    <img class="rounded-t" :src="row.thumbnail_path">
    
    <article class="text-primary">
      <div class="pb-2.5 flex-auto overflow-hidden w-full">
        <div class="mt-2 p-6">
          <div class="text-black font-bold text-base pr-7">
            {{ row.name }}
          </div>
          <div class="text-black text-sm font-normal mt-1 pr-7">
            {{ row.summary }}
          </div>
          <div class="flex mt-6">
            <div class="w-1/2 text-gray-500 text-sm">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="inline w-4 h-4 mr-1">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5m-9-6h.008v.008H12v-.008zM12 15h.008v.008H12V15zm0 2.25h.008v.008H12v-.008zM9.75 15h.008v.008H9.75V15zm0 2.25h.008v.008H9.75v-.008zM7.5 15h.008v.008H7.5V15zm0 2.25h.008v.008H7.5v-.008zm6.75-4.5h.008v.008h-.008v-.008zm0 2.25h.008v.008h-.008V15zm0 2.25h.008v.008h-.008v-.008zm2.25-4.5h.008v.008H16.5v-.008zm0 2.25h.008v.008H16.5V15z" />
          </svg>
            {{ row.uploaded_at }}
            </div>
            <div class="w-1/2 text-right font-bold text-sm">
            Read More
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="inline w-4 h-4">
              <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12h15m0 0l-6.75-6.75M19.5 12l-6.75 6.75" />
            </svg>
            </div>
          </div>
        </div>
      </div>
    </article>
  </div>
</template>

<script>
import { defineComponent } from "vue";
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";

export default defineComponent({
  components: {
    FontAwesomeIcon,
  },

  props: {
    row: {
      type: Object,
      required: true,
    },
  },

  emits: ["view"],

  methods: {
    viewPdf() {
      this.$emit("view");
    },
  },
});
</script>
