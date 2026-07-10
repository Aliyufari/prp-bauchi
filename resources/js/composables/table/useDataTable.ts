import { useFiltering } from './useFiltering'
import { usePagination } from './usePagination'
import { useSelection } from './useSelection'
import { useSorting } from './useSorting'

export function useDataTable() {
    return {
        ...useFiltering(),
        ...usePagination(),
        ...useSorting(),
        ...useSelection(),
    }
}