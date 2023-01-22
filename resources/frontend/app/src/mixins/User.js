import api from "@/assets/api";

export default {
    data() {
        return {
            user: {},
        }
    },

    computed: {
        url() {
            return this.$store.getters.getUrl;
        }
    },

    methods: {
        getUser() {
            api.post(`${this.url}/auth/me`)
                .then(resolve => {
                    this.user = resolve.data;
                    this.query();
                })
                .catch(error => {
                    console.log(error);
                })
        }
    },

    created() {
        this.getUser();
    }
}
