<template>
    <Layout>
        <Head>
            <title>Iewato — Official Site</title>
            <meta name="description" content="Iewato (ایواتو) — learn about our services and menu." />
            <link rel="canonical" :href="canonical" />
            <meta property="og:title" content="Iewato — Official Site" />
            <meta property="og:description" content="Iewato (ایواتو) — learn about our services and menu." />
            <meta property="og:type" content="website" />
            <meta property="og:url" :content="canonical" />
        </Head>
        <section class="container mx-auto px-6 py-12 text-right">
            <h1 class="text-3xl font-bold mb-4">Iewato</h1>
            <p class="text-lg text-gray-700">Iewato (ایواتو) — official landing page for the keyword "iewato".</p>
        </section>
    </Layout>
</template>

<script setup>
import Layout from '@/layouts/AppLayout.vue'
import { Head } from '@inertiajs/vue3'
import { computed } from 'vue'

const canonical = computed(() => typeof window !== 'undefined' ? window.location.href : '')
</script>


