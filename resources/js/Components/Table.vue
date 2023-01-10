<template>
  <div>
    <div class="bg-white rounded-lg">
      <div v-if="searchOptions.search || searchOptions.filterOptions.length"
        class="justify-end flex p-6">
        <div v-if="searchOptions.search" class="relative mr-4">
          <!-- GLASS ICON -->
          <div class="
                    absolute inset-y-0 left-0 pt-4 pl-3 flex pointer-events-none
                  ">
            <svg class="w-5 h-5 text-grey-dark" fill="currentColor" viewBox="0 0 20 20"
              xmlns="http://www.w3.org/2000/svg">
              <path fill-rule="evenodd"
                d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                clip-rule="evenodd"></path>
            </svg>
          </div>
          <TextField :data.sync="searchOptions.keyword" :id="searchId" :placeholder="'Search'"
            @update:data="handleSearchKeyword" class="pl-10 p-2 rounded-3xl" />

          <div v-if="showOptions">

            <button @click="clearSearch"
              class="absolute flex justify-center items-center pr-2 right-2 top-4 text-grey-dark">
              <FontAwesomeIcon :icon="faTimes" />
            </button>
            {{ records.total }} search results found
          </div>
        </div>

      </div>

      <table class="table-fixed w-full">
        <thead class="bg-gray-50">
          <tr>
            <th v-if="this.recordOptions.multiselect" class="w-10">
            </th>

            <th class="p-4 text-left text-body font-bold text-grey-dark capitalize tracking-normal"
              v-for="column in columns" :key="column['key']">
              {{ column.label }}
              <button v-if="column.sortable" @click="handleSortOptions(column)">
                <FontAwesomeIcon :icon="faSort" />
              </button>
            </th>

            <th v-if="!this.recordOptions.hideActions"
              class="p-4 text-body font-bold text-grey-dark capitalize tracking-wide">
              Action
            </th>
          </tr>
        </thead>
        <tbody>
          <TableRow v-for="(row, index) in recordsData" :key="index" :columns="columns" :row="row"
            :recordOptions="recordOptions" :checkedOptions="checkedRecords" @edit="$emit('edit', row)" @delete="$emit('delete', row)"
            @custom="$emit('custom', row)" @checkedOptions="$emit('checkedOptions', $event)"/>

          <td v-if="!recordsData.length" :colspan="columns.length + (this.recordOptions.hideActions ? 0 : 1)"
            class="p-4 text-sm font-normal text-gray-500 text-center">
            No records at the moment.
          </td>
        </tbody>
      </table>
    </div>

    <div v-if="showPagination">
      <Paginator :links="records.links" :from="records.from" :to="records.to" :total="records.total"
        :perPageCount="searchOptions.perPageCount" @changePage="handlePageClick" @changeCount="handlePageCountChange" />
    </div>
  </div>
</template>
<script>
import { defineComponent } from "vue";
import TextField from "./TextField.vue";
import TableRow from "./TableRow.vue";
import Paginator from "./Paginator.vue";
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";
import { faTimes } from "@fortawesome/free-solid-svg-icons";
import { faSort } from "@fortawesome/free-solid-svg-icons";

export default defineComponent({
  components: {
    TableRow,
    Paginator,
    TextField,
    FontAwesomeIcon,
    faTimes,
    faSort
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
    checkedRecords: {
      type: Object,
      required: false,
    },
  },

  data() {
    let recordsData = this.searchOptions.hidePagination
      ? this.records
      : this.records.data;

    let columns = this.structure.filter((column) => {
      if (column.showInList) {
        return column;
      }
    });

    return {
      recordsData: recordsData,
      faSort: faSort,
      faTimes: faTimes,
      columns: columns,
      searchId: Math.random() * 100,
    };
  },

  watch: {
    records: function (newRecords, oldErrors) {
      this.recordsData = this.searchOptions.hidePagination ? newRecords : newRecords.data;
    },
  },

  emits: ["edit", "delete", "sort", "search", "custom", "checkedOptions"],

  methods: {
    clearSearch() {
      let el = document.getElementById(this.searchId);
      el.value = "";
      el.dispatchEvent(new Event("input"));
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

    handleSortOptions(sortOption) {
      let sortOrder = "asc";
      if (this.searchOptions.sortOption == sortOption.key) {
        sortOrder = this.searchOptions.sortOrder == "asc" ? "desc" : "asc";
      }

      this.searchOptions.url = null;
      this.searchOptions.sortOption = sortOption.key;
      this.searchOptions.sortOrder = sortOrder;
      this.$emit("search", this.searchOptions);
    },

    handleSearchKeyword(keyword) {
      this.searchOptions.url = null;
      this.searchOptions.keyword = keyword;
      this.$emit("search", this.searchOptions);
    },

    handleFilterOptions(filterOptions) {
      this.searchOptions.url = null;
      this.searchOptions.filterOptions = filterOptions;
      this.$emit("search", this.searchOptions);
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
        return this.searchOptions.hidePagination ? false : this.recordsData.length;
      },
    },
    hideActions: {
      get() {
        hideActions;
        return this.recordOptions.hideActions;
      },
    },
  },


});
</script>
