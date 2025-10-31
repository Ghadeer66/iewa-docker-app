import { defineStore } from 'pinia'

export type CartItem = {
    id: string // unique id
    mealId: string
    mealTitle: string
    mealImage?: string
    dateISO: string // YYYY-MM-DD
    price: number // per-day price at time of add
}

type State = {
    items: CartItem[]
}

function load(): State {
    try {
        const raw = localStorage.getItem('cart-state')
        if (!raw) return { items: [] }
        const parsed = JSON.parse(raw)
        return { items: Array.isArray(parsed.items) ? parsed.items : [] }
    } catch {
        return { items: [] }
    }
}

function persist(state: State) {
    try {
        localStorage.setItem('cart-state', JSON.stringify(state))
    } catch {}
}

export const useCartStore = defineStore('cart', {
    state: (): State => load(),
    getters: {
        count: (s) => s.items.length,
        // Return a map of date -> count for a specific meal
        countsByDate: (s) => {
            return (mealId: string) => {
                const map: Record<string, number> = {}
                for (const it of s.items) {
                    if (it.mealId !== mealId) continue
                    map[it.dateISO] = (map[it.dateISO] || 0) + 1
                }
                return map
            }
        },
    },
    actions: {
        addSelections(mealId: string, mealTitle: string, dates: string[], price: number, mealImage?: string, quantity: number = 1) {
            const toAdd: CartItem[] = []
            const qty = Math.max(1, Math.floor(quantity || 1))
            for (const d of dates) {
                for (let i = 0; i < qty; i++) {
                    toAdd.push({
                        id: `${mealId}:${d}:${Date.now()}:${Math.random().toString(36).slice(2,8)}`,
                        mealId,
                        mealTitle,
                        mealImage,
                        dateISO: d,
                        price,
                    })
                }
            }
            this.items.push(...toAdd)
            persist(this.$state)
        },
        removeItem(id: string) {
            this.items = this.items.filter((it: CartItem) => it.id !== id)
            persist(this.$state)
        },
        removeOne(mealId: string, dateISO: string, price: number) {
            const idx = this.items.findIndex((it: CartItem) => it.mealId === mealId && it.dateISO === dateISO && it.price === price)
            if (idx !== -1) {
                this.items.splice(idx, 1)
                persist(this.$state)
            }
        },
        removeGroup(mealId: string, dateISO: string, price: number) {
            this.items = this.items.filter((it: CartItem) => !(it.mealId === mealId && it.dateISO === dateISO && it.price === price))
            persist(this.$state)
        },
        clearAll() {
            this.items = []
            persist(this.$state)
        }
    }
})


