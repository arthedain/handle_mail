<template>
    <div>

    </div>
</template>

<script>
    export default {
        name: "Table",
        data(){
            return {
                mails: [],
                pagination: {},
            }
        },
        mounted() {
            axios.get('/nova-vendor/handle-mail/mails').then((response)=>{
                this.makePagination(response.data);
                this.mails = response.data.data;
            });
        },
        methods: {
            fetchStories: function (page_url) {
                let vm = this;
                page_url = page_url || '/nova-vendor/handle-mail/mails'
                axios.get(page_url).then((response)=>{
                    vm.makePagination(response.data);
                    vm.mails = response.data.data;
                });
            },
            makePagination: function(data){
                let p = {
                    current_page: data.current_page,
                    last_page: data.last_page,
                    next_page_url: data.next_page_url,
                    prev_page_url: data.prev_page_url,
                    total: data.total,
                    from: data.from,
                    to: data.to,
                }
                this.pagination = p;
            }
        }
    }
</script>

<style scoped>
    .teal{
        color: #38b2ac;
    }
    .teal-hover:hover{
        color: #38b2ac;
    }
</style>
