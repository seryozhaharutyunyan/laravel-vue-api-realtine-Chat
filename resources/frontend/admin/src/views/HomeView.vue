<template>
    <div>
        <header-component></header-component>
    </div>
</template>

<script>
import HeaderComponent from "@/components/HeaderComponent";

export default {
    name: 'HomeView',

    components:{
        HeaderComponent: HeaderComponent,
    },
    created() {
        this.$router.push({name: 'chats'});
    }
}
</script>
