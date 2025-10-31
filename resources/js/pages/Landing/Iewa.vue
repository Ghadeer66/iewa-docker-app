<template>
    <Layout>
        <Head>
            <title>Iewa — Official Site</title>
            <meta name="description" content="Iewa (ایوا) — learn about our services and menu." />
            <link rel="canonical" :href="canonical" />
            <meta property="og:title" content="Iewa — Official Site" />
            <meta property="og:description" content="Iewa (ایوا) — learn about our services and menu." />
            <meta property="og:type" content="website" />
            <meta property="og:url" :content="canonical" />
        </Head>
        <section class="container mx-auto px-6 py-12 text-right">
            <h1 class="text-3xl font-bold mb-4">Iewa</h1>
            <p class="text-lg text-gray-700">Iewa (ایوا) — official landing page for the keyword "iewa".</p>
        </section>
    </Layout>

</template>

<script setup>
import Layout from '@/layouts/AppLayout.vue'
import { Head } from '@inertiajs/vue3'
import { computed } from 'vue'

const canonical = computed(() => typeof window !== 'undefined' ? window.location.href : '')
</script>


