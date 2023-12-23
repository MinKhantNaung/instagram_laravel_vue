<script setup>
import { reactive, ref, toRefs } from 'vue';
import { router } from '@inertiajs/vue3';
import MainLayout from '@/Layouts/MainLayout.vue';
import ContentOverlay from '@/Components/ContentOverlay.vue'
import ShowPostOverlay from '@/Components/ShowPostOverlay.vue';

import Cog from 'vue-material-design-icons/Cog.vue'
import Grid from 'vue-material-design-icons/Grid.vue'
import PlayBoxOutline from 'vue-material-design-icons/PlayBoxOutline.vue'
import BookmarkOutline from 'vue-material-design-icons/BookmarkOutline.vue';
import AccountBoxOutline from 'vue-material-design-icons/AccountBoxOutline.vue'

const data = reactive({
    post: null
})

const form = reactive({
    file: null
})

const props = defineProps({
    user: Object,
    postsByUser: Object,
})

const { user, postsByUser } = toRefs(props)

const getUploadedImage = (e) => {
    form.file = e.target.files[0];

    router.post('/users', form, {
        preserveState: true,
        replace: true,
    })
};

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
    for (let i = 0; i < postsByUser.value.data.length; i++) {
        const post = postsByUser.value.data[i];

        if (post.id === object.post.id) {
            data.post = post
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
            preserveScroll: true,
            onFinish: () => {
                updatePost(object)
            }
        })
    } else {
        router.post(route('likes.store'), {
            post_id: object.post.id
        }, {
            preserveState: true,
            preserveScroll: true,
            onFinish: () => {
                updatePost(object)
            }
        })
    }
}

const deleteFunc = (object) => {
    let url = ''

    if (object.deleteType === 'post') {
        url = `/posts/${object.id}`;
        setTimeout(() => datal.post = null, 100)
    } else {
        url = `/comments/${object.id}`
    }

    router.delete(url, {
        preserveState: true,
        preserveScroll: true,
        onFinish: () => updatePost(object)
    })

    if (object.deleteType === 'post') {
        data.post = null
    }
}

</script>

<template>
    <Head title="Instagram" />

    <MainLayout>
        <div class="pt-2 md:pt-6"></div>
        <div class="max-w-[880px] lg:ml-0 md:ml-[80px] md:pl-20 px-4 w-[100vw]">
            <div class="flex items-center md:justify-between">
                <label for="file-user">
                    <div class="rounded-full md:w-[200px] md:h-[200px] w-[100px] h-[100px] bg-red-500">
                        <img class="object-cover cursor-pointer rounded-full md:w-[200px] w-[100px] h-[100px] md:h-[200px]"
                            :src="`/storage/user_images/${user.file}`">
                    </div>
                </label>
                <input v-if="user.id === $page.props.auth.user.id" @input="getUploadedImage($event)" type="file"
                    id="file-user" class="hidden">

                <div class="ml-6 w-full">
                    <div class="flex items-center md:mb-8 mb-5">
                        <div class="md:mr-6 mr-3 rounded-lg text-[22px]">{{ user.name }}</div>
                        <button
                            class="md:block hidden md:mr-6 p-1 px-4 rounded-lg text-[16px] font-extrabold bg-gray-100 hover:bg-gray-200">
                            Edit Profile
                        </button>
                        <Cog :size="28" class="cursor-pointer" />
                    </div>

                    <button
                        class="md:hidden mr-6 p-1 px-4 max-w-[260px] w-full rounded-lg text-[17px] font-extrabold bg-gray-100 hover:bg-gray-200">
                        Edit Profile
                    </button>

                    <div class="md:block hidden">
                        <div class="flex items-center text-[18px]">
                            <div class="mr-6">
                                <span class="font-extrabold">{{ postsByUser.data.length }}</span> posts
                            </div>
                            <div class="mr-6">
                                <span class="font-extrabold">1k</span> followers
                            </div>
                            <div class="mr-6">
                                <span class="font-extrabold">124</span> following
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="md:hidden">
            <div class="w-full flex items-center justify-around border-t border-t-gray-300 mt-8">
                <div class="text-center p-3">
                    <div class="font-extrabold">{{ postsByUser.data.length }}</div>
                    <div class="text-gray-400 font-semibold -mt-1.5">posts</div>
                </div>
                <div class="text-center p-3">
                    <div class="font-extrabold">1k</div>
                    <div class="text-gray-400 font-semibold -mt-1.5">followers</div>
                </div>
                <div class="text-center p-3">
                    <div class="font-extrabold">124</div>
                    <div class="text-gray-400 font-semibold -mt-1.5">following</div>
                </div>
            </div>

            <div class="w-full flex items-center justify-between border-t border-t-gray-300">
                <div class="p-3 w-1/4 flex justify-center border-t border-t-gray-900">
                    <Grid :size="28" fillColor="#0095F6" class="cursor-pointer" />
                </div>
                <div class="p-3 w-1/4 flex justify-center">
                    <PlayBoxOutline :size="28" fillColor="#8E8E8E" class="cursor-pointer" />
                </div>
                <div class="p-3 w-1/4 flex justify-center">
                    <BookmarkOutline :size="28" fillColor="#8E8E8E" class="cursor-pointer" />
                </div>
                <div class="p-3 w-1/4 flex justify-center">
                    <AccountBoxOutline :size="28" fillColor="#8E8E8E" class="cursor-pointer" />
                </div>
            </div>
        </div>

        <div id="content-section" class="md:pr-1.5 lg:pl-0 md:pl-[90px]">
            <div class="md:block mt-10 hidden border-t border-t-gray-300">
                <div
                    class="flex items-center justify-between max-w-[600px] mx-auto font-extrabold text-gray-400 text-[15px]">
                    <div class="p-[17px] w-1/4 flex justify-center items-center border-t border-t-gray-900">
                        <Grid :size="15" fillColor="#000000" class="cursor-pointer" />
                        <div class="ml-2 -mb-[1px] text-gray-900">POSTS</div>
                    </div>
                    <div class="p-[17px] w-1/4 flex justify-center items-center">
                        <PlayBoxOutline :size="15" fillColor="#8E8E8E" class="cursor-pointer" />
                        <div class="ml-2 -mb-[1px] text-gray-900">REELS</div>
                    </div>
                    <div class="p-[17px] w-1/4 flex justify-center items-center">
                        <BookmarkOutline :size="15" fillColor="#8E8E8E" class="cursor-pointer" />
                        <div class="ml-2 -mb-[1px] text-gray-900">SAVED</div>
                    </div>
                    <div class="p-[17px] w-1/4 flex justify-center items-center">
                        <AccountBoxOutline :size="15" fillColor="#8E8E8E" class="cursor-pointer" />
                        <div class="ml-2 -mb-[1px] text-gray-900">TAGGED</div>
                    </div>
                </div>
            </div>

            <div class="grid md:gap-4 gap-1 grid-cols-3 relative pb-[10px]">
                <ContentOverlay v-for="post in postsByUser.data" :key="post.id" :postByUser="post"
                    @selectedPost="data.post = $event" />
            </div>
        </div>
    </MainLayout>

    <ShowPostOverlay v-if="data.post" :post="data.post" @addComment="addComment($event)" @updateLike="updateLike($event)"
        @deleteSelected="deleteFunc($event)" @closeOverlay="data.post = null" />
</template>
