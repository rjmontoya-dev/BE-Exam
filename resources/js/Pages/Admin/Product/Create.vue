<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue"
import {useForm,usePage } from '@inertiajs/vue3'
import {computed, onMounted,ref} from 'vue';
import axios from "axios"
import TextInput from "@/Components/TextInput.vue";
import InputError from "@/Components/InputError.vue";
    const products = computed(()=> usePage().props.products);

    const formatDateForInput = (dateString) => {
        const dateObject = new Date(dateString);
        const formattedDate = dateObject.toISOString().slice(0, 16);
        return formattedDate;
    };
    const form = useForm({
        id: products.value?.id !== null ? products.value?.id : null,
        name: products.value?.name !== null ? products.value?.name : null,
        category: products.value?.category !== null ? products.value?.category : null,
        description:products.value?.description !== null ? products.value?.description : null,
        date_time:null,
        images:[],
    })
    const formErrors = ({});
    const previewImage = [];
    onMounted(()=>{
        if(products.value?.created_at){
            form.date_time = formatDateForInput(products.value?.created_at);
        }
    })

    const onChange = (e)=>{
      for (let i = 0; i < e.target.files.length; i++) {
        form.images.push(e.target.files[i]);
        previewImage.push(URL.createObjectURL(form.images[i]));
      }
    }
    const submit = async ()=>{
         const config = {
            headers: {
                'content-type': 'multipart/form-data'
            }
        }
        console.log(form)
;        if(form.id){
            const apiurl = `/api/products/${form.id}/update`;
             await axios.post(apiurl,form,config,)
            .then((res)=>{
                window.location.href = '/products';
            })
            .catch((err)=>{

                console.log(err);
            })
        }else{
            await axios.post('api/products/store',form,config,)
            .then((res)=>{
                console.log(res);
                window.location.href = '/products';
            })
            .catch((err)=>{
                formErrors.value = err.response.data.errors;
            })
        }

    }
</script>
<template>
    <AuthenticatedLayout>
        <form class="" @submit.prevent="submit"  enctype="multipart/form-data">
            <div class="grid gap-6 mb-6 md:grid-cols-2">
                <div>
                    <label   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Product name</label>
                    <TextInput :modelValue="form.name" @update:modelValue="form.name = $event"  type="text" name="name"   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Name of the product" required></TextInput>
                </div>
                <div>
                    <label   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Product Category</label>
                    <TextInput :modelValue="form.category" @update:modelValue="form.category = $event"  type="text" name="category"   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Category of the product" required></TextInput>
                </div>
                <div>
                    <label  class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Product Description</label>
                    <textarea v-model="form.description"  id="description" name="description"   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Description of the product" required></textarea>
                </div>
                <div>
                    <label   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Date & Time</label>
                    <TextInput :modelValue="form.date_time" @update:modelValue="form.date_time = $event"  type="datetime-local" name="date_time"   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"  required></TextInput>
                </div>
                <span v-if="products">
                    <div v-for="product in products.media">
                        {{ product.file_name }}
                    </div>
                </span>
                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="file_input">Upload file</label>
                    <input    type="file" multiple  name="images"  @change="onChange"  />
                </div>
            </div>
                <div class="grid grid-cols-6  mb-8"  >
                    <div v-for="src in previewImage" :key="src" >
                        <img class="w-auto h-20  " :src="src">
                    </div>
                </div>
            <button type="submit" class="bg-blue-500 px-2 py-2 w-40 rounded-md text-white mb-10">Submit</button>
        </form>
    </AuthenticatedLayout>
</template>
