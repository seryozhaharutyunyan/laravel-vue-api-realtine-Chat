<template>
    <div>
        <header-component></header-component>
    </div>
    <div class="container mt-3 "><h2>Info</h2></div>
</template>

<script>
import HeaderComponent from "@/components/HeaderComponent";

export default {
    name: "InfoView",
    components:{
        HeaderComponent: HeaderComponent,
    }
}
</script>

<style scoped>

</style>
