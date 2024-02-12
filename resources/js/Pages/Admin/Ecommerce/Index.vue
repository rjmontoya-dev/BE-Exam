<script setup>
import { onMounted,computed,ref,watch } from 'vue'; 
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'; 

const productList = ref([]);
const qty = ref(0);
const fetchData = async () => {
    try {
    const response = await axios.get('api/products/list');
    productList.value = response.data.products;
        console.log(productList.value);
    } catch (error) {
    console.error(error);
    }
};
const addCart=async(item)=>{
    axios.post(`api/cart/addToCart/${item}`)
    .then((res)=>{
        console.log(res);
    })
    .catch((err)=>{
        console.log(err);
    })
}
const returnImagePath = (value)=>{
    return value.substring(25,value.length);
}
onMounted(()=>{
    fetchData(); 
})
</script>
<template>
    <AuthenticatedLayout>
        <div>
            <span v-for="product in productList.data" :key="product.id"> 
                <a href="#" class="block max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
                    <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">{{ product.name }}</h5>
                    <span v-for="(image) in product.media">
                        <img class="flex object-cover h-20 rounded w-18" :src="returnImagePath(image.original_url)" >
                    </span>
                     
                    <h4>{{ product.description }}</h4> 
                    <button @click="addCart(product.id)" class="px-2 py-2 text-white bg-green-500 rounded">
                        Add to Cart
                    </button>
                </a>
            </span>
        </div>
    </AuthenticatedLayout>
</template>