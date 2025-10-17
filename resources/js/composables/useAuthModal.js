import { ref, reactive } from 'vue'

const showAuthModal = ref(false)
const showLoginForm = ref(false)

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
        showAuthModal: readonly(showAuthModal),
        showLoginForm: readonly(showLoginForm),
        openAuthModal,
        closeAuthModal,
        toggleAuthForm
    }
}
