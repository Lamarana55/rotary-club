<template>
<div class="loader-wrapper">
    <div class="col-md-4 col-sm-4">
        <div class="loader animation-start">
            <span class="circle delay-1 size-2"></span>
            <span class="circle delay-2 size-4"></span>
            <span class="circle delay-3 size-6"></span>
            <span class="circle delay-4 size-7"></span>
            <span class="circle delay-5 size-7"></span>
            <span class="circle delay-6 size-6"></span>
            <span class="circle delay-7 size-4"></span>
            <span class="circle delay-8 size-2"></span>
        </div>
    </div>
</div>

</template>
<script>
    export default {
        data() {

        },
    }
</script>

<style scoped>
    .loader-wrapper {
        z-index: 4100;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }
</style>
