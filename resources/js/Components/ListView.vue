<template>
  <div class="w-full">
    <div class="bg-grey-200 rounded-lg py-12">
      <div v-if="searchOptions.search" class="justify-center flex p-6">
        <div class="relative mr-4">
          <!-- GLASS ICON -->
          <div
            class="
              absolute
              inset-y-0
              left-0
              pt-4
              pl-3
              pointer-events-none
            "
          >
            <svg
              class="w-5 h-5 text-grey-dark"
              fill="currentColor"
              viewBox="0 0 20 20"
              xmlns="http://www.w3.org/2000/svg"
            >
              <path
                fill-rule="evenodd"
                d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                clip-rule="evenodd"
              ></path>
            </svg>
          </div>
          <TextField
            :data.sync="searchOptions.keyword"
            :id="searchId"
            :placeholder="'Search'"
            @update:data="handleSearchKeyword"
            class="w-80 pl-10 p-2 rounded-3xl"
          />
        </div>
      </div>

      <div
        v-if="view == 'card'"
        class="mx-12 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-12 mt-12"
      >
        <MagazineCard
          v-for="row in recordsData"
          :key="row['id']"
          :row="row"
          @view="$emit('view', row)"
        />
      </div>
    </div>

    <div v-if="showPagination">
      <Paginator
        :links="records.links"
        :from="records.from"
        :to="records.to"
        :total="records.total"
        :perPageCount="searchOptions.perPageCount"
        :customCountOptions="customCountOptions"
        @changePage="handlePageClick"
        @changeCount="handlePageCountChange"
      />
    </div>
  </div>
</template>

<script>
import { defineComponent } from "vue";
import Paginator from "@/Components/Paginator.vue";
import TextField from "@/Components/TextField.vue";
import MagazineCard from "@/Components/MagazineCard.vue";
import Button from "./Button.vue";
import Select from "@/Components/Select.vue";
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";
import { faTimes } from "@fortawesome/free-solid-svg-icons";

export default defineComponent({
  components: {
    Button,
    Select,
    TextField,
    Paginator,
    FontAwesomeIcon,
    faTimes,
    MagazineCard,
  },

  props: {
    structure: {
      type: Array,
      required: true,
    },
    records: {
      type: Object,
      required: true,
    },
    recordOptions: {
      type: Object,
      required: true,
    },
    searchOptions: {
      type: Object,
      required: false,
    },
    view: {
      type: String,
      default: "list",
    },
  },

  data() {
    let columns = this.structure.filter((column) => {
      if (column.showInList) {
        return column;
      }
    });

    let customCountOptions = {
      12: "12",
      52: "52",
      102: "102",
    };

    return {
      recordsData: this.records.data,
      columns: columns,
      customCountOptions: customCountOptions,
      searchId: Math.random() * 100,
    };
  },

  watch: {
    records: function (newRecords, oldErrors) {
      this.recordsData = newRecords.data;
    },
  },

  emits: ["view", "search", "createOption"],

  methods: {
    clearSearch() {
      let el = document.getElementById(this.searchId);
      el.value = "";
      el.dispatchEvent(new Event("input"));
    },

    handleSearchKeyword(keyword) {
      this.searchOptions.url = null;
      this.searchOptions.keyword = keyword;
      this.$emit("search", this.searchOptions);
    },

    handlePageClick(link) {
      this.searchOptions.url = link;
      this.$emit("search", this.searchOptions);
    },

    handlePageCountChange(count) {
      this.searchOptions.url = null;
      this.searchOptions.perPageCount = count;
      this.$emit("search", this.searchOptions);
    },

    createOption() {
      this.$emit("createOption");
    },
  },

  computed: {
    showOptions: {
      get() {
        return this.searchOptions.keyword == "" ? false : true;
      },
    },
    showPagination: {
      get() {
        return this.searchOptions.hidePagination
          ? false
          : this.recordsData.length;
      },
    },
  },
});
</script>
