<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { dashboard } from '@/routes';
import { type BreadcrumbItem } from '@/types';
import { Head, Link } from '@inertiajs/vue3';
import { computed } from 'vue';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: dashboard().url,
    },
];

const props = defineProps<{
    stats?: {
        // 💡 Added '?' to make it optional
        channelsCount: number;
        employeesCount: number;
        clientsCount: number;
        onlineCount: number;
        offlineCount: number;
    };
}>();

const metrics = computed(() => [
    {
        label: 'Channels',
        value: (props.stats?.channelsCount ?? 0).toLocaleString(),
        icon: '🎯',
        href: '/channels', // Hardcoded path
    },
    {
        label: 'Employees',
        value: (props.stats?.employeesCount ?? 0).toLocaleString(),
        icon: '🎫',
        href: '/employees',
    },
    {
        label: 'Clients',
        value: (props.stats?.clientsCount ?? 0).toLocaleString(),
        icon: '🧑‍💼',
        href: '/clients',
    },
    {
        label: 'Online Now',
        value: (props.stats?.onlineCount ?? 0).toLocaleString(),
        icon: '🟢',
        href: '/employees?status=online',
        color: 'green',
    },
    {
        label: 'Offline',
        value: (props.stats?.offlineCount ?? 0).toLocaleString(),
        icon: '⚪',
        href: '/employees?status=offline',
        color: 'gray',
    },
]);

// const metrics = [
//     // { label: 'Pending Payouts', value: 'R12,450', icon: '💰', color: 'yellow' },
//     // { label: 'Completed Payouts', value: 'R38,200', icon: '✅', color: 'green' },
//     // { label: 'Refunds Paid', value: 'R3,800', icon: '✅', color: 'emerald' },
//     { label: 'Channels', value: '150', icon: '🎯', color: 'teal' },
//     { label: 'Employees', value: '248', icon: '🎫', color: 'green' },
//     // { label: 'Manage Clients', value: '12', icon: '📅', color: 'indigo' },

//     { label: 'Clients', value: '32', icon: '🧑‍💼', color: 'blue' },
//     // { label: 'Affiliates Active', value: '18', icon: '🔗', color: 'cyan' },
//     // { label: 'Refund Requests', value: '4', icon: '🔁', color: 'red' },
//     // { label: 'Feedback Received', value: '76', icon: '💬', color: 'pink' },
//     // { label: 'Manage Facilities', value: '5', icon: '🛠️', color: 'gray' },
//     // { label: 'Platform Revenue (MTD)', value: 'R24,600', icon: '💵', color: 'blue' },
//     // { label: 'Profit (MTD)', value: 'R6,800', icon: '📊', color: 'emerald' },
//     // { label: 'Conversion Rate', value: '4.2%', icon: '📈', color: 'fuchsia' },
// ];
</script>

<template>
    <Head title="Dashboard" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="grid grid-cols-1 gap-6 p-6 sm:grid-cols-2 lg:grid-cols-5">
            <Link
                v-for="metric in metrics"
                :key="metric.label"
                :href="metric.href"
                class="group flex items-center justify-between rounded-lg border border-gray-100 bg-white p-6 shadow transition-all hover:border-blue-300 hover:shadow-md active:scale-95"
            >
                <div>
                    <h3
                        class="text-sm font-medium text-gray-500 transition-colors group-hover:text-blue-600"
                    >
                        {{ metric.label }}
                    </h3>
                    <p class="text-2xl font-bold text-gray-900">
                        {{ metric.value }}
                    </p>
                </div>

                <div
                    :class="[
                        'rounded-full p-3 transition-colors',
                        metric.label === 'Online Now'
                            ? 'bg-green-50 group-hover:bg-green-100'
                            : 'bg-gray-50 group-hover:bg-blue-50',
                    ]"
                >
                    <span
                        :class="[
                            'text-2xl',
                            metric.label === 'Online Now'
                                ? 'animate-pulse'
                                : '',
                        ]"
                    >
                        {{ metric.icon }}
                    </span>
                </div>
            </Link>
        </div>
    </AppLayout>
</template>
