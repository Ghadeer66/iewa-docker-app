<template>
    <Layout>
        <Head>
            <title>ایواتو — وبسایت رسمی</title>
            <meta name="description" content="ایواتو (Iewato) — صفحه فرود رسمی برای کلمه کلیدی ایواتو." />
            <link rel="canonical" :href="canonical" />
            <meta property="og:title" content="ایواتو — وبسایت رسمی" />
            <meta property="og:description" content="ایواتو (Iewato) — صفحه فرود رسمی برای کلمه کلیدی ایواتو." />
            <meta property="og:type" content="website" />
            <meta property="og:url" :content="canonical" />
        </Head>
        <section class="container mx-auto px-6 py-12 text-right">
            <h1 class="text-3xl font-bold mb-4">ایواتو</h1>
            <p class="text-lg text-gray-700">صفحه فرود برای «ایواتو» جهت بهبود سئو و دسترسی.</p>
        </section>
    </Layout>
</template>

<script setup>
import Layout from '@/layouts/AppLayout.vue'
import { Head } from '@inertiajs/vue3'
import { computed } from 'vue'

const canonical = computed(() => typeof window !== 'undefined' ? window.location.href : '')
</script>


