<script setup>
import Navbar from '@/components/Navbar.vue'
import Footer from '@/components/Footer.vue'
import { router } from '@inertiajs/vue3'
import GlobalAuthModal from '@/components/GlobalAuthModal.vue'
import StructuredData from '@/components/StructuredData.vue'
import { computed, ref, provide } from 'vue'

// Cart state - provide to all child components
const cartIsOpen = ref(false)
provide('cartIsOpen', cartIsOpen)

const organizationSchema = computed(() => ({
  '@type': 'Organization',
  name: 'ایوا',
  alternateName: 'Iewa',
  url: typeof window !== 'undefined' ? window.location.origin : '',
  logo: typeof window !== 'undefined' ? `${window.location.origin}/images/icon.png` : '',
  description: 'مجموعه غذایی ایوا - سفارش آنلاین غذای سالم و باکیفیت',
  address: {
    '@type': 'PostalAddress',
    addressCountry: 'IR',
    addressRegion: 'اصفهان',
    addressLocality: 'اصفهان',
    streetAddress: 'ایران، اصفهان، خیابان کهندژ، کوچه ۱۱۹، بلاک ۱۴'
  },
  contactPoint: {
    '@type': 'ContactPoint',
    telephone: '+98-902-738-3170',
    contactType: 'پشتیبانی',
    email: 'info@iewato.ir'
  },
  sameAs: []
}))

const localBusinessSchema = computed(() => ({
  '@type': 'LocalBusiness',
  name: 'ایوا',
  alternateName: 'Iewa',
  image: typeof window !== 'undefined' ? `${window.location.origin}/images/icon.png` : '',
  '@id': typeof window !== 'undefined' ? `${window.location.origin}#business` : '',
  url: typeof window !== 'undefined' ? window.location.origin : '',
  telephone: '+98-902-738-3170',
  email: 'info@iewato.ir',
  address: {
    '@type': 'PostalAddress',
    addressCountry: 'IR',
    addressRegion: 'اصفهان',
    addressLocality: 'اصفهان',
    streetAddress: 'ایران، اصفهان، خیابان کهندژ، کوچه ۱۱۹، بلاک ۱۴'
  },
  priceRange: '$$',
  servesCuisine: 'غذای سالم'
}))
</script>

<template>
  <div class="min-h-screen flex flex-col bg-gray-50 text-gray-900">
    <!-- Structured Data - Organization -->
    <StructuredData type="Organization" :data="organizationSchema" />

    <!-- Structured Data - LocalBusiness -->
    <StructuredData type="LocalBusiness" :data="localBusinessSchema" />

    <Navbar :cart-is-open="cartIsOpen" @update:cart-is-open="cartIsOpen = $event" />
    <main class="flex-1">
      <slot />
    </main>
    <Footer />

    <!-- Global Auth Modal -->
    <GlobalAuthModal />
  </div>
</template>
