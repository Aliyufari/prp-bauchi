<script setup lang="ts">
import { Head, router } from '@inertiajs/vue3'
import { Pencil } from 'lucide-vue-next'
import SlideOver from '@/components/ui/SlideOver.vue'
import MemberDetails from './components/MemberDetails.vue'
import type { Member } from '@/types/member'

interface Props {
  member: Member
}
const props = defineProps<Props>()

function close() {
  router.visit(route('members.index'), { preserveScroll: true })
}
function edit() {
  router.visit(route('members.edit', props.member.id))
}
</script>

<template>
  <Head title="Member Details" />
  <SlideOver title="Member Details" size="md" side="right" @close="close">
    <MemberDetails :member="member" />

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
          class="inline-flex items-center gap-2 rounded-xl bg-green-700 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-green-800"
        >
          <Pencil class="h-3.5 w-3.5" />
          Edit member
        </button>
      </div>
    </template>
  </SlideOver>
</template>
