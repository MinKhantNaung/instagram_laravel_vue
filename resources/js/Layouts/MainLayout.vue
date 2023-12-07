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
</script>

<template>
    <div id="main-layout" class="w-full h-screen">

        <!-- Top Nav START -->
        <div v-if="$page.url === '/'" id="top-nav-home"
            class="fixed z-38 md:hidden block w-full bg-white h-[61px] border-b border-b-gray-300">
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
            class="md:hidden fixed flex items-center justify-between z-30 w-full bg-white h-[61px] border-b border-b-gray-300">
            <Link href="/" class="px-4">
            <ChevronLeft :size="30" class="cursor-pointer" />
            <div class="font-extrabold text-lg">NAME HERE</div>
            <AccountPlusOutline :size="30" class="cursor-pointer px-4" />
            </Link>
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
                <MenuItem iconString="Home" class="mb-4">
                </MenuItem>
                </Link>
                <MenuItem iconString="Search" class="mb-4">
                </MenuItem>
                <MenuItem iconString="Explore" class="mb-4">
                </MenuItem>
                <MenuItem iconString="Messages" class="mb-4">
                </MenuItem>
                <MenuItem iconString="Notifications" class="mb-4">
                </MenuItem>
                <MenuItem iconString="Profile" class="mb-4">
                </MenuItem>
            </div>

            <Link href="/" class="absolute bottom-0 px-3 w-full">
            <MenuItem iconString="Log out" class="mb-4">
            </MenuItem>
            </Link>
        </div>
        <!-- Side Nav END -->
    </div>
</template>
