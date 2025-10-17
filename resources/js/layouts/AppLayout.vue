<script setup>
import Navbar from '@/components/Navbar.vue'
import Footer from '@/components/Footer.vue'
import { router } from '@inertiajs/vue3'
import GlobalAuthModal from '@/components/GlobalAuthModal.vue';
</script>

<template>
  <div class="min-h-screen flex flex-col bg-gray-50 text-gray-900">
    <Navbar />
    <main class="flex-1">
      <slot />
    </main>
    <Footer />

    <!-- Global Auth Modal -->
    <GlobalAuthModal />
  </div>
</template>
