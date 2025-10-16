<template>
  <div class="min-h-screen bg-gradient-to-br from-indigo-100 via-white to-purple-100 flex justify-center items-center p-6">
    <div
      class="w-full max-w-md bg-white shadow-xl rounded-3xl overflow-hidden transition-all duration-500 hover:shadow-2xl"
    >
      <!-- Cover Photo -->
      <div class="relative">
        <img
          src="https://images.unsplash.com/photo-1529626455594-4ff0802cfb7e?auto=format&fit=crop&w=900&q=80"
          alt="Cover"
          class="w-full h-40 object-cover"
        />
        <div
          class="absolute -bottom-12 left-1/2 transform -translate-x-1/2 rounded-full border-4 border-white overflow-hidden w-24 h-24"
        >
          <img
            :src="user.avatar"
            alt="User avatar"
            class="object-cover w-full h-full"
          />
        </div>
      </div>

      <!-- Profile Content -->
      <div class="pt-16 pb-6 px-6 text-center">
        <h2 class="text-2xl font-bold text-gray-800">{{ user.name }}</h2>
        <p class="text-gray-500 text-sm mt-1">@{{ user.username }}</p>

        <div class="mt-4 flex justify-center gap-4">
          <button
            class="bg-indigo-500 hover:bg-indigo-600 text-white text-sm px-4 py-2 rounded-full transition-colors"
          >
            Follow
          </button>
          <button
            class="bg-white border border-indigo-500 text-indigo-600 text-sm px-4 py-2 rounded-full hover:bg-indigo-50 transition-colors"
          >
            Message
          </button>
        </div>

        <!-- Stats -->
        <div class="mt-6 flex justify-around border-t border-gray-200 pt-4">
          <div>
            <h4 class="text-lg font-bold text-gray-700">{{ user.posts }}</h4>
            <p class="text-gray-500 text-xs">Posts</p>
          </div>
          <div>
            <h4 class="text-lg font-bold text-gray-700">{{ user.followers }}</h4>
            <p class="text-gray-500 text-xs">Followers</p>
          </div>
          <div>
            <h4 class="text-lg font-bold text-gray-700">{{ user.following }}</h4>
            <p class="text-gray-500 text-xs">Following</p>
          </div>
        </div>

        <!-- Bio -->
        <div class="mt-6 text-gray-600 text-sm leading-relaxed">
          {{ user.bio }}
        </div>

        <!-- Interests -->
        <div class="mt-6 flex flex-wrap justify-center gap-2">
          <span
            v-for="tag in user.interests"
            :key="tag"
            class="bg-purple-100 text-purple-700 text-xs font-medium px-3 py-1 rounded-full"
          >
            #{{ tag }}
          </span>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
defineProps({
  user: {
    type: Object,
    required: true
  }
});
const user = {
  name: "Sara Moradi",
  username: "saram",
  avatar:
    "https://randomuser.me/api/portraits/women/68.jpg",
  posts: 124,
  followers: 5_432,
  following: 342,
  bio: "Frontend developer & tea enthusiast 🍵 | Sharing my love for UI design and minimal code aesthetics ✨",
  interests: ["vuejs", "tailwind", "design", "travel", "minimalism"],
};
</script>

<style scoped>
/* Add a soft animation for hover state */
div:hover img[alt='User avatar'] {
  transform: scale(1.05);
  transition: transform 0.3s ease;
}
</style>
