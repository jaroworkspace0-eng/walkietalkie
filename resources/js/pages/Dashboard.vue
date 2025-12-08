<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { dashboard } from '@/routes';
import { type BreadcrumbItem } from '@/types';
import { Head, Link } from '@inertiajs/vue3';
import PlaceholderPattern from '../components/PlaceholderPattern.vue';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: dashboard().url,
    },
   
];



  const metrics = [
    // { label: 'Pending Payouts', value: 'R12,450', icon: '💰', color: 'yellow' },
    // { label: 'Completed Payouts', value: 'R38,200', icon: '✅', color: 'green' },
    // { label: 'Refunds Paid', value: 'R3,800', icon: '✅', color: 'emerald' },
    { label: 'Manage Channels', value: '150', icon: '🎯', color: 'teal' },
    { label: 'Manage Users', value: '248', icon: '🎫', color: 'green' },
    // { label: 'Manage Clients', value: '12', icon: '📅', color: 'indigo' },
 
    { label: 'Manage Clients', value: '32', icon: '🧑‍💼', color: 'blue' },
    // { label: 'Affiliates Active', value: '18', icon: '🔗', color: 'cyan' },
    // { label: 'Refund Requests', value: '4', icon: '🔁', color: 'red' },
    // { label: 'Feedback Received', value: '76', icon: '💬', color: 'pink' },
    { label: 'Manage Facilities', value: '5', icon: '🛠️', color: 'gray' },
    // { label: 'Platform Revenue (MTD)', value: 'R24,600', icon: '💵', color: 'blue' },
    // { label: 'Profit (MTD)', value: 'R6,800', icon: '📊', color: 'emerald' },
    // { label: 'Conversion Rate', value: '4.2%', icon: '📈', color: 'fuchsia' },
  ]
</script>

<template>
    <Head title="Dashboard" />
    
   

    <AppLayout :breadcrumbs="breadcrumbs">
       <!-- <div class="flex items-center justify-between gap-8 mb-8">
      <div>
        <h5
          class="block font-sans text-xl antialiased font-semibold leading-snug tracking-normal text-blue-gray-900">
          Welcome back
        </h5>
        <p class="block mt-1 font-sans text-base antialiased font-normal leading-relaxed text-gray-700">
          Click Create to Start a new channel
        </p>
      </div>
      <div class="flex flex-col gap-2 shrink-0 sm:flex-row">
        <button
          class="select-none rounded-lg border border-gray-900 py-2 px-4 text-center align-middle font-sans text-xs font-bold uppercase text-gray-900 transition-all hover:opacity-75 focus:ring focus:ring-gray-300 active:opacity-[0.85] disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none"
          type="button">
          New Channel
        </button>
        <button
          class="flex select-none items-center gap-3 rounded-lg bg-gray-900 py-2 px-4 text-center align-middle font-sans text-xs font-bold uppercase text-white shadow-md shadow-gray-900/10 transition-all hover:shadow-lg hover:shadow-gray-900/20 focus:opacity-[0.85] focus:shadow-none active:opacity-[0.85] active:shadow-none disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none"
          type="button">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"
            stroke-width="2" class="w-4 h-4">
            <path
              d="M6.25 6.375a4.125 4.125 0 118.25 0 4.125 4.125 0 01-8.25 0zM3.25 19.125a7.125 7.125 0 0114.25 0v.003l-.001.119a.75.75 0 01-.363.63 13.067 13.067 0 01-6.761 1.873c-2.472 0-4.786-.684-6.76-1.873a.75.75 0 01-.364-.63l-.001-.122zM19.75 7.5a.75.75 0 00-1.5 0v2.25H16a.75.75 0 000 1.5h2.25v2.25a.75.75 0 001.5 0v-2.25H22a.75.75 0 000-1.5h-2.25V7.5z">
            </path>
          </svg>
          Add user
        </button>
      </div>
    </div> -->




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
                &nbsp;&nbsp;Channels&nbsp;&nbsp;
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
          <!-- <div class="absolute grid w-5 h-5 top-2/4 right-3 -translate-y-2/4 place-items-center text-blue-gray-500">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
              stroke="currentColor" aria-hidden="true" class="w-5 h-5">
              <path stroke-linecap="round" stroke-linejoin="round"
                d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"></path>
            </svg>
          </div> -->
          <!-- <input
            class="peer h-full w-full rounded-[7px] border border-blue-gray-200 border-t-transparent bg-transparent px-3 py-2.5 !pr-9 font-sans text-sm font-normal text-blue-gray-700 outline outline-0 transition-all placeholder-shown:border placeholder-shown:border-blue-gray-200 placeholder-shown:border-t-blue-gray-200 focus:border-2 focus:border-gray-900 focus:border-t-transparent focus:outline-0 disabled:border-0 disabled:bg-blue-gray-50"
            placeholder=" " />
          <label
            class="before:content[' '] after:content[' '] pointer-events-none absolute left-0 -top-1.5 flex h-full w-full select-none !overflow-visible truncate text-[11px] font-normal leading-tight text-gray-500 transition-all before:pointer-events-none before:mt-[6.5px] before:mr-1 before:box-border before:block before:h-1.5 before:w-2.5 before:rounded-tl-md before:border-t before:border-l before:border-blue-gray-200 before:transition-all after:pointer-events-none after:mt-[6.5px] after:ml-1 after:box-border after:block after:h-1.5 after:w-2.5 after:flex-grow after:rounded-tr-md after:border-t after:border-r after:border-blue-gray-200 after:transition-all peer-placeholder-shown:text-sm peer-placeholder-shown:leading-[3.75] peer-placeholder-shown:text-blue-gray-500 peer-placeholder-shown:before:border-transparent peer-placeholder-shown:after:border-transparent peer-focus:text-[11px] peer-focus:leading-tight peer-focus:text-gray-900 peer-focus:before:border-t-2 peer-focus:before:border-l-2 peer-focus:before:!border-gray-900 peer-focus:after:border-t-2 peer-focus:after:border-r-2 peer-focus:after:!border-gray-900 peer-disabled:text-transparent peer-disabled:before:border-transparent peer-disabled:after:border-transparent peer-disabled:peer-placeholder-shown:text-blue-gray-500">
            Search
          </label> -->
        </div>
      </div>
    </div>
 
     
     
       <p 
          
        ></p>
          
    
          
    
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 xl:grid-cols-4 gap-6">
      <div
        v-for="metric in metrics"
        :key="metric.label"
        class="bg-white shadow rounded-lg p-6 flex items-center justify-between"
      >
        <div>
          <h3 class="text-sm font-medium text-gray-500">{{ metric.label }}</h3>
          <p class="text-2xl font-semibold text-gray-900">{{ metric.value }}</p>
        </div>
        <div :class="`text-${metric.color}-500 bg-${metric.color}-100 rounded-full p-2`">
          <span class="text-xl">{{ metric.icon }}</span>
        </div>
      </div>
    </div>
    </AppLayout>
</template>
