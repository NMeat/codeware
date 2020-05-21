<template>
    <div class="message">
        <p>{{ greeting }} world</p>
    </div>
</template>

<script>
export default {
    data: function () {
        return {
            greeting: "hello"
        }
    }
}
</script>

<style scoped>
    /* .message{
        color:red;
        font-size:36px;
        font-weight:blod;
    } */
</style>
