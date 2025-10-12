<template>
    <Navbar />
  <div
    class="min-h-screen flex items-center justify-center bg-gradient-to-br from-gray-900 via-slate-800 to-gray-900 relative overflow-hidden"
  >
    <!-- Floating Ingredients -->
    <div class="absolute top-0 left-0 w-full h-full overflow-hidden">
      <div
        v-for="(ingredient, i) in ingredients"
        :key="i"
        class="absolute animate-float"
        :style="{
          top: ingredient.top,
          left: ingredient.left,
          animationDelay: ingredient.delay,
          transform: ingredient.scale,
        }"
      >
        <img :src="ingredient.src" :alt="ingredient.alt" class="w-16 opacity-70" />
      </div>
    </div>

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
const ingredients = [
  { src: 'storage/images/apple.png', alt: 'apple', top: '10%', left: '25%', delay: '0s', scale: 'scale(1)' },
  { src: 'storage/images/banana.png', alt: 'banana', top: '40%', left: '90%', delay: '2s', scale: 'scale(0.8)' },
  { src: 'storage/images/orange.png', alt: 'orange', top: '75%', left: '15%', delay: '1s', scale: 'scale(1.2)' },
  { src: 'storage/images/broccoli.png', alt: 'broccoli', top: '60%', left: '70%', delay: '3s', scale: 'scale(0.9)' },
  { src: 'storage/images/apple.png', alt: 'apple', top: '20%', left: '65%', delay: '0s', scale: 'scale(1)' },
  { src: 'storage/images/banana.png', alt: 'banana', top: '50%', left: '10%', delay: '2s', scale: 'scale(0.8)' },
  { src: 'storage/images/orange.png', alt: 'orange', top: '15%', left: '85%', delay: '1s', scale: 'scale(1.2)' },
  { src: 'storage/images/broccoli.png', alt: 'broccoli', top: '40%', left: '30%', delay: '3.2s', scale: 'scale(0.6)' },
]
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
