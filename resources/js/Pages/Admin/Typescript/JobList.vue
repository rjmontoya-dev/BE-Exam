<script setup lang="ts">
import {PropType} from 'vue';
import Job from './types/Job';
    const props = defineProps({
        jobs: Array as PropType<Job[]>,
    })
    console.log(props.jobs);
</script>
<template> 
    <ul>
        <li v-for="job in props.jobs" :key="job.id">
            <h1>{{  job.title }}</h1>
            <h1>{{  job.location }}</h1>
            <h1>{{  job.salary }}</h1>
        </li>
    </ul>
</template>