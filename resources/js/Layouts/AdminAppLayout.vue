<template>
  <div class="flex min-h-screen bg-gray-100 text-gray-800" dir="rtl">
    <!-- Sidebar -->
    <aside
      :class="[
        'transition-all duration-300 bg-gradient-to-b from-gray-900 to-gray-800 text-gray-100 border-l border-gray-700 shadow-xl z-20',
        sidebarOpen ? 'w-64' : 'w-20'
      ]"
    >
      <!-- Sidebar Header -->
      <div class="flex items-center justify-between px-4 py-5 border-b border-gray-700">
        <h2
          class="text-xl font-extrabold text-yellow-400 transition-all duration-300"
          :class="{ 'opacity-0 hidden': !sidebarOpen }"
        >
          مدیریت سایت
        </h2>
        <button
          @click="toggleSidebar"
          class="p-2 text-gray-400 hover:text-yellow-400 transition-colors"
        >
          <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M4 6h16M4 12h16M4 18h16" />
          </svg>
        </button>
      </div>

      <!-- User Info -->
      <div class="px-4 py-4 border-b border-gray-700 text-center">
        <div class="flex justify-center mb-2">
          <img src="/storage/images/admin-avatar.jpg" :class="['rounded-full border-2 border-yellow-400', sidebarOpen ? 'w-20 h-20' : 'w-10 h-10']" alt="Admin" />
        </div>
        <span v-if="sidebarOpen" class="block text-sm text-gray-300 truncate">
          {{ $page.props.auth.user.admin_name }}
        </span>
      </div>

      <!-- Navigation -->
      <nav class="flex-1 overflow-y-auto px-3 py-4 space-y-3">
        <!-- Users -->
        <div>
          <button
            @click="toggleCategory('users')"
            class="flex items-center justify-between w-full text-center px-2 py-2 rounded-md text-gray-200 hover:bg-gray-700 transition"
          >
            <div class="flex items-center gap-2">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-3-3h-2M9 20H4v-2a3 3 0 013-3h2m0-4a4 4 0 118 0 4 4 0 01-8 0z" />
              </svg>
              <span v-if="sidebarOpen">کاربران</span>
            </div>
            <svg
              v-if="sidebarOpen"
              xmlns="http://www.w3.org/2000/svg"
              class="h-4 w-4 transform transition-transform"
              :class="expanded.users ? 'rotate-180' : ''"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
            >
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
            </svg>
          </button>

          <ul v-show="expanded.users" class="mt-1 pr-4 text-sm text-gray-300 space-y-1">
            <li><Link href="/admin/users/admins" class="block px-2 py-1 rounded hover:bg-gray-700">مدیران</Link></li>
            <li><Link href="/admin/users/companies" class="block px-2 py-1 rounded hover:bg-gray-700">شرکت‌ها</Link></li>
            <li><Link href="/admin/users/clients" class="block px-2 py-1 rounded hover:bg-gray-700">مشتریان</Link></li>
          </ul>
        </div>

        <!-- Site -->
        <div>
          <button
            @click="toggleCategory('site')"
            class="flex items-center justify-between w-full text-right px-2 py-2 rounded-md text-gray-200 hover:bg-gray-700 transition"
          >
            <div class="flex items-center gap-2">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7m-9 2v8m4-8v8m5-8v8" />
              </svg>
              <span v-if="sidebarOpen">اجزای سایت</span>
            </div>
            <svg
              v-if="sidebarOpen"
              xmlns="http://www.w3.org/2000/svg"
              class="h-4 w-4 transform transition-transform"
              :class="expanded.site ? 'rotate-180' : ''"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
            >
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
            </svg>
          </button>

          <ul v-show="expanded.site" class="mt-1 pr-4 text-sm text-gray-300 space-y-1">
            <li><Link href="/admin/meals" class="block px-2 py-1 rounded hover:bg-gray-700">غذاها</Link></li>
            <li><Link href="/admin/meals-images" class="block px-2 py-1 rounded hover:bg-gray-700">تصاویر غذاها</Link></li>
            <li><Link href="/admin/images" class="block px-2 py-1 rounded hover:bg-gray-700">تصاویر</Link></li>
            <li><Link href="/admin/orders" class="block px-2 py-1 rounded hover:bg-gray-700">سفارش‌ها</Link></li>
            <li><Link href="/admin/packages" class="block px-2 py-1 rounded hover:bg-gray-700">بسته‌ها</Link></li>
            <li><Link href="/admin/types" class="block px-2 py-1 rounded hover:bg-gray-700">انواع</Link></li>
            <li><Link href="/admin/section-types" class="block px-2 py-1 rounded hover:bg-gray-700">انواع بخش‌ها</Link></li>
            <li><Link href="/admin/section-elements" class="block px-2 py-1 rounded hover:bg-gray-700">عناصر بخش‌ها</Link></li>
          </ul>
        </div>
      </nav>

    <!-- Logout -->
<div class="p-4 border-t border-gray-700">
  <button
    @click="logout"
    class="w-full flex items-center justify-center gap-2 py-2 rounded-md bg-red-600 hover:bg-red-700 font-semibold text-white"
  >
    <!-- Clear Power/Shutdown Icon -->
    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
      <path d="M18.36 6.64a9 9 0 11-12.72 0M12 2v6" />
    </svg>
    <span v-if="sidebarOpen">خروج</span>
  </button>
</div>


    </aside>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col">
      <header class="bg-white px-6 py-4 flex justify-between items-center"
        style="box-shadow: 0 4px 6px rgba(0,0,0,0.1), 0 2px 4px rgba(0,0,0,0.06);">
        <h1 class="text-xl font-bold text-gray-800">پنل ادمین</h1>
        <div class="flex items-center gap-3">
          <span class="text-gray-600">{{ $page.props.auth.user.admin_name }}</span>
          <img src="/storage/images/icon.png" class="w-8 h-8 rounded-full border" alt="avatar" />
        </div>
      </header>

      <main class="flex-1 p-8 overflow-y-auto bg-gray-50">
        <slot />
      </main>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { router, Link } from '@inertiajs/vue3'

const sidebarOpen = ref(true)
const expanded = ref({
  users: true,
  site: false,
})

const toggleCategory = (key) => {
  expanded.value[key] = !expanded.value[key]
}

const toggleSidebar = () => {
  sidebarOpen.value = !sidebarOpen.value
  if (!sidebarOpen.value) {
    expanded.value.users = false
    expanded.value.site = false
  }
}

const logout = () => {
  router.post('/admin/logout')
}
</script>
