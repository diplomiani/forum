<template>
	<div>
		<div v-if="signdIn">
	        <div class="form-group">
	            <textarea 
	            	class="form-control" 
	            	rows="5" 
	            	name="body" 
	            	placeholder="your meesage..."
	            	v-model="body"
	            	required="">			
	            </textarea>
	        </div>
	        <button
	        	type="submit" 
	        	class="btn btn-success"
	        	@click="addReply">Post
	        </button>
	   </div>
		<div v-else>
	   		<p class="text-center">please<a href="/login">sign in</a>to participate this discussen</p>
	   </div>
</div>	   
</template>

<script>
	export default {
		props: ['endpoint'],
		data(){
			return {
				body:'',	
			}
			
		},

		computed: {
			signdIn(){
				return window.App.signdIn;
			}
		},

		methods: {
			addReply(){
				axios.post(this.endpoint , { body:this.body } )
					.then (( {data} ) => {
						this.body = '';

						flash('Your Reply has been posted');
						this.$emit('created', data);
					});
			}
		}

	}
</script>