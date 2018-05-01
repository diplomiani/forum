<template>
    <div class="alert alert-success alert-flash alert-dismissible" v-show="show" role="alert">
      <strong>Success</strong> {{ body }}
    </div>
</template>

<script>
    export default {
        props:['message'],
        data(){
            return {
                body : '',
                show: false
            }
        },
        created(){
            if (this.message) {
                this.body = this.message;
                this.show = true;

                setTimeout(() => {
                    this.show = false
                }, 3000);
            }
        }
    }    
</script>

<style type="text/css">
    .alert-flash{
        position: fixed;
        bottom: 25px;
        right: 25px;
    }
</style>
