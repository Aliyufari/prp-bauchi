<script setup lang="ts">
import { DropdownMenuLabel } from 'reka-ui'
</script>

<template>
    <DropdownMenuLabel
        class="px-3 py-2 text-xs font-semibold uppercase tracking-wide text-muted-foreground"
    >
        <slot />
    </DropdownMenuLabel>
</template>