<template>
    <Navbar />
  <div
    class="min-h-screen flex items-center justify-center bg-gradient-to-br from-gray-900 via-slate-800 to-gray-900 relative overflow-hidden"
  >

    <!-- Auth content slot -->
    <div class="relative z-10">
      <slot />
    </div>
  </div>
    <Footer />
</template>
const ingredients = [

<script setup>
import Navbar from '@/components/Navbar.vue';
import Footer from '@/components/Footer.vue';
</script>

<style scoped>
@keyframes float {
  0%, 100% { transform: translateY(0) rotate(0deg); }
  50% { transform: translateY(-15px) rotate(5deg); }
}
.animate-float {
  animation: float 6s ease-in-out infinite;
}
</style>
