import { ref } from 'vue'

export function useSorting() {
    const sortBy = ref('')

    const sortDirection = ref<'asc' | 'desc'>('asc')

    function toggleSort(column: string) {
        if (sortBy.value === column) {
            sortDirection.value =
                sortDirection.value === 'asc'
                    ? 'desc'
                    : 'asc'
        } else {
            sortBy.value = column
            sortDirection.value = 'asc'
        }
    }

    return {
        sortBy,
        sortDirection,
        toggleSort,
    }
}