<script setup lang="ts">
import { Head, router } from '@inertiajs/vue3'
import { Pencil } from 'lucide-vue-next'
import SlideOver from '@/components/ui/SlideOver.vue'
import MemberDetails from './components/MemberDetails.vue'
import type { Member } from '@/types/member'

interface Props {
  member: Member | null 
}
const props = defineProps<Props>()

const emit = defineEmits<{
  (e: 'close'): void
}>()

function close() {
  emit('close')
}

function edit() {
  if (props.member) {
    router.visit(route('members.edit', props.member.id))
  }
}
</script>

<template>
  <Head title="Member Details" v-if="member" />
  <SlideOver title="Member Details" size="md" side="right" @close="close">
    
    <MemberDetails v-if="member" :member="member" />

    <template #footer>
      <div class="flex items-center justify-end gap-3">
        <button
          type="button"
          @click="close"
          class="rounded-xl px-4 py-2 text-sm font-semibold text-gray-500 transition hover:bg-gray-100"
        >
          Close
        </button>
        <button
          type="button"
          @click="edit"
          :disabled="!member"
          class="inline-flex items-center gap-2 rounded-xl bg-green-700 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-green-800 disabled:opacity-50"
        >
          <Pencil class="h-3.5 w-3.5" />
          Edit member
        </button>
      </div>
    </template>
  </SlideOver>
</template>