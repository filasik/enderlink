<script>
import { Button } from '@/components/ui/button';

export default {
  components: { Button },
  props: {
    links_enabled: Boolean,
    discord_link: String,
    instagram_link: String,
    tiktok_link: String,
    youtube_link: String,
  },
  computed: {
    links() {
      return [
        { key: 'discord_link', label: 'Discord', url: this.discord_link },
        { key: 'instagram_link', label: 'Instagram', url: this.instagram_link },
        { key: 'tiktok_link', label: 'TikTok', url: this.tiktok_link },
        { key: 'youtube_link', label: 'YouTube', url: this.youtube_link },
      ];
    },
    filteredLinks() {
      return this.links.filter(link => link.url);
    }
  }
}
</script>

<template>
  <div v-if="links_enabled" class="h-full flex flex-col justify-between rounded-xl border border-sidebar-border/70 dark:border-sidebar-border bg-background">
    <div class="px-4 pt-4 pb-2">
      <div class="font-semibold text-base mb-2 text-foreground">Links</div>
      <div v-if="filteredLinks.length" class="flex flex-col gap-2">
        <Button
          v-for="link in filteredLinks"
          :key="link.key"
          as="a"
          :href="link.url"
          target="_blank"
          rel="noopener"
          variant="outline"
          class="w-full justify-start"
        >
          {{ link.label }}
        </Button>
      </div>
      <div v-else class="text-muted-foreground text-sm">No links available</div>
    </div>
  </div>
</template>