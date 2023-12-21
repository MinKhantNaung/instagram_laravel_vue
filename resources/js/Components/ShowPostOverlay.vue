<script setup>
import { usePage } from "@inertiajs/vue3";
import { ref, toRefs } from "vue";

import LikeSection from '@/Components/LikeSection.vue'
import ShowPostOptionOverlay from '@/Components/ShowPostOptionOverlay.vue'

import Close from 'vue-material-design-icons/Close.vue'
import DotsHorizontal from "vue-material-design-icons/DotsHorizontal.vue";
import EmoticonHappyOutline from 'vue-material-design-icons/EmoticonHappyOutline.vue'

let comment = ref('')
let deleteType = ref(null)
let id = ref(null)

const user = usePage().props.auth.user

const props = defineProps({
    post: Object
})
const { post } = toRefs(props)

defineEmits(['closeOverlay', 'addComment', 'updateLike', 'deleteSelected'])

const textareaInput = (e) => {
    textarea.value.style.height = 'auto'
    textarea.value.style.height = `${e.target.scrollHeight}px`
}
</script>

<template>
    <div id="overlay-section" class="fixed z-50 top-0 left-0 w-full h-screen bg-[#000000] bg-opacity-60 p-3">
        <button @click="$emit('closeOverlay')" class="absolute right-3">
            <Close :size="27" fillColor="#FFFFFF" />
        </button>
        <div class="max-w-6xl h-[calc(100%-100px)] mx-auto mt-10 bg-white rounded-xl">
            <div class="w-full md:flex h-full overflow-auto rounded-xl">
                <div class="flex items-center bg-black w-full">
                    <img class="rounded-xl min-w-[400px] h-full p-4 mx-auto object-contain"
                        :src="`storage/post_images/${post.file}`" />
                </div>

                <div class="md:max-w-[500px] w-full relative">
                    <div class="flex items-center justify-between p-3 border-b">
                        <div class="flex items-center">
                            <img class="rounded-full w-[38px] h-[38px]" :src="`storage/user_images/${post.user.file}`"
                                alt="">
                            <div class="ml-4 font-extrabold text-[15px]">{{ post.user.name }}</div>
                            <div class="flex items-center text-[15px] text-gray-500">
                                <span class="-mt-5 ml-2 mr-[5px] text-[35px]">.</span>
                                <div>{{ post.created_at }}</div>
                            </div>
                        </div>
                        <button>
                            <DotsHorizontal v-if="user.id == post.user.id"
                                @click.prevent="deleteType = 'post'; id = post.id" class="cursor-pointer" :size="27" />
                        </button>
                    </div>

                    <div class="overflow-y-auto h-[calc(100%-170px)]">
                        <div class="flex items-center justify-between p-3">
                            <div class="flex items-center relative">
                                <img class="absolute -top-1 rounded-full w-[38px] h-[38px]" :src="post.user.file" alt="">
                                <div class="ml-14">
                                    <span class="font-extrabold text-[15px] mr-2">
                                        {{ post.user.name }}
                                    </span>
                                    <span class="text-[15px] text-gray-900">
                                        {{ post.text }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div v-for="comment in post.comments" :key="comment.id" class="p-3">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <img class="rounded-full w-[38px] h-[38px]"
                                        :src="`storage/user_images/${comment.user.file}`" alt="">
                                    <div class="ml-4 font-extrabold text-[15px]">
                                        {{ comment.user.name }}
                                        <span class="font-light text-gray-700 text-sm">{{ comment.created_at }}</span>
                                    </div>
                                </div>

                                <DotsHorizontal v-if="user.id === comment.user.id"
                                    @click.prevent="deleteType = 'comment'; id = comment.id" class="cursor-pointer"
                                    :size="27" />
                            </div>

                            <div class="text-[13px] pl-[55px]">
                                {{ comment.text }}
                            </div>
                        </div>

                        <div class="pb-16 md:hidden"></div>
                    </div>

                    <LikeSection v-if="post" @like="$emit('updateLike')" :post="post" class="px-2 border-t mb-2" />

                    <div class="absolute flex border bottom-0 w-full max-h-[200px] bg-white overflow-auto">
                        <EmoticonHappyOutline class="pl-3 pt-[10px]" :size="30" />
                        <textarea ref="textarea" :onInput="textareaInput" v-model="comment" placeholder="Add a comment..."
                            rows="1"
                            class="w-full border-0 mt-2 mb-2 text-sm z-50 focus:ring-0 text-gray-600 text-[18px]"></textarea>
                        <button v-if="comment" @click.prevent="$emit('addComment', { post, user, comment }); comment = ''"
                            class="text-blue-600 font-extrabold pr-4">
                            Post
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <ShowPostOptionOverlay v-if="deleteType" :deleteType="deleteType" :id="id" @deleteSelected="$emit('deleteSelected', {
        deleteType: deleteType,
        id: id,
        post: post,
    }); deleteType = null; id = null" @close="deleteType = null; id = null" />
</template>
