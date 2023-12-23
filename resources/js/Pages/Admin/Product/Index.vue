<script setup>
import { onMounted,computed,ref,watch } from 'vue';
import {debounce} from "lodash";
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import TextInput from "@/Components/TextInput.vue";
import axios from 'axios';
import { Link } from '@inertiajs/vue3';

const productList = ref([]);
const filtercategory = ref([]);
const search = ref("");
 const fetchData = async () => {
    try {
    const response = await axios.get('api/products/list');
    productList.value = response.data.products;

    } catch (error) {
    console.error(error);
    }
};
 const debouncedSearch = debounce(async (queryString) => {

      try {
        const response = await axios.get('api/products/list', { params: { query: queryString } });
        productList.value = response.data.products;

      } catch (error) {
        console.error(error);
      }
    }, 500);
watch(search,debouncedSearch);
const  pageButton= async(link)=>{
    try{
        const response =  await axios.get(link);
        productList.value = response.data.products;
    } catch (error) {
        console.log(error);
    }
}
const formatDateForInput = (dateString) => {
        const dateObject = new Date(dateString);
        const formattedDate = dateObject.toISOString().slice(0, 16);
        return formattedDate;
    };
const removeItem= async(item_id)=>{
    try{
        const response = await axios.delete(`api/products/destroy/${item_id}`);
        productList.value = response.data.products;
    }catch (error) {
        console.log(error);
    }
}
const returnImagePath = (value)=>{
    return value.substring(25,value.length);
}


watch(filtercategory,async (value)=>{
     try {
        const response = await axios.get('api/products/list', { params: { categorySearch: value } });
        productList.value = response.data.products;
      } catch (error) {
        console.error(error);
      }
})
onMounted(()=>{
    fetchData();
    console.log('mounted')
})
</script>
<template>
    <AuthenticatedLayout>
        <div class="relative overflow-x-hidden bg-gray-200 rounded-md px-8 py-8">
             <Link :href="route('create-products')" class="ml-auto bg-blue-500 px-2 py-2 rounded-md text-white mb-10">
            Create Product
        </Link>
            <div class="mt-8 mb-2">
                <label class="text-gray-500 italic">Search: </label>
                <TextInput type="text" :modelValue="search" @update:modelValue="search = $event"></TextInput>
                <label class="text-gray-500 italic"> Filter by category: </label>
                <select class="h-9 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" v-model="filtercategory">
                      <option value="" disabled>--Select--</option>
                    <option v-for="product in productList.data">{{ product.category }}</option>
                </select>
            </div>

            <table class="w-full  text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            #
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Name
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Category
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Description
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Date & TIme
                        </th>
                         <th scope="col" class="px-6 py-3">
                            Images
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Action
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <template v-if="productList.data?.length > 0">
                         <tr v-for=" (product,index)  in productList.data" class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <td class="px-6 py-4">{{  index+1 }}</td>
                        <td class="px-6 py-4">{{ product.name }}</td>
                        <td class="px-6 py-4">{{ product.category }}</td>
                        <td class="px-6 py-4">{{ product.description }}</td>
                        <td class="px-6 py-4">{{ formatDateForInput(product.created_at )}}</td>
                        <td class="px-6 py-4" >
                            <span v-for="(image,index) in product.media">
                                <img class=" flex rounded w-18 h-10 object-cover" :src="returnImagePath(image.original_url)" >
                            </span>
                        </td>
                        <td class="px-6 py-4"><a @click="removeItem(product.id)"><i class="text-red-500 bi bi-trash"></i></a>
                            <Link :href="route('edit-products', { id: product.id })"><i class="text-teal-500 bi bi-pencil-square"></i></Link>
                        </td>
                    </tr>
                    </template>
                    <template v-else>
                      <tr>
                        <td colspan="99" class="text-center py-6 px-3 text-sm text-gray-600">
                            <div class="flex justify-center items-center">
                            <div class="">
                                <img class="w-[10rem] opacity-40" src="/image/default/empty-box.png">
                                <p class="text-gray-300 text-lg mt-3">Data not found</p>
                            </div>
                            </div>
                        </td>
                        </tr>
                    </template>
                </tbody>
            </table>
            <div>

            </div>
            <nav class="mt-4 block sm:flex items-center text-center justify-between pt-0" aria-label="Table navigation">
                <span class="text-sm text-gray-500">Showing <span class="">{{ `${productList.from ?? '0'} to ${productList.to ?? '0'}` }}</span> of <span
                class="">{{ productList.total }}</span><span> entries</span></span>
                <nav>
                    <ul class="flex items-center justify-center gap-1  h-8 text-sm">
                        <li >
                            <a @click="pageButton(productList.prev_page_url)" class="flex items-center rounded-full justify-center link px-3 h-8 w-8 ml-0 leading-tight text-gray-500 bg-white hover:text-gray-500 hover:bg-blue-300 border border-gray-300 "
                                >
                                <i class="bi bi-chevron-left"></i>
                            </a>
                        </li>
                         <template v-for="link in productList.links" :key="link.label">
                            <li v-if="!isNaN(link.label)">
                                <a
                                    :class="{ 'active !bg-blue-500 text-white hover:!bg-blue-300 ': link.active }"
                                    class="cursor-pointer flex items-center rounded-full justify-center px-4 w-8 h-8  text-gray-500 bg-white border border-gray-300   hover:text-gray-700"
                                    @click="pageButton(link.url)"  >{{ link.label }}
                                </a>
                            </li>
                        </template>
                        <li >
                            <a @click="pageButton(productList.next_page_url)" class="flex items-center rounded-full justify-center link px-3 h-8 w-8 ml-0 leading-tight text-gray-500 bg-white hover:text-gray-500 hover:bg-blue-300 border border-gray-300 "
                               >
                                    <i class="bi bi-chevron-right"></i>
                            </a>
                        </li>
                    </ul>
                </nav>
            </nav>
        </div>
    </AuthenticatedLayout>
</template>
