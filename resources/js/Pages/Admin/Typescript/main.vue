<script setup lang="ts">
import {ref} from 'vue';
import Job from './types/Job';
import OrderTerm from './types/OrderTerm';
import JobList from './JobList.vue';
 let myJob = ref<Job[]>([
    {title : "BE Dev", location: "hello QC", salary: 10000, id: 1},
    {title : "FE Dev", location: "hello QC", salary: 20000, id: 1},
    {title : "QA", location: "hello QC", salary: 30000, id: 1},
    {title : "Sys Ad", location: "hello QC", salary: 40000, id: 1}
]);

const order = ref<OrderTerm>('title');
const handleClick = ( term : OrderTerm ) =>{
    
    order.value = term;
    console.log(order);
}
</script>
<template> 
    <button @click="handleClick('title')">Order by title</button>
    <button @click="handleClick('location')">Order by location</button>
    <button @click="handleClick('salary')"> Order by salary</button>
    <JobList :jobs="myJob"></JobList>
    <h1>hello</h1>
</template> 

