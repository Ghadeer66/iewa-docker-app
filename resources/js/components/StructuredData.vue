<script setup>
import { onMounted, onUnmounted } from 'vue'

const props = defineProps({
  type: {
    type: String,
    default: 'Organization'
  },
  data: {
    type: Object,
    default: () => ({})
  }
})

let scriptElement = null

onMounted(() => {
  const schema = {
    '@context': 'https://schema.org',
    '@type': props.type,
    ...props.data
  }

  scriptElement = document.createElement('script')
  scriptElement.type = 'application/ld+json'
  scriptElement.text = JSON.stringify(schema, null, 2)
  document.head.appendChild(scriptElement)
})

onUnmounted(() => {
  if (scriptElement && scriptElement.parentNode) {
    scriptElement.parentNode.removeChild(scriptElement)
  }
})
</script>

<template>
  <!-- Structured data is injected via script tag -->
</template>

