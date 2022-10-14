<script setup>
import { Head, Link } from "@inertiajs/inertia-vue3";

defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    laravelVersion: String,
    phpVersion: String,
    number_of_words: Number,
    nr_words_per_minute: Number,
    how_long_to_read: Object,
});
</script>

<template>
    <Head title="Welcome" />

    <div
        class="relative flex items-top justify-center min-h-screen bg-gray-100 dark:bg-gray-900 sm:items-center sm:pt-0"
    >
        <div
            v-if="canLogin"
            class="hidden fixed top-0 right-0 px-6 py-4 sm:block"
        >
            <Link
                v-if="$page.props.auth.user"
                :href="route('dashboard')"
                class="text-sm text-gray-700 dark:text-gray-500 underline"
                >Dashboard</Link
            >

            <template v-else>
                <Link
                    :href="route('login')"
                    class="text-sm text-gray-700 dark:text-gray-500 underline"
                    >Log in</Link
                >

                <Link
                    v-if="canRegister"
                    :href="route('register')"
                    class="ml-4 text-sm text-gray-700 dark:text-gray-500 underline"
                    >Register</Link
                >
            </template>
        </div>

        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <h1 class="text-2xl">
                Finding all the laws in South Africa overwhelming?
            </h1>
            <h1 class="text-2xl">{{ number_of_words }} words</h1>
            <h1 class="text-2xl">
                <span v-if="how_long_to_read.y > 0"
                    >{{ how_long_to_read.y }} years</span
                >
                <span v-if="how_long_to_read.m > 0"
                    >{{ how_long_to_read.m }} months</span
                >
                <span v-if="how_long_to_read.d > 0"
                    >{{ how_long_to_read.d }} days</span
                >
                <span v-if="how_long_to_read.h > 0"
                    >{{ how_long_to_read.h }} hours</span
                >
                <span v-if="how_long_to_read.i > 0"
                    >{{ how_long_to_read.i }} minutes</span
                >
                to read
            </h1>
        </div>
    </div>
</template>
