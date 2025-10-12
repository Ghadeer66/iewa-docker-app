<script setup lang="ts">
import type { HTMLAttributes } from 'vue';

defineOptions({
    inheritAttrs: false,
});

interface Props {
    className?: HTMLAttributes['class'];
}

defineProps<Props>();
</script>

<template>
    <div class="flex justify-center mb-6">
        <img src="/storage/images/icon.png" alt="ایوا" class="h-20 w-20 object-contain" />
    </div>
</template>
