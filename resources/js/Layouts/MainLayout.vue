<script setup>
import { ref } from 'vue';
import { Link } from '@inertiajs/vue3';

import Magnify from 'vue-material-design-icons/Magnify.vue'
import HeartOutline from 'vue-material-design-icons/HeartOutline.vue'
import HomeOutline from 'vue-material-design-icons/HomeOutline.vue'
import Compass from 'vue-material-design-icons/Compass.vue'
import SendOutline from 'vue-material-design-icons/SendOutline.vue'
import Plus from 'vue-material-design-icons/Plus.vue'
import AccountOutline from 'vue-material-design-icons/AccountOutline.vue'
import ChevronLeft from 'vue-material-design-icons/ChevronLeft.vue'
import AccountPlusOutline from 'vue-material-design-icons/AccountPlusOutline.vue'

import MenuItem from '@/Components/MenuItem.vue'
import CreatePostOverlay from '@/Components/CreatePostOverlay.vue'

const showCreatePost = ref(false)
</script>

<template>
    <div id="main-layout" class="w-full h-screen">

        <!-- Top Nav START -->
        <div v-if="$page.url === '/'" id="top-nav-home"
            class="fixed z-50 md:hidden block w-full bg-white h-[61px] border-b border-b-gray-300">
            <div class="flex items-center justify-between h-full">
                <Link href="/">
                <img src="/insta-logo.png" alt="" class="w-[105px] ml-6 cursor-pointer">
                </Link>

                <div class="flex items-center w-[50%]">
                    <div class="flex items-center w-full bg-gray-100 rounded-lg">
                        <Magnify class="pl-4" fillColor="#8E8E8E" :size="27" />
                        <input type="text" placeholder="Search" class="bg-transparent w-full placeholder-[#8E8E8E] border-0
                            ring-0 focus:ring-0">
                    </div>

                    <HeartOutline class="pl-4 pr-3" fillColor="#000000" :size="27" />
                </div>
            </div>
        </div>

        <div v-if="$page.url !== '/'" id="top-nav-user"
            class="md:hidden fixed flex items-center justify-between z-50 w-full bg-white h-[61px] border-b border-b-gray-300">
            <Link href="/" class="px-4">
            <ChevronLeft :size="30" class="cursor-pointer" />
            </Link>
            <div class="font-extrabold text-lg">{{ $page.props.auth.user.name }}</div>
            <AccountPlusOutline :size="30" class="cursor-pointer px-4" />
        </div>
        <!-- Top Nav END -->

        <!-- Side Nav START -->
        <div id="side-nav" class="fixed h-full bg-white xl:w-[280px] w-[80px] md:block hidden border-r border-r-gray-300">
            <Link href="/">
            <img src="/insta-logo-small.png" alt="" class="xl:hidden block w-[25px] mt-10 ml-[25px] mb-10 cursor-pointer">
            <img src="/insta-logo.png" alt="" class="xl:block hidden w-[120px] mt-10 ml-6 mb-10 cursor-pointer">
            </Link>

            <div class="px-3">
                <Link href="/">
                <MenuItem iconString="Home" class="mb-1">
                </MenuItem>
                </Link>
                <MenuItem iconString="Search" class="mb-1">
                </MenuItem>
                <MenuItem iconString="Explore" class="mb-1">
                </MenuItem>
                <MenuItem iconString="Messages" class="mb-1">
                </MenuItem>
                <MenuItem iconString="Notifications" class="mb-1">
                </MenuItem>
                <MenuItem @click="showCreatePost = true" iconString="Create" class="mb-1">
                </MenuItem>
                <Link :href="route('users.show', { id: $page.props.auth.user.id })" preserve-state>
                <MenuItem iconString="Profile" class="mb-1">
                </MenuItem>
                </Link>
            </div>

            <Link :href="route('logout')" as="button" method="post" preserve-state="false" replace="false"
                class="absolute bottom-0 px-3 w-full">
            <MenuItem iconString="Log out" class="mb-4">
            </MenuItem>
            </Link>
        </div>
        <!-- Side Nav END -->

        <!-- Main Layout start -->
        <div
            class="flex lg:justify-between bg-white h-full w-[100%-280px] xl:pl-[280px] lg:pl-[100px] md:pl-[20px] overflow-auto">
            <div :class="$page.url === '/' ? 'lg:w-8/12 w-full' : 'max-w-[1200px]'" class="mx-auto md:pt-6 pt-20">
                <main>
                    <slot />
                </main>
            </div>

            <!-- Suggestion Section -->
            <!-- Suggestion Section will only show in large and above devices -->
            <div v-if="$page.url === '/'" id="suggestion-section" class="lg:w-4/12 lg:block hidden text-black mt-10">
                <Link :href="route('users.show', { id: $page.props.auth.user.id })" preserve-state
                    class="flex items-center justify-between max-w-[300px]">
                <div class="flex items-center">
                    <img class="rounded-full z-10 w-[58px] h-[58px]"
                        :src="`storage/user_images/${$page.props.auth.user.file}`">
                    <div class="pl-4">
                        <div class="text-black font-extrabold">
                            {{ $page.props.auth.user.name }}
                        </div>
                        <div class="text-black font-extrabold text-sm">
                            {{ $page.props.auth.user.name }}
                        </div>
                    </div>
                </div>
                <button class="text-blue-500 hover:text-gray-900 text-xs font-extrabold">
                    Switch
                </button>
                </Link>

                <div class="max-w-[300px] flex items-center justify-between py-3">
                    <div class="text-gray-500 font-extrabold">Suggestions for you</div>
                    <button class="text-blue-500 hover:text-gray-900 text-xs font-extrabold">
                        See All
                    </button>
                </div>

                <div v-for="randomUser in $page.props.randomUsers" :key="randomUser.id">
                    <div class="flex justify-between">
                        <Link :href="route('users.show', { id: randomUser.id })" preserve-state
                            class="flex items-center justify-between max-w-[300px] pb-2">
                        <div class="flex items-center">
                            <img class="rounded-full z-10 w-[37px] h-[37px]"
                                :src="`storage/user_images/${randomUser.file}`">
                            <div class="pl-4">
                                <div class="text-black font-extrabold">
                                    {{ randomUser.name }}
                                </div>
                                <div class="text-black font-extrabold text-sm">
                                    {{ randomUser.name }}
                                </div>
                            </div>
                        </div>
                        </Link>
                        <Link>
                        <button class="text-blue-500 hover:text-gray-900 text-xs font-extrabold">
                            Follow
                        </button>
                        </Link>
                    </div>
                </div>

                <div class="max-w-[300px] mt-5">
                    <div class="text-sm text-gray-400">About Help Press API Jobs Privacy Terms Locations Language Meta
                        Verified.</div>
                    <div class="text-left text-gray-400 mt-4">&copy; 2023 INSTAGRAM FROM META</div>
                </div>
            </div>
            <!-- Suggestion Section -->

        </div>
        <!-- Main Layout end -->

        <!-- Bottom Nav section start -->
        <!-- Bottom Nav section only show in medium to small devices -->
        <div id="bottom-nav"
            class="fixed z-30 bottom-0 w-full md:hidden flex items-center justify-around bg-white border-t py-2 border-t-gray-300">
            <Link href="/">
            <HomeOutline fillColor="#000000" :size="33" class="cursor-pointer" />
            </Link>
            <Compass fillColor="#000000" :size="33" class="cursor-pointer" />
            <SendOutline fillColor="#000000" :size="33" class="cursor-pointer" />
            <Plus @click="showCreatePost = true" fillColor="#000000" :size="33" class="cursor-pointer" />
            <AccountOutline fillColor="#000000" :size="33" class="cursor-pointer" />
            <Link :href="route('users.show', { id: $page.props.auth.user.id })">
            <img class="rounded-full w-[30px] cursor-pointer" :src="`storage/user_images/${$page.props.auth.user.file}`"
                alt="">
            </Link>
        </div>
        <!-- Bottom Nav section end -->
    </div>

    <CreatePostOverlay v-if="showCreatePost" @close="showCreatePost = false" />
</template>
