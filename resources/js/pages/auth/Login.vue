<script setup lang="ts">
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Checkbox } from '@/components/ui/checkbox';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Spinner } from '@/components/ui/spinner';
import AuthBase from '@/layouts/AuthLayout.vue';
import axios from 'axios';
import { ref } from 'vue';

const email = ref('');
const password = ref('');
const remember = ref(false);
const processing = ref(false);
const accountType = ref('admin');
const error = ref<string | null>(null);

async function login() {
    processing.value = true;
    error.value = null;

    try {
        const response = await axios.post(
            `${import.meta.env.VITE_APP_URL}/api/login`,
            {
                email: email.value,
                password: password.value,
                accountType: 'admin',
            },
        );

        console.log('response.data:', response.data);
        console.log('response.data.token:', response.data.token);

        localStorage.setItem('token', response.data.token);
        // window.location.href = '/dashboard';
    } catch (err: any) {
        error.value = err.response?.data?.message || 'Login failed';
    } finally {
        processing.value = false;
    }
}
</script>

<template>
    <AuthBase
        title="Log in to your account"
        description="Enter your email and password below to log in"
    >
        <form @submit.prevent="login" class="flex flex-col gap-6">
            <div class="grid gap-6">
                <div class="grid gap-2">
                    <Label for="email">Email address</Label>
                    <Input
                        id="email"
                        type="email"
                        v-model="email"
                        required
                        autofocus
                        autocomplete="email"
                        placeholder="email@example.com"
                    />
                    <InputError :message="error" />
                </div>

                <div class="grid gap-2">
                    <Label for="password">Password</Label>
                    <Input
                        id="password"
                        type="password"
                        v-model="password"
                        required
                        autocomplete="current-password"
                        placeholder="Password"
                    />
                </div>

                <div class="flex items-center justify-between">
                    <Label for="remember" class="flex items-center space-x-3">
                        <Checkbox id="remember" v-model="remember" />
                        <span>Remember me</span>
                    </Label>
                </div>

                <div>
                    <input type="hidden" id="admin" v-model="accountType" />
                </div>

                <Button
                    type="submit"
                    class="mt-4 w-full"
                    :disabled="processing"
                >
                    <Spinner v-if="processing" />
                    Log in
                </Button>
            </div>
        </form>
    </AuthBase>
</template>
