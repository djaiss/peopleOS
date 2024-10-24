<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { Input } from '@/components/ui/input';
import { ResizableHandle, ResizablePanel, ResizablePanelGroup } from '@/components/ui/resizable';
import { Separator } from '@/components/ui/separator';
import { Tabs, TabsContent, TabsList, TabsTrigger } from '@/components/ui/tabs';
import { TooltipProvider } from '@/components/ui/tooltip';
import { cn } from '@/lib/utils';
import { Search } from 'lucide-vue-next';
import { computed, ref } from 'vue';

const props = defineProps({
  vaults: Object,
  routes: Object,
});

const isCollapsed = ref(false);

function onCollapse() {
  isCollapsed.value = true
}

function onExpand() {
  isCollapsed.value = false
}

</script>

<template>

  <Head title="Dashboard" />

  <AuthenticatedLayout>
    <TooltipProvider :delay-duration="0">
      <ResizablePanelGroup id="resize-panel-group-1" direction="horizontal" class="h-full items-stretch">

        <!-- contact list -->
        <ResizablePanel id="resize-panel-1" :default-size="265" :collapsed-size="4" collapsible :min-size="15"
          :max-size="20" :class="cn(isCollapsed && 'min-w-[50px] transition-all duration-300 ease-in-out')"
          @expand="onExpand" @collapse="onCollapse">
          <Tabs default-value="all">
            <div class="flex items-center px-4 py-2">
              <h1 class="text-xl font-bold">Inbox</h1>
              <TabsList class="ml-auto">
                <TabsTrigger value="all" class="text-zinc-600 dark:text-zinc-200">All mail</TabsTrigger>
                <TabsTrigger value="unread" class="text-zinc-600 dark:text-zinc-200">Unread</TabsTrigger>
              </TabsList>
            </div>
            <Separator />
            <div class="bg-background/95 p-4 backdrop-blur supports-[backdrop-filter]:bg-background/60">
              <form>
                <div class="relative">
                  <Search class="absolute left-2 top-2.5 size-4 text-muted-foreground" />
                  <Input placeholder="Search" class="pl-8" />
                </div>
              </form>
            </div>
            <TabsContent value="all" class="m-0 flex h-full flex-col">
              asdfasfa
            </TabsContent>
            <TabsContent value="unread" class="m-0 flex h-full flex-col">
              sdfsafa
            </TabsContent>
          </Tabs>
        </ResizablePanel>

        <!-- first handle -->
        <ResizableHandle id="resize-handle-1" with-handle />

        <!-- contact profile -->
        <ResizablePanel id="resize-panel-2" :default-size="440" :min-size="30">
          <Tabs default-value="all">
            <div class="flex items-center px-4 py-2">
              <h1 class="text-xl font-bold">Inbox</h1>
              <TabsList class="ml-auto">
                <TabsTrigger value="all" class="text-zinc-600 dark:text-zinc-200">All mail</TabsTrigger>
                <TabsTrigger value="unread" class="text-zinc-600 dark:text-zinc-200">Unread</TabsTrigger>
              </TabsList>
            </div>
            <Separator />
            <div class="bg-background/95 p-4 backdrop-blur supports-[backdrop-filter]:bg-background/60">
              <form>
                <div class="relative">
                  <Search class="absolute left-2 top-2.5 size-4 text-muted-foreground" />
                  <Input placeholder="Search" class="pl-8" />
                </div>
              </form>
            </div>
            <TabsContent value="all" class="m-0">
              asdfasfa
            </TabsContent>
            <TabsContent value="unread" class="m-0">
              sdfsafa
            </TabsContent>
          </Tabs>
        </ResizablePanel>

        <!-- second handle -->
        <ResizableHandle id="resiz-handle-2" with-handle />

        <!-- contact details -->
        <ResizablePanel id="resize-panel-3" :default-size="655">
          asdfsdfs
        </ResizablePanel>
      </ResizablePanelGroup>
    </TooltipProvider>
  </AuthenticatedLayout>
</template>
