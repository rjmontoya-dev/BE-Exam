<script setup>
import TopNav from "@/Components/Navigator/TopNav.vue";
import SideNav from "@/Components/Navigator/SideNav.vue";
defineProps({
    title: String,
});
</script>
<template>
    <div class="overflow-hidden">
        <div class="w-screen h-screen bg-gray-100 flex flex-col overflow-hidden">
           <TopNav/>
            <div class="flex-grow flex">
                <SideNav/>
                <div class="flex-grow rounded-lg">
                    <div class="px-4 pb-4">
                        <slot name="page-header"/>
                    </div>
                    <main class="overflow-y-auto max-h-[calc(110vh-7rem)] fixed  right-0 z-1 w-[calc(170vh)] px-8 text-slate-700 mt-20 ">
                        <slot/>
                    </main>
                </div>
            </div>
        </div>
    </div>
</template>
