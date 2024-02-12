<script setup >
import {watch,ref,onMounted} from 'vue';
import {useForm} from '@inertiajs/vue3'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';  
const cartListItems =  ref([]); 

const removeItem=async (id)=>{
    const response =  await axios.delete(`api/cart/removeToCart/${id}`);
    cartListItems.value = response.data.cartListItems;;
    console.log(response);
     
}
const fetchedData=async()=>{
    const response = await axios.get('api/cart/cartListItems');
    cartListItems.value = response.data.cartListItems;
    console.log(cartListItems.value);
}
const decreaseQTY =async (item)=>{
    if(item.qty > 1){
        const response = await axios.post(`api/cart/decreasedQTY/${item.id}`);
        console.log(response);
        cartListItems.value = response.data.cartListItems;
    }
}
const increaseQTY = async(item)=>{  
    const response = await axios.post(`api/cart/increasedQTY/${item.id}`);
    cartListItems.value = response.data.cartListItems;
}
 
const form  = useForm({
    amount : 77,
});
const submit = async()=>{
    await axios.post('/payment',form)
    .then((res)=>{
        console.log(res);
    }).catch((err)=>{
        console.log(err);
    })
}
onMounted(()=>{
    fetchedData();
})
</script>
<template>
    <AuthenticatedLayout>
        <div class="flex">
            <span v-for="cartItem in cartListItems" :key="cartItem.id"> 
             <a  href="#" class="block max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
                 <h4 class="px-2 py-2 font-bold text-white bg-green-500 rounded-full">{{ cartItem.products.name ?? null }}</h4> 
                 
                 <span>{{ cartItem.products.description }}</span>
                 <div class="mt-2 font-bold">Quantity</div>
                 <div>
                     <span><button  @click="decreaseQTY(cartItem)" class="px-2 py-2 text-white bg-red-500 rounded"><i class="bi bi-dash-circle-fill"></i></button></span>
                     <span class="px-4">{{  cartItem.qty }}</span>
                     <span><button @click="increaseQTY(cartItem)" class="px-2 py-2 text-white bg-green-500 rounded"><i class="bi bi-plus-circle-fill"></i></button></span>
                 </div>
                 <button class="mt-2 text-red-500" @click="removeItem(cartItem.id)">Remove</button>
             </a>
         </span>
        </div>
        <form @submit.prevent="submit">
            <input type="text" v-model="form.amount" disabled>
            <button @click="submit" class="px-4 py-4 mt-2 text-white bg-green-500 rounded-md" >CheckOut</button>
        </form>
        </AuthenticatedLayout>
</template>