<script setup>
import { onMounted, ref, toRefs } from 'vue';
import { Link, router } from '@inertiajs/vue3';
import MainLayout from '@/Layouts/MainLayout.vue';
import LikeSection from '@/Components/LikeSection.vue'
// showPostOverlay is for show post and comments when click view comments
import ShowPostOverlay from '@/Components/ShowPostOverlay.vue'

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

const addComment = (object) => {
    router.post(route('comments.store'), {
        user_id: object.user.id,
        post_id: object.post.id,
        text: object.comment
    }, {
        preserveState: true,
        onFinish: () => {
            updatePost(object)
        }
    })
}

const updatePost = (object) => {
    for (let i = 0; i < posts.value.data.length; i++) {
        const post = posts.value.data[i];

        if (post.id === object.post.id) {
            currentPost.value = post
        }
    }
}

const updateLike = (object) => {
    let deleteLike = false
    let id = null

    for (let i = 0; i < object.post.likes.length; i++) {
        const like = object.post.likes[i];

        if (like.user_id === object.user.id && like.post_id === object.post.id) {
            deleteLike = true
            id = like.id
        }
    }

    if (deleteLike) {
        router.delete(route('likes.destroy', {
            id: id
        }), {
            preserveState: true,
            onFinish: () => {
                updatePost(object)
            }
        })
    } else {
        router.post(route('likes.store'), {
            post_id: object.post.id
        }, {
            preserveState: true,
            onFinish: () => {
                updatePost(object)
            }
        })
    }
}
</script>

<template>
    <Head title="Instagram" />

    <MainLayout>
        <div class="mx-auto lg:pl-0 md:pl-[80px] pl-0">
            <carousel v-model="currentSlide" :items-to-show="windowWidth >= 768 ? 8 : 6" :items-to-scroll="4"
                :wrap-around="true" :transition="500" snapAlign="start" class="max-w-[700px] mx-auto">
                <slide v-for="user in allUsers" :key="user.id">
                    <Link :href="route('users.show', { 'id': user.id })"
                        class="relative mx-auto text-center mt-4 px-2 cursor-pointer">
                    <div
                        class="absolute z-[-1] -top-[5px] left-[4px] rounded-full rotate-45 w-[64px] h-[64px] contrast-[1.3] bg-gradient-to-t from-yellow-300 to-purple-500 via-red-500">
                        <div class="rounded-full ml-[3px] mt-[3px] w-[58px] h-[58px] bg-white"></div>
                    </div>
                    <img class="rounded-full w-[56px] h-[56px] -mt-[1px]" :src="`storage/user_images/${user.file}`">
                    <div class="text-xs mt-2 w-[60px] truncate text-ellipsis overflow-hidden">
                        {{ user.name }}
                    </div>
                    </Link>
                </slide>

                <template #addons>
                    <!-- Pagination and Navigation in here  -->
                    <Navigation />
                </template>
            </carousel>

            <!-- SHOW POSTS -->
            <div id="posts" v-for="post in posts.data" :key="post.id" class="px-4 max-w-[600px] mx-auto mt-10">
                <div class="flex items-center justify-between py-2">
                    <div class="flex items-center">
                        <Link href="/" class="flex items-center">
                        <img :src="`storage/user_images/${post.user.file}`" class="rounded-full w-[38px] h-[38px]">
                        <div class="ml-4 font-extrabold text-[15px]">{{ post.user.name }}</div>
                        </Link>
                        <div class="flex items-center text-[15px] text-gray-500">
                            <span class="mt-5 ml-2 mr-[5px] text-[35px]">.</span>
                            <div>{{ post.created_at }}</div>
                        </div>
                    </div>

                    <DotHorizontal :size="27" class="cursor-pointer" />
                </div>

                <div class="bg-black rounded-lg w-full min-h-[400px] flex items-center">
                    <img class="mx-auto w-full" :src="`storage/post_images/${post.file}`">
                </div>

                <LikeSection @like="updateLike($event)" :post="post" />

                <div class="text-black font-extrabold py-1">{{ post.likes.length }} Likes</div>
                <div>
                    <span class="text-black font-extrabold">{{ post.user.name }}</span>
                    {{ post.text }}
                </div>
                <button @click.prevent="openOverlay = true; currentPost = post" class="text-gray-500 font-extrabold py-1">
                    View all {{ post.comments.length }} comments
                </button>
            </div>

            <div class="pb-20"></div>

        </div>
    </MainLayout>

    <ShowPostOverlay v-if="openOverlay" :post="currentPost" @addComment="addComment($event)"
        @updateLike="updateLike($event)" @deleteSelected="deleteSelected($event)" @closeOverlay="openOverlay = false" />
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
