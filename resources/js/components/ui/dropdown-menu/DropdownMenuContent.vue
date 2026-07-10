<script setup lang="ts">
import { DropdownMenuContent } from 'reka-ui'
</script>

<template>
    <DropdownMenuContent
        side-offset="8"
        class="z-50 min-w-56 rounded-xl border border-border bg-background p-1 shadow-xl"
    >
        <slot />
    </DropdownMenuContent>
</template>