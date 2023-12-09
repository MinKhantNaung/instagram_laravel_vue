<script setup>
import { onMounted, ref, toRefs } from 'vue';
import { Link } from '@inertiajs/vue3';
import MainLayout from '@/Layouts/MainLayout.vue';

import 'vue3-carousel/dist/carousel.css'
import { Carousel, Slide, Navigation } from 'vue3-carousel'

import DotHorizontal from 'vue-material-design-icons/DotsHorizontal.vue'

let windowWidth = ref(window.innerWidth)
let currentSlide = ref(0)
let currentPost = ref(null)
let openOverlay = ref(false)

const props = defineProps({
    posts: Object,
    allUsers: Object
})

const { posts, allUsers } = toRefs(props)

onMounted(() => {
    window.addEventListener('resize', () => {
        windowWidth.value = window.innerWidth
    })
})
</script>

<template>
    <Head title="Instagram" />

    <MainLayout>
        <div class="mx-auto lg:pl-0 md:pl-[80px] pl-0">
            <carousel v-model="currentSlide" :items-to-show="windowWidth >= 768 ? 8 : 6" :items-to-scroll="4"
                :wrap-around="true" :transition="500" snapAlign="start" class="max-w-[700px] mx-auto">
                <slide v-for="slide in 10" :key="slide">
                    <Link href="/" class="relative mx-auto text-center mt-4 px-2 cursor-pointer">
                    <div
                        class="absolute z-[-1] -top-[5px] left-[4px] rounded-full rotate-45 w-[64px] h-[64px] contrast-[1.3] bg-gradient-to-t from-yellow-300 to-purple-500 via-red-500">
                        <div class="rounded-full ml-[3px] mt-[3px] w-[58px] h-[58px] bg-white"></div>
                    </div>
                    <img class="rounded-full w-[56px] h-[56px] -mt-[1px]" src="https://picsum.photos/id/54/300/320">
                    <div class="text-xs mt-2 w-[60px] truncate text-ellipsis overflow-hidden">NAME HERE</div>
                    </Link>
                </slide>

                <template #addons>
                    <!-- Pagination and Navigation in here  -->
                    <Navigation />
                </template>
            </carousel>

        </div>
    </MainLayout>
</template>

<style scoped>
.carousel_prev,
.carousel_next,
.carousel_prev:hover,
.carousel_next:hover {
    color: rgb(49, 49, 49);
    background-color: rgb(255, 255, 255);
    border-radius: 100%;
    margin: 0 20px;
}
</style>
