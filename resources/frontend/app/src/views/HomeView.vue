<template>
    <div>
        <header-component></header-component>
    </div>
    <router-view></router-view>
</template>

<script>
import HeaderComponent from "@/components/HeaderComponent";

export default {
    name: "HomeView",
    components: {
        HeaderComponent: HeaderComponent,
    },

    watch:{
        "$route"(){
            if(this.$route.name==='home'){
                this.$router.push({name: 'chats'});
            }

        }
    },

    created() {
        this.$router.push({name: 'chats'});
    }
}
</script>

<style scoped>

</style>
