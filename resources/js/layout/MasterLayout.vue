<template>
    <div :class="{'nav-open': $sidebar.showSidebar}">
        <div class="wrapper">
            <side-bar>
                <mobile-menu slot="content"></mobile-menu>
                <sidebar-link to="/downloads">
                    <i class="nc-icon nc-cloud-download-93"></i>
                    <p>Downloads</p>
                </sidebar-link>
                <sidebar-link to="/uploads">
                    <i class="nc-icon nc-cloud-upload-94"></i>
                    <p>Uploads</p>
                </sidebar-link>
            </side-bar>
            <div class="main-panel">
                <top-navbar></top-navbar>

                <main-content @click="toggleSidebar">

                </main-content>

                <content-footer></content-footer>
            </div>
        </div>
    </div>
</template>
<style lang="scss">
</style>
<script>
  import TopNavbar from './TopNavbar.vue'
  import ContentFooter from './ContentFooter.vue'
  import MainContent from './Content.vue'
  import MobileMenu from './MobileMenu.vue'

  export default {
    components: {
      TopNavbar,
      ContentFooter,
      MainContent,
      MobileMenu
    },
    methods: {
      toggleSidebar() {
        if (this.$sidebar.showSidebar) {
          this.$sidebar.displaySidebar(false)
        }
      }
    }
  }

</script>
