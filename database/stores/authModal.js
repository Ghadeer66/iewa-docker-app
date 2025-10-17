import { ref } from 'vue'

// Reactive state
const showAuthModal = ref(false)
const showLoginForm = ref(false)

// Store functions
export function useAuthModal() {
    const openAuthModal = (isLogin = false) => {
        showAuthModal.value = true
        showLoginForm.value = isLogin
    }

    const closeAuthModal = () => {
        showAuthModal.value = false
    }

    const toggleAuthForm = () => {
        showLoginForm.value = !showLoginForm.value
    }

    return {
        showAuthModal,
        showLoginForm,
        openAuthModal,
        closeAuthModal,
        toggleAuthForm
    }
}
