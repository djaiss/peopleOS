<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { Link } from '@inertiajs/vue3';
import { Cog } from 'lucide-vue-next';
import { ArrowRight } from 'lucide-vue-next';
import { Button } from '@/components/ui/button';
import { Plus } from 'lucide-vue-next';

const props = defineProps({
  vaults: Object,
});
</script>

<template>
  <Head title="Dashboard" />

  <AuthenticatedLayout>
    <div class="min-h-[calc(100vh_-_theme(spacing.16))] bg-muted/40">
      <div class="mx-auto max-w-4xl p-8 pt-10">
        <!-- title + cta -->
        <div class="mb-10 items-center justify-between sm:mb-6 sm:flex">
          <h3 class="mb-3 dark:text-slate-200 sm:mb-0">All the vaults in the account</h3>

          <Button>
            <Plus class="mr-2 h-4 w-4" />
            New vault
          </Button>
        </div>

        <div class="vault-list grid grid-cols-1 gap-6 sm:grid-cols-3">
          <!-- vault list -->
          <div v-for="vault in vaults" :key="vault.id" class="rounded-lg border border-gray-200 bg-white dark:border-gray-700 dark:bg-gray-900">
            <div class="vault-detail grid">
              <!-- vault name -->
              <Link :href="vault.url.show" class="border-b border-gray-200 px-3 py-1 text-lg font-medium hover:rounded-t-lg hover:bg-slate-50 dark:border-gray-700 dark:bg-slate-900 dark:text-gray-300 hover:dark:bg-slate-800">
                {{ vault.name }}
              </Link>

              <!-- vault description -->
              <div>
                <p v-if="vault.description" class="p-3 dark:text-gray-300">
                  {{ vault.description }}
                </p>
                <p v-else class="p-3 text-gray-500">No description yet.</p>
              </div>

              <!-- actions -->
              <div class="flex items-center justify-between border-t border-gray-200 px-3 py-2 dark:border-gray-700">
                <Link href="">
                  <Cog class="pointer h-5 w-5 text-gray-400 hover:text-gray-900 dark:text-gray-600 hover:dark:text-gray-100" />
                </Link>

                <Link href="">
                  <ArrowRight class="pointer h-5 w-5 text-gray-400 hover:text-gray-900 dark:text-gray-600 hover:dark:text-gray-100" />
                </Link>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
