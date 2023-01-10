<template>
  <div class="overflow-x-hidden">
    <div class="bg-home-hero bg-cover">
      <nav class="flex items-center p-3 flex-wrap">
        <a href="#" class="p-2 mr-4 inline-flex items-center w-80">
          <img
            src="https://www.sheffieldhaworth.com/wp-content/themes/sheffield-haworth/img/logos/SH_logo_2021.svg"
          />
        </a>
        <!-- <button
          class="
            text-white
            inline-flex
            p-3
            hover:bg-gray-900
            rounded
            lg:hidden
            ml-auto
            hover:text-white
            outline-none
            nav-toggler
          "
          data-target="#navigation"
        >
          <i class="material-icons">menu</i>
        </button> -->
        <div
          class="top-navbar w-full lg:inline-flex lg:flex-grow lg:w-auto"
          id="navigation"
        >
          <div
            class="
              lg:inline-flex lg:flex-row lg:ml-auto lg:w-auto
              w-full
              lg:items-center
              items-start
              flex flex-col
              lg:h-auto
            "
          >
            <div
              class="
                cursor-pointer
                lg:inline-flex lg:w-auto
                w-full
                px-3
                py-2
                rounded
                text-white
                items-center
                justify-center
                hover:bg-gray-900 hover:text-white
              "
              @click="toggleContact"
            >
              <span>Contact Us</span>
            </div>

          <div v-if="showContact" id="dropdownNavbar" class="absolute right-0 top-28 lg:top-12 lg:right-2 bg-white text-base z-10 list-none divide-y divide-gray-100 rounded shadow my-4 w-full lg:inline-flex lg:flex-grow lg:w-auto">
                    <ul class="py-1" aria-labelledby="dropdownLargeButton">
                    <li>
                        <a href="mailto:f.wright@sheffieldhaworth.com" class="text-sm hover:bg-gray-100 text-gray-700 block px-4 py-2">
                          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 inline mr-1">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" />
                          </svg>
                          f.wright@sheffieldhaworth.com
                        </a>
                    </li>
                    </ul>
          </div>

          </div>
        </div>
      </nav>

      <h1 class="text-white text-5xl text-center font-extrabold my-16">
        Sheffield Haworth Magazine
      </h1>
      <p class="text-white text-center text-xl mt-8 pb-20 px-20 md:px-40">
        Have you had the chance to read our Sheffield Haworth Internal Magazine, <strong>‘Shout’</strong>? <br /> <br />
        We are very excited to keeping you up to date with what’s going on across our offices, so grab a coffee, take a break, and read about our new values: Trust, Humanity, Inclusion, Excellence, the winners of our monthly Values Awards, news on TALNT, short interviews with a few of our most recent joiners, updates from across our offices, and much more... <br /> <br />
        Read the magazine here.
      </p>
    </div>

    <div class="-m-10">
      <div
        class="
          w-80
          h-20
          bg-white
          m-auto
          text-center
          p-6
          text-xl
          rounded-lg
          shadow-xl
          font-bold
        "
      >
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="inline w-6 h-6 mr-2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
      </svg>

        Our Magazines
      </div>
    </div>

    <div class="mt-8 py-20 px-8 lg:px-20">
      <h1 class="text-primary text-2xl font-extrabold text-center">{{currentMagazine.name}}</h1>
      <div class="mt-2 mb-8 text-center">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="inline w-4 h-4 mr-1">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5m-9-6h.008v.008H12v-.008zM12 15h.008v.008H12V15zm0 2.25h.008v.008H12v-.008zM9.75 15h.008v.008H9.75V15zm0 2.25h.008v.008H9.75v-.008zM7.5 15h.008v.008H7.5V15zm0 2.25h.008v.008H7.5v-.008zm6.75-4.5h.008v.008h-.008v-.008zm0 2.25h.008v.008h-.008V15zm0 2.25h.008v.008h-.008v-.008zm2.25-4.5h.008v.008H16.5v-.008zm0 2.25h.008v.008H16.5V15z" />
          </svg>
            {{ currentMagazine.uploaded_at }}
      </div>

      <iframe :src="'view/' + currentMagazine.id" class="w-full h-[800px]" />
    </div>

    <div class="mb-8">
      
      <h1 class="text-primary text-2xl font-extrabold text-center">Our Previous Months Magazines</h1>

      <div class="mx-auto">
        <div class="overflow-hidden sm:rounded-lg">
          <!-- TABLE -->
          <div class="flex">
            <div class="m-auto -mt-12">
              <ListView
                :structure="structure"
                :records="filteredRecords"
                :recordOptions="recordOptions"
                :searchOptions="searchOptions"
                view="card"
                @view="viewMagazine($event)"
                @search="handleSearchOptions($event)"
              />
            </div>
          </div>
        </div>
      </div>
    </div>

    <footer
      class="
        p-4
        bg-primary
        shadow
        md:flex md:items-center md:justify-between md:p-6
        dark:bg-gray-800
      "
    >
      <span class="text-sm text-white sm:text-center dark:text-gray-400"
        >© 2022
        <a href="#" class="hover:underline" target="_blank">Sheffield Haworth</a
        >. All Rights Reserved.
      </span>
    </footer>
  </div>
</template>

<script>
import { defineComponent } from "vue";
import ListView from "../Components/ListView.vue";

export default defineComponent({
  props: {
    currentMagazine: {
      type: Object,
      required: true,
    },
    magazines: {
      type: Object,
      required: true,
    },
  },

  components: {
    ListView,
  },

  data() {
    let structure = [
      {
        key: "id",
        label: "Magazine ID",
        placeholder: "",
        type: "TextField",
        haveOptions: false,
        options: [],
        showInForm: false,
        showInList: false,
        sortable: true,
      },
      {
        key: "name",
        label: "Name",
        placeholder: "",
        type: "TextField",
        haveOptions: false,
        options: [],
        showInForm: true,
        showInList: true,
      },
      {
        key: "summary",
        label: "Summary",
        placeholder: "",
        type: "TextArea",
        haveOptions: false,
        options: [],
        showInForm: true,
        showInList: true,
      },
      {
        key: "pdf_path",
        label: "PDF Path",
        placeholder: "",
        type: "TextArea",
        haveOptions: false,
        options: [],
        showInForm: true,
        sortable: false,
        showInList: true,
        disabled: true,
      },
    ];

    let recordOptions = {
      permissions: {
        create: true,
        update: true,
        delete: true,
      },
      saveForm: true,
      deleteForm: true,
      custom: false,
      recordIds: [],
    };

    let searchOptions = {
      search: true,
      hidePagination: false,
      url: null,
      perPageCount: 12,
      sortOrder: "desc",
      sortOption: "id",
      keyword: "",
      keywordOptions: ['name'],
      filterOptions: {},
    };

    return {
      recordOptions: recordOptions,
      searchOptions: searchOptions,
      filteredRecords: this.magazines,
      structure: structure,
      showContact: false
    };
  },

  watch: {
    magazines: function (newMagazines, oldMagazines) {
      this.filteredRecords = newMagazines;
    },
  },

  methods: {
    viewMagazine(record) {
      window.location = "view/" + record.id;
    },

    handleSearchOptions(searchOptions) {
      this.searchOptions = searchOptions;
      this.getRecords();
    },

    toggleContact() {
      this.showContact = !this.showContact;
    },

    async getRecords() {
      let link =
        this.searchOptions.url == null ? "/" : this.searchOptions.url.url;

      this.$inertia.visit(link, {
        method: "get",
        data: {
          data: this.searchOptions,
        },
        preserveState: true,
        only: ["magazines"],
      });
    },
  },
});
</script>