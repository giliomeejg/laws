<template>
    <Head title="Dashboard" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                law
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <div class="mb-4">
                            <Link
                                class="px-6 py-2 mb-2 text-green-100 bg-green-500 rounded"
                                :href="route('laws.create')"
                            >
                                Laws Create
                            </Link>
                        </div>
                        <table>
                            <thead class="font-bold bg-gray-300 border-b-2">
                                <td class="px-4 py-2">ID</td>
                                <td class="px-4 py-2">URL</td>
                                <td class="px-4 py-2">Words</td>
                                <td class="px-4 py-2">Action</td>
                            </thead>
                            <tbody>
                                <tr v-for="law in laws.data" :key="law.id">
                                    <td class="px-4 py-2">{{ law.id }}</td>
                                    <td class="px-4 py-2">{{ law.law_url }}</td>
                                    <td class="px-4 py-2">
                                        {{ law.number_of_words }}
                                    </td>
                                    <td class="px-4 py-2 font-extrabold">
                                        <Link
                                            class="text-green-700"
                                            :href="route('laws.edit', law.id)"
                                        >
                                            Edit
                                        </Link>
                                        <Link
                                            @click="destroy(law.id)"
                                            class="text-red-700"
                                            >Delete</Link
                                        >
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <pagination :links="laws.links" />
                    </div>
                </div>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>

<script>
import BreezeAuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import BreezeNavLink from "@/Components/NavLink.vue";
import { Head } from "@inertiajs/inertia-vue3";
import { Link } from "@inertiajs/inertia-vue3";
export default {
    components: {
        BreezeAuthenticatedLayout,
        Head,
        BreezeNavLink,
        Link,
    },
    props: {
        laws: Object,
    },
    methods: {
        destroy(id) {
            this.$inertia.delete(route("laws.destroy", id));
        },
    },
};
</script>
