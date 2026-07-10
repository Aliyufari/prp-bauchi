import type { Component } from 'vue'

export interface DataTableColumn<T = Record<string, unknown>> {
  key: keyof T | string
  label: string
  sortable?: boolean
  sortKey?: string
  searchable?: boolean
  visible?: boolean
  width?: string
  align?: 'left' | 'center' | 'right'
  component?: Component
  formatter?: (value: unknown, row: T) => unknown
}

export interface PaginationMeta {
  current_page: number
  last_page: number
  per_page: number
  total: number
  from: number | null
  to: number | null
}

export interface DataTableResponse<T> {
  data: T[]
  meta: PaginationMeta
}