<script setup lang="ts">
import UserNav from '@/components/navigation/UserNav.vue';
import Search from '@/components/navigation/Search.vue';
import MainNav from '@/components/navigation/MainNav.vue';
import Toaster from '@/components/Toaster.vue';
import { onMounted } from 'vue';
import { flash } from '@/methods';

onMounted(() => {
  if (localStorage.success) {
    flash(localStorage.success, 'success');
    localStorage.removeItem('success');
  }
});

</script>

<template>
  <div class="hidden flex-col md:flex">
    <div class="border-b">
      <div class="flex h-16 items-center px-4">
        <TeamSwitcher />
        <MainNav class="mx-6" />
        <div class="ml-auto flex items-center space-x-4">
          <Search />
          <UserNav />
        </div>
      </div>
    </div>
    <div class="flex-1 space-y-4">
      <slot />
    </div>

    <Toaster />
  </div>
</template>
