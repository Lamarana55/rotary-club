<template>
    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <router-link class="navbar-brand" to="/">
                    Test 8-Vue 3
                </router-link>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        <li class="nav-item">
                            <router-link class="nav-link" to="login">Login</router-link>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
</template>
<script>
    export default {
        name: 'app-header',
    }
</script>