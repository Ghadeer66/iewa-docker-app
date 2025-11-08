import { defineStore } from 'pinia'
import axios from 'axios'

export interface CartItem {
  id: number
  mealId: string
  mealTitle: string
  dateISO: string
  price: number
  mealImage?: string
  quantity: number
}

export const useCartStore = defineStore('cart', {
  state: () => ({
    items: [] as CartItem[],
    // pending operations for optimistic UI (list of cart ids currently mutating)
    pending: [] as number[],
  }),

  getters: {
    count: (state) => state.items.length,
  },

  actions: {
    async loadCart() {
      try {
        const { data } = await axios.get('/cart')
        this.items = Array.isArray(data) ? (data as CartItem[]) : []
      } catch (error) {
        console.error('Failed to load cart:', error)
      }
    },

    // Initialize store from server-provided items (used after login)
    initialize(items: CartItem[]) {
      this.items = Array.isArray(items) ? items : []
      this.pending = []
    },

    async addSelections(mealId: string, dates: string[], quantity: number = 1) {
      try {
        await axios.post('/cart', { mealId, dates, quantity })
        await this.loadCart()
      } catch (error) {
        console.error('Failed to add to cart:', error)
      }
    },

    async removeOne(cartId: number) {
      // Optimistic UI: apply change locally immediately, then call server.
      // On error, rollback to previous state.
      const prev = JSON.parse(JSON.stringify(this.items)) as CartItem[]

      const idx = this.items.findIndex((i) => i.id === cartId)
      if (idx === -1) return

      // apply local optimistic change
      if (this.items[idx].quantity > 1) {
        this.items[idx].quantity = this.items[idx].quantity - 1
      } else {
        this.items.splice(idx, 1)
      }

      // mark pending
      if (!this.pending.includes(cartId)) this.pending.push(cartId)

      try {
        await axios.delete(`/cart/${cartId}/one`)
        // sync with server to get authoritative state
        await this.loadCart()
      } catch (error) {
        // rollback
        this.items = prev
        console.error('Failed to remove one:', error)
      } finally {
        // clear pending flag
        this.pending = this.pending.filter((id) => id !== cartId)
      }
    },

    async removeAll(cartId: number) {
      try {
        await axios.delete(`/cart/${cartId}/all`)
        // Refresh from server to ensure UI matches backend
        await this.loadCart()
      } catch (error) {
        console.error('Failed to remove all:', error)
      }
    },

    async clearAll() {
      try {
        await axios.delete('/cart')
        this.items = []
      } catch (error) {
        console.error('Failed to clear cart:', error)
      }
    },
  },
})
