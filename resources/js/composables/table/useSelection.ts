import { computed, ref } from 'vue'

export function useSelection() {
    const selected = ref<string[]>([])

    const hasSelection = computed(() => selected.value.length > 0)

    function toggleSelection(id: string) {
        if (selected.value.includes(id)) {
            selected.value = selected.value.filter(item => item !== id)
        } else {
            selected.value.push(id)
        }
    }

    function clearSelection() {
        selected.value = []
    }

    return {
        selected,
        hasSelection,
        toggleSelection,
        clearSelection,
    }
}