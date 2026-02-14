<script setup lang="ts">
import AppLayout from '@/layouts/app/AppSidebarLayout.vue';
import type { BreadcrumbItemType } from '@/types';
import { router } from '@inertiajs/vue3';
import axios from 'axios';
import { onMounted, ref, watch } from 'vue';

interface Props {
    breadcrumbs?: BreadcrumbItemType[];
}

withDefaults(defineProps<Props>(), {
    breadcrumbs: () => [],
});

// ---------------------------
// Self-contained route protection
// ---------------------------
const user = ref<any | null>(null);
const token = ref<string | null>(null);

onMounted(() => {
    const storedToken = localStorage.getItem('token');
    const storedUser = localStorage.getItem('user');

    token.value = storedToken;
    user.value = storedUser ? JSON.parse(storedUser) : null;

    // 🚨 Redirect to login if not logged in
    if (!token.value || !user.value) {
        router.visit('/');
    } else {
        // Attach token to axios globally
        axios.defaults.headers.common['Authorization'] =
            `Bearer ${token.value}`;
    }
});

// Watch token to auto-redirect if logged out dynamically
watch(token, (newVal) => {
    if (!newVal) {
        router.visit('/');
    }
});
</script>

<template>
    <!-- Wrap all pages -->
    <AppLayout :breadcrumbs="breadcrumbs">
        <slot />
    </AppLayout>
</template>
