<template>
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h2>DEV</h2>
                </div>
                <div class="col-md-6">
                    <build-list :list="ios.dev"></build-list>
                </div>

                <div class="col-md-6">
                    <build-list :list="android.dev"></build-list>
                </div>
                <div class="clearfix"></div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <h2>STG</h2>
                </div>
                <div class="col-md-6">
                    <build-list :list="ios.stg"></build-list>
                </div>

                <div class="col-md-6">
                    <build-list :list="android.stg"></build-list>
                </div>
                <div class="clearfix"></div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <h2>PROD</h2>
                </div>
                <div class="col-md-6">
                    <build-list :list="ios.prod"></build-list>
                </div>

                <div class="col-md-6">
                    <build-list :list="android.prod"></build-list>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="clearfix"></div>

        </div>
    </div>
</template>
<script>
  import StatsCard from '../components/Cards/StatsCard.vue'
  import BuildList from './BuildList'
  export default {
    components: {
      StatsCard,
      BuildList
    },
    data() {
      return {
        ios: {
          dev: [],
          stg: [],
          prod: [],
        },
        android: {
          dev: [],
          stg: [],
          prod: [],
        }
      }
    },

    created() {
      this.getDownloads('dev', 'ios')
      this.getDownloads('dev', 'android')
      this.getDownloads('stg', 'ios')
      this.getDownloads('stg', 'android')
      this.getDownloads('prod', 'ios')
      this.getDownloads('prod', 'android')
    },

    methods: {
      getDownloads(env, deviceType) {
        let params = {
          params: {env: env, device_type: deviceType}
        }
        this.$http.get('downloads', params)
          .then(res => {
            if (res.data.status) {
              this[deviceType][env] = res.data.data
            }
          })
      }
    }
  }
</script>
<style>

</style>
