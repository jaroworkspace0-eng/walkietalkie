<script setup>
import AppLayout from '@/layouts/AppLayout.vue';
import '../../../css/style.css';

// import { type BreadcrumbItem } from '@/types';
import { Link, router } from '@inertiajs/vue3';
import { ref } from 'vue';
import { Button } from '@/components/ui/button'

const showModal = ref(false);

const openModal = () => {
    showModal.value = true;
}

const closeModal = () => {
    showModal.value = false;
}

defineProps({
  clients: {
    type: Object,
    required: true,
  },
})

const form = ref({
    name: '',
    phone: '',
    email: '',
    address: '',
})

const createClient = () => {
  router.post('/clients', form.value, {
    onSuccess: () => {
      resetForm();
      showModal.value = false;
    }
  });
}

function resetForm() {
  form.value = {
    name: '',
    phone: '',
    email: '',
    address: '',
    role:'',
  }
}

const visit = (url) => {
  router.visit(url);
}
</script>

<template>



    <AppLayout :breadcrumbs="breadcrumbs">
        <!-- <pre>{{ clients.data }}</pre> -->
        <div class="relative flex flex-col w-full h-full text-gray-700 bg-white shadow-md rounded-xl bg-clip-border">
  <div class="relative mx-4 mt-4 overflow-hidden text-gray-700 bg-white rounded-none bg-clip-border">
    <div class="flex items-center justify-between gap-8 mb-8">
      <div>

        <p class="block mt-1 font-sans text-base antialiased font-normal leading-relaxed text-gray-700">
          See information about all Clients
        </p>
      </div>
      <div class="flex flex-col gap-2 shrink-0 sm:flex-row">
        <button
          class="select-none rounded-lg border border-gray-900 py-2 px-4 text-center align-middle font-sans text-xs font-bold uppercase text-gray-900 transition-all hover:opacity-75 focus:ring focus:ring-gray-300 active:opacity-[0.85] disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none"
          type="button"
          @click="openModal">
          Add Client
        </button>
    <form @submit.prevent="createClient()">

      <div v-if="showModal">
        <!-- Overlaying -->
         <div class="fixed inset-0 z-50 flex items-center justify-center bg-gray-600 bg-opacity-25">
            <!-- Modal Content -->
             <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-lg">
                <h2 class="text-heading">Create new Client</h2>

                <div class="grid gap-4">
          <div class="grid gap-3">
            <Label for="name-1">Client</Label>
            <input id="name-1" default-value="Pedro Duarte" v-model="form.name" />
            <p v-if="$page.props.errors.name" class="text-red-600 text-sm">{{ $page.props.errors.name }}</p>
          </div>
           <div class="grid gap-3">
            <Label for="name-1">Contact</Label>
            <input id="name-1" default-value="Pedro Duarte" v-model="form.phone" />
             <p v-if="$page.props.errors.phone" class="text-red-600 text-sm">{{ $page.props.errors.phone }}</p>
          </div>
           <div class="grid gap-3">
            <Label for="name-1">Email</Label>
            <input id="name-1" default-value="Pedro Duarte" v-model="form.email" />
             <p v-if="$page.props.errors.email" class="text-red-600 text-sm">{{ $page.props.errors.email }}</p>
          </div>
           <div class="grid gap-3">
            <Label for="name-1">Address</Label>
                <textarea rows="7" v-model="form.address"></textarea>
                 <p v-if="$page.props.errors.address" class="text-red-600 text-sm">{{ $page.props.errors.address }}</p>
          </div>
          <div class="flex items-end w-max">
            <button type="button" @click="closeModal" class="cancel-btn mr-3">
              Cancel
            </button>
          <button type="submit" class="save-btn">
            Save
          </button>
          </div>
        </div>
             </div>
         </div>
      </div>
    </form>

      </div>
    </div>


    <div class="flex flex-col items-center justify-between gap-4 md:flex-row">
      <div class="block w-full overflow-hidden md:w-max">
        <nav>
          <ul role="tablist" class="relative flex flex-row p-1 rounded-lg bg-blue-gray-50 bg-opacity-60">
            <li role="tab"
              class="relative flex items-center justify-center w-full h-full px-2 py-1 font-sans text-base antialiased font-normal leading-relaxed text-center bg-transparent cursor-pointer select-none text-blue-gray-900"
              data-value="all">
              <div class="z-20 text-inherit">
                &nbsp;&nbsp;All&nbsp;&nbsp;
              </div>
              <div class="absolute inset-0 z-10 h-full bg-white rounded-md shadow"></div>
            </li>
            <li role="tab"
              class="relative flex items-center justify-center w-full h-full px-2 py-1 font-sans text-base antialiased font-normal leading-relaxed text-center bg-transparent cursor-pointer select-none text-blue-gray-900"
              data-value="monitored">
              <div class="z-20 text-inherit">
                &nbsp;&nbsp;Users&nbsp;&nbsp;
              </div>
            </li>
            <li role="tab"
              class="relative flex items-center justify-center w-full h-full px-2 py-1 font-sans text-base antialiased font-normal leading-relaxed text-center bg-transparent cursor-pointer select-none text-blue-gray-900"
              data-value="unmonitored">
              <div class="z-20 text-inherit">
                &nbsp;&nbsp;Clients&nbsp;&nbsp;
              </div>
            </li>
          </ul>
        </nav>
      </div>
      <div class="w-full md:w-72">
        <div class="relative h-10 w-full min-w-[200px]">
          <div class="absolute grid w-5 h-5 top-2/4 right-3 -translate-y-2/4 place-items-center text-blue-gray-500">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
              stroke="currentColor" aria-hidden="true" class="w-5 h-5">
              <path stroke-linecap="round" stroke-linejoin="round"
                d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"></path>
            </svg>
          </div>
          <input
            class="peer h-full w-full rounded-[7px] border border-blue-gray-200 border-t-transparent bg-transparent px-3 py-2.5 !pr-9 font-sans text-sm font-normal text-blue-gray-700 outline outline-0 transition-all placeholder-shown:border placeholder-shown:border-blue-gray-200 placeholder-shown:border-t-blue-gray-200 focus:border-2 focus:border-gray-900 focus:border-t-transparent focus:outline-0 disabled:border-0 disabled:bg-blue-gray-50"
            placeholder=" " />
          <label
            class="before:content[' '] after:content[' '] pointer-events-none absolute left-0 -top-1.5 flex h-full w-full select-none !overflow-visible truncate text-[11px] font-normal leading-tight text-gray-500 transition-all before:pointer-events-none before:mt-[6.5px] before:mr-1 before:box-border before:block before:h-1.5 before:w-2.5 before:rounded-tl-md before:border-t before:border-l before:border-blue-gray-200 before:transition-all after:pointer-events-none after:mt-[6.5px] after:ml-1 after:box-border after:block after:h-1.5 after:w-2.5 after:flex-grow after:rounded-tr-md after:border-t after:border-r after:border-blue-gray-200 after:transition-all peer-placeholder-shown:text-sm peer-placeholder-shown:leading-[3.75] peer-placeholder-shown:text-blue-gray-500 peer-placeholder-shown:before:border-transparent peer-placeholder-shown:after:border-transparent peer-focus:text-[11px] peer-focus:leading-tight peer-focus:text-gray-900 peer-focus:before:border-t-2 peer-focus:before:border-l-2 peer-focus:before:!border-gray-900 peer-focus:after:border-t-2 peer-focus:after:border-r-2 peer-focus:after:!border-gray-900 peer-disabled:text-transparent peer-disabled:before:border-transparent peer-disabled:after:border-transparent peer-disabled:peer-placeholder-shown:text-blue-gray-500">
            Search
          </label>
        </div>
      </div>
    </div>
  </div>

