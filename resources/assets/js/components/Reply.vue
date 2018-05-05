<template>
   
    <div>   
        <div :id="'reply-'+id" class="card-header">
            <div class="level">
                <h5 class="flex">
                    <a :href="'/profiles/' + data.owner.name"
                        v-text="data.owner.name">
                    </a>
                    said {{ data.created_at }}...
                </h5>
                <div v-if="signdIn">
                    <favorite :reply="data"></favorite>    
                </div>
                
            </div>


        </div>
        <div class="card-body">
                <div v-if="editing">
                    <div class="form-group">
                        <textarea class="form-control" v-model="body">{{ data.body }}</textarea>
                    </div>  
                    <button class="btn btn-primary btn-xs" @click="update">Update</button>
                    <button class="btn btn-link btn-xs" @click="editing = false">Cancel</button>
                </div>
            
            <div v-else v-text="body"></div>
        </div>

        <div class="card-footer level" v-if="canUpdate">
            <button class="btn btn-info btn-xs mr-1" @click="editing = true">edit</button>
            <button class="btn btn-danger btn-xs mr-1" @click="destroy">Delete</button>
        </div>
    </div>
</template>
<script>
	import Favorite from './Favorite.vue';
    export default {
    	props: ['data'],

    	components: { Favorite },
    	
        data(){
            return {
                editing: false,
                id: this.data.id,
                body: this.data.body
            };
        },

        computed: {
            signdIn(){
                return window.App.signdIn;
            },

            canUpdate(){
                return this.authorize( user => this.data.user_id == user.id );
            }
        },

        methods: {
        	update(){
        		axios.patch('/replies/' + this.data.id, {
        			body:this.body
        		});
        		this.editing=false;

        		flash('updated!')
        	},

        	destroy(){
        		axios.delete('/replies/' + this.data.id);

                this.$emit('deleted', this.data.id);
        		// $(this.$el).fadeOut(300, () => {
        		// 	flash('your reply has been deleted');
        		// });
        	}
        }
        
    }    
</script>
  