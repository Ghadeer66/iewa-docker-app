import { router } from '@inertiajs/vue3'

export const authService = {
    async login(credentials) {
        try {
            const response = await axios.post('/login', credentials)
            return response.data
        } catch (error) {
            throw error.response.data
        }
    },

    async register(userData) {
        try {
            const response = await axios.post('/register', userData)
            return response.data
        } catch (error) {
            throw error.response.data
        }
    },

    async logout() {
        try {
            await axios.post('/logout')
            // Inertia will handle the redirect
            router.visit('/')
        } catch (error) {
            console.error('Logout error:', error)
        }
    },

    async getUser() {
        try {
            const response = await axios.get('/user')
            return response.data
        } catch (error) {
            return null
        }
    },

    // Check if user is authenticated (for client-side checks)
    isAuthenticated() {
        return !!window.user // If you're sharing user data via Inertia
    }
}
