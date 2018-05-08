<template>

	<div>
		<ul class="pagination justify-content-end" v-if="shouldPaginate">
		    <li class="page-item" v-show="prevUrl">
		      <a class="page-link" @click.prevent="page--">Previous</a>
		    </li>
		    <li class="page-item" v-show="nextUrl">
		      <a class="page-link" @click.prevent="page++">Next</a>
		    </li>
		  </ul>
	</div>
	
</template>

<script type="text/javascript">
	export default {
		props:['dataSet'],
		data(){
			return {
				page:1,
				prevUrl: false,
				nextUrl: false,
			}
		},

		watch: {
			dataSet(){
				this.page = this.dataSet.current_page;
				this.prevUrl = this.dataSet.prev_page_url;
				this.nextUrl = this.dataSet.next_page_url;
			},

			page(){
				this.broadcast().updateUrl();
			}
		},

		computed:{
			shouldPaginate(){
				return !! this.prevUrl || !! this.nextUrl;
			}
		},

		methods:{
			broadcast(){
				this.$emit('update',this.page);
				return this;
			},

			updateUrl(){
				history.pushState(null, null, '?page=' + this.page );
			}
		}
	}
</script>