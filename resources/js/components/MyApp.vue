<template>
    <div id="main">
        <template v-if="currentUser">
            <Index></Index>
        </template>
        <template v-else>
            <login></login>
        </template>
    </div>
</template>
<script>
import login from '../components/auth/login.vue'
import Index from './home.vue'
export default {
    components: {
        Index,
        login
    },
    name: 'main-app',
    computed: {
        currentUser() {
            return this.$store.getters.currentUser
        }
    }
}
</script>
