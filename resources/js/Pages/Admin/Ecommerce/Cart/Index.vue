<script setup >
import {ref,onMounted,computed} from 'vue';
import {useForm,usePage,router} from '@inertiajs/vue3'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';  
import {getTotalAmount} from '@/Composables/helper/TotalAmount.js';
const cartListItems =  ref([]);  
const paymentMess = computed(()=>usePage().props.message);
 
const form  = useForm({
    total_amount : 0,
});
const removeItem=async (id)=>{
    const response =  await axios.delete(`api/cart/removeToCart/${id}`);
    cartListItems.value = response.data.cartListItems;
    form.total_amount = getTotalAmount(cartListItems); 
}
const fetchedData=async()=>{
    const response = await axios.get('api/cart/cartListItems');
    cartListItems.value = response.data.cartListItems; 
    form.total_amount = getTotalAmount(cartListItems); 
}
const update_qty =async(item,asc)=>{ 
    const response = await axios.post(`api/cart/update_qty/${item.id}`,{ params: { increasing: asc } });
    cartListItems.value = response.data.cartListItems;
    form.total_amount = getTotalAmount(cartListItems);
}
const submit = async()=>{
    await axios.post('/payment',form)
    .then((res)=>{
        window.location.href = res.data.data.redirectUrl; 
    }) 
}
onMounted(()=>{
    fetchedData(); 
})
</script>
<template>
    <AuthenticatedLayout>
        <div v-if="paymentMess">
            <div class="px-10 py-10 bg-green-200">{{ paymentMess }}</div>      
        </div>
        <div class="flex">
            <span v-for="cartItem in cartListItems" :key="cartItem.id"> 
             <a  href="#" class="block max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
                 <h4 class="px-2 py-2 font-bold text-white bg-green-500 rounded-full">{{ cartItem.products.name ?? null }}</h4> 
                 <span>{{ cartItem.products.description }}</span>
                 <div class="mt-2 font-bold">Quantity</div>
                 <div> 
                     <span><button v-show="cartItem.qty >1" @click="update_qty(cartItem,false)"  class="px-2 py-2 text-white bg-red-500 rounded"><i class="bi bi-dash-circle-fill"></i></button></span>
                     <span class="px-4">{{  cartItem.qty }}</span>
                     <span><button @click="update_qty(cartItem,true)" class="px-2 py-2 text-white bg-green-500 rounded"><i class="bi bi-plus-circle-fill"></i></button></span>
                 </div>
                 <div class="flex"> 
                    <div class="mt-10">SubTotal Price: {{ cartItem.products.price * cartItem.qty }}</div>
                    <button class="mt-2 text-red-500" @click="removeItem(cartItem.id)">Remove</button>
                 </div>
             </a>
         </span>
        </div>
        <form @submit.prevent="submit"> 
            <input type="text" v-model="form.total_amount"    disabled>
            <button @click="submit" class="px-4 py-4 mt-2 text-white bg-green-500 rounded-md" >CheckOut</button>
        </form>
        </AuthenticatedLayout>
</template>