<div class="pl-4 pr-4 pt-4 pb-0">
  <div v-if="$page.props.flash && $page.props.flash.success" class="bg-green-100 text-green-800 p-2 rounded mb-4">
    {{ $page.props.flash.success }}
  </div>
  </div>
  <div class="pl-6 pr-6 pt-0 px-0 overflow-scroll">
    <table class="w-full mt-4 text-left table-auto min-w-max">
      <thead>
        <tr>
          <th
            class="p-4 transition-colors cursor-pointer border-y border-blue-gray-100 bg-blue-gray-50/50 hover:bg-blue-gray-50">
            <p
              class="flex items-center justify-between gap-2 font-sans text-sm antialiased font-normal leading-none text-blue-gray-900 opacity-70">
              Client
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                stroke="currentColor" aria-hidden="true" class="w-4 h-4">
                <path stroke-linecap="round" stroke-linejoin="round"
                  d="M8.25 15L12 18.75 15.75 15m-7.5-6L12 5.25 15.75 9"></path>
              </svg>
            </p>
          </th>
          <th
            class="p-4 transition-colors cursor-pointer border-y border-blue-gray-100 bg-blue-gray-50/50 hover:bg-blue-gray-50">
            <p
              class="flex items-center justify-between gap-2 font-sans text-sm antialiased font-normal leading-none text-blue-gray-900 opacity-70">
              Contact
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                stroke="currentColor" aria-hidden="true" class="w-4 h-4">
                <path stroke-linecap="round" stroke-linejoin="round"
                  d="M8.25 15L12 18.75 15.75 15m-7.5-6L12 5.25 15.75 9"></path>
              </svg>
            </p>
          </th>
          <th
            class="p-4 transition-colors cursor-pointer border-y border-blue-gray-100 bg-blue-gray-50/50 hover:bg-blue-gray-50">
            <p
              class="flex items-center justify-between gap-2 font-sans text-sm antialiased font-normal leading-none text-blue-gray-900 opacity-70">
              Email
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                stroke="currentColor" aria-hidden="true" class="w-4 h-4">
                <path stroke-linecap="round" stroke-linejoin="round"
                  d="M8.25 15L12 18.75 15.75 15m-7.5-6L12 5.25 15.75 9"></path>
              </svg>
            </p>
          </th>
          <th
            class="p-4 transition-colors cursor-pointer border-y border-blue-gray-100 bg-blue-gray-50/50 hover:bg-blue-gray-50">
            <p
              class="flex items-center justify-between gap-2 font-sans text-sm antialiased font-normal leading-none text-blue-gray-900 opacity-70">
              Address
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                stroke="currentColor" aria-hidden="true" class="w-4 h-4">
                <path stroke-linecap="round" stroke-linejoin="round"
                  d="M8.25 15L12 18.75 15.75 15m-7.5-6L12 5.25 15.75 9"></path>
              </svg>
            </p>
          </th>
          <th
            class="p-4 transition-colors cursor-pointer border-y border-blue-gray-100 bg-blue-gray-50/50 hover:bg-blue-gray-50">
            <p
              class="flex items-center justify-between gap-2 font-sans text-sm antialiased font-normal leading-none text-blue-gray-900 opacity-70">
              Actions
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                stroke="currentColor" aria-hidden="true" class="w-4 h-4">
                <path stroke-linecap="round" stroke-linejoin="round"
                  d="M8.25 15L12 18.75 15.75 15m-7.5-6L12 5.25 15.75 9"></path>
              </svg>
            </p>
          </th>
          <th
            class="p-4 transition-colors cursor-pointer border-y border-blue-gray-100 bg-blue-gray-50/50 hover:bg-blue-gray-50">
            <p
              class="flex items-center justify-between gap-2 font-sans text-sm antialiased font-normal leading-none text-blue-gray-900 opacity-70">
            </p>
          </th>
        </tr>
      </thead>
       <tbody>
        <tr v-for="client in clients.data" :key="client.id">
          <td class="p-4 border-b border-blue-gray-50">
            <div class="flex items-center gap-3">
              <img src="https://demos.creative-tim.com/test/corporate-ui-dashboard/assets/img/team-3.jpg"
                alt="John Michael" class="relative inline-block h-9 w-9 !rounded-full object-cover object-center" />
              <div class="flex flex-col">
                <p class="block font-sans text-sm antialiased font-normal leading-normal text-blue-gray-900">
                  {{client.name}}
                </p>
                <p
                  class="block font-sans text-sm antialiased font-normal leading-normal text-blue-gray-900 opacity-70">
                  {{client.email}}
                </p>
              </div>
            </div>
          </td>
          <td class="p-4 border-b border-blue-gray-50">
            <div class="flex flex-col">
              <p class="block font-sans text-sm antialiased font-normal leading-normal text-blue-gray-900">
               {{client.phone}}
              </p>
              <p
                class="block font-sans text-sm antialiased font-normal leading-normal text-blue-gray-900 opacity-70">
                {{client.role}}
              </p>
            </div>
          </td>
          <td class="p-4 border-b border-blue-gray-50">
            <div class="w-max">
              <div
                class="relative grid items-center px-2 py-1 font-sans font-bold">
                <span class="">{{ client.email }}</span>
              </div>
            </div>
          </td>
          <td class="p-4 border-b border-blue-gray-50">
            <p class="block font-sans text-sm antialiased font-normal leading-normal text-blue-gray-900">
              {{client.address}}
            </p>
          </td>
          <td class="p-4 border-b border-blue-gray-50">
            <button
              class="relative h-10 max-h-[40px] w-10 max-w-[40px] select-none rounded-lg text-center align-middle font-sans font-medium text-gray-900 transition-all hover:bg-gray-900/10 active:bg-gray-900/20 disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none"
              type="button">
              <span class="absolute transform -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"
                  class="w-4 h-4">
                  <path
                    d="M21.731 2.269a2.625 2.625 0 00-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 000-3.712zM19.513 8.199l-3.712-3.712-12.15 12.15a5.25 5.25 0 00-1.32 2.214l-.8 2.685a.75.75 0 00.933.933l2.685-.8a5.25 5.25 0 002.214-1.32L19.513 8.2z">
                  </path>
                </svg>
              </span>
            </button>

            <button
              class="relative h-10 max-h-[40px] w-10 max-w-[40px] select-none rounded-lg text-center align-middle font-sans font-medium text-gray-900 transition-all hover:bg-gray-900/10 active:bg-gray-900/20 disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none"
              type="button">
              <span class="absolute transform -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"
                  class="w-4 h-4">
                  <path
                    d="M21.731 2.269a2.625 2.625 0 00-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 000-3.712zM19.513 8.199l-3.712-3.712-12.15 12.15a5.25 5.25 0 00-1.32 2.214l-.8 2.685a.75.75 0 00.933.933l2.685-.8a5.25 5.25 0 002.214-1.32L19.513 8.2z">
                  </path>
                </svg>
              </span>
            </button>
          </td>
        </tr>

      </tbody>
    </table>
  </div>
  <div class="flex items-center justify-between p-4 border-t border-blue-gray-50">

        <div class="text-sm text-gray-600">
            Showing {{ clients.from }} to {{ clients.to }} of {{ clients.total }} entries
        </div>

        <div class="flex space-x-2">
            <template v-for="link in clients.links" :key="link.label">
                <Link
                    v-if="link.url"
                    :href="link.url"
                    class="px-3 py-1 border rounded"
                    :class="{
                        'bg-blue-500 text-white': link.active,
                        'bg-white text-blue-500': !link.active
                    }"
                    v-html="link.label"
                ></Link>
                <span
                    v-else
                    class="px-3 py-1 border rounded bg-gray-200 text-gray-500"
                    v-html="link.label"
                ></span>
            </template>
        </div>
  </div>
</div>


    </AppLayout>
</template>
