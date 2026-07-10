<script setup lang="ts">
import { DropdownMenuItem } from 'reka-ui'
</script>

<template>
    <DropdownMenuItem
        class="flex cursor-pointer items-center gap-2 rounded-lg px-3 py-2 text-sm outline-none transition hover:bg-muted focus:bg-muted"
    >
        <slot />
    </DropdownMenuItem>
</template>