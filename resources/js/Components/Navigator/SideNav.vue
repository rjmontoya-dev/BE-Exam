<script setup>
import {Link} from "@inertiajs/vue3";

const links = [
    {
        label: 'Dashboard',
        icon: 'bi bi-columns-gap',
        route: 'dashboard',
        base_route: 'dashboard',
    },
      {
        label: 'Products',
        icon: 'bi bi-box-seam',
        route: 'products',
        base_route: 'products',
    },
      {
        label: 'Create Product',
        icon: 'bi bi-ui-radios',
        route: 'create-products',
        base_route: 'create-products',
    },
    {
        label: 'Videos',
        icon: 'bi bi-collection-play',
        route: 'videos',
        base_route: 'videos',
    },

];

</script>

<template>
    <div class="fixed  w-[16rem] h-screen hidden sm:block  bg-gray-700    ">
        <div class="text-center mt-2 font-extrabold text-white text-[24px]">
            <h1>ADMIN PANEL</h1>
        </div>
        <ul class="h-full mt-6">
            <template v-for="link in links">
                <li v-if="link.access ? isInRole(link.access) : true"
                    class="mb-2 cursor-pointer hover:bg-white-100  hover:font-semibold p-2 px-4 rounded-lg"
                    :class="{'bg-primary-100 font-semibold': route().current(link.base_route)}"
                >
                    <Link :href="route(link.route)" class="flex gap-4"
                          :class="route().current(link.base_route) ? 'text-white text-[18px] ' : 'text-gray-400 font-bold  '">
                        <i :class="link.icon"></i>
                        {{ link.label }}
                    </Link>
                </li>
            </template>
        </ul>
    </div>
</template>

<style scoped>

</style>
