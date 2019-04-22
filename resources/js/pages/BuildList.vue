<template>
    <div>
        <a v-for="(build, idx) in list" :key="idx" :href="build.app_download_url">
            <stats-card>
                <div slot="header" class="icon-warning">
                    <i class="nc-icon" :class="[{'text-success': build.is_latest_version === 1}, build.device_type === 'ios' ? 'nc-apple' : 'nc-android']"></i>
                </div>
                <div slot="content">
                    <p class="card-category">Version {{build.version}}</p>
                    <h4 class="card-title">Build {{build.build}}</h4>
                </div>
                <div slot="footer">
                    <i class="fa fa-clock-o"></i>{{build.created_at}}
                </div>
            </stats-card>
        </a>
    </div>
</template>
<script>
  import StatsCard from '../components/Cards/StatsCard.vue'

  export default {
    props: ['list'],

    components: {
      StatsCard
    }
  }
</script>

<style lang="scss">
    a {
        color: #000;
        &:hover{
            color: red;
        }
    }
</style>