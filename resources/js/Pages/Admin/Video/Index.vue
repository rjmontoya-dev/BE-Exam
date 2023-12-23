<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import VideoPlayer from './VideoPlayer.vue';
import {computed,ref,onMounted} from 'vue';

const videos = ref([]);
const vidUrl = ref();
 const fetchVideoList = async () => {
    try {
    const response = await axios.get('api/videolist');
    videos.value = response.data.videonames;
    vidUrl.value = 'player/'+videos.value[0]+'.mp4';
    } catch (error) {
    console.error(error);
    }
};
const playVideo = (vid) => {
    vidUrl.value = 'player/'+vid+'.mp4';
}
onMounted(() => {
    fetchVideoList();
})
</script>
<template>
    <AuthenticatedLayout>

        <div class="mx-auto" style="max-width: 600px;"> <!-- Adjust the max-width as needed -->
            <video-player ref="videoPlayer" class="video-js" style="width: 100%; height: 100%;" :videoUrl="vidUrl" />
            <div v-for="video in videos" class="mx-auto mt-10">
                <div  @click="playVideo(video)" class="flex bg-gray-200 gap-2 px-4 py-2 rounded-md ">
                    <i class="bi bi-card-image text-[50px]"></i>
                    <button>{{ video }}.mp4</button>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
<style scoped>
.mx-auto {
  margin-left: auto;
  margin-right: auto;
}
</style>
