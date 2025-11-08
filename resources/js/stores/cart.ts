import { defineStore } from 'pinia'

// ---- Types ----
export interface Item {
  mealId: string
  mealTitle: string
  mealImage?: string
  dateISO: string
  price: number
}

interface State {
  items: Item[]
  userId?: string
}

// ---- Helpers ----
function storageKey(userId?: string) {
  return userId ? `cart_${userId}` : 'cart_guest'
}

function load(userId?: string): State {
  try {
    const data = localStorage.getItem(storageKey(userId))
    if (!data) return { items: [], userId }
    const parsed = JSON.parse(data)
    return {
      items: Array.isArray(parsed.items) ? parsed.items : [],
      userId,
    }
  } catch {
    return { items: [], userId }
  }
}

function save(state: State) {
  try {
    localStorage.setItem(storageKey(state.userId), JSON.stringify({ items: state.items }))
  } catch (e) {
    console.error('Failed to save cart:', e)
  }
}

// ---- Store ----
export const useCartStore = defineStore('cart', {
  // Automatically load from localStorage on startup
  state: (): State => load(),

  getters: {
    // Total count of items
    count: (state): number => state.items.length,

    // Return count of meals per date
    countsByDate: (state) => {
      return (mealId: string): Record<string, number> => {
        const map: Record<string, number> = {}
        for (const it of state.items as Item[]) { // <--- typed here
          if (it.mealId !== mealId) continue
          map[it.dateISO] = (map[it.dateISO] || 0) + 1
        }
        return map
      }
    },
  },

  actions: {
    // Initialize when user logs in/out
    initialize(userId?: string) {
      const loaded = load(userId)
      this.items = loaded.items
      this.userId = userId
    },

    // Add an item to the cart
    add(item: Item) {
      this.items.push(item)
      save(this)
    },

    // Add multiple selections (used by calendar) — adds one item per date, repeated by quantity
    addSelections(
      mealId: string,
      mealTitle: string,
      dates: string[],
      price: number,
      mealImage?: string,
      quantity = 1
    ) {
      for (const d of dates) {
        for (let i = 0; i < Math.max(1, quantity); i++) {
          this.items.push({ mealId, mealTitle, mealImage, dateISO: d, price })
        }
      }
      save(this)
    },

    // Remove one instance of a meal/date combination
    removeOne(mealId: string, dateISO: string, price: number) {
      const idx = this.items.findIndex(
        (it: Item) => it.mealId === mealId && it.dateISO === dateISO && it.price === price
      )
      if (idx !== -1) {
        this.items.splice(idx, 1)
        save(this)
      }
    },

    // Remove all items from a specific group
    removeGroup(mealId: string, dateISO: string, price: number) {
      this.items = this.items.filter(
        (it: Item) => !(it.mealId === mealId && it.dateISO === dateISO && it.price === price)
      )
      save(this)
    },

    // Empty the cart
    clearAll() {
      this.items = []
      save(this)
    },
  },
})